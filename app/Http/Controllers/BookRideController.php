<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Line;
use App\Models\LineStations;
use App\Models\Seats;
use App\Models\Stations;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;


class BookRideController extends Controller
{
    /**
     * Display Book Ride form.
     */
    public function index(): View
    {
        $stations = Stations::all();
        return view('book_ride', [
            'stations' => $stations,
        ]);
    }

    /**
     * get all available routes(line) that pass with both start and end station.
     */
    public function getAvailableLines(Request $request)
    {

        $request->validate([
            'start_station' => 'required|exists:stations,id',
            'end_station' => 'required|exists:stations,id',
        ]);

        $startStationId = $request->start_station;
        $endStationId = $request->end_station;

        $lines = DB::table('line')->select('line.*')
            ->Join('line_stations as start_line_station', 'Line.id', '=', 'start_line_station.line_id')
            ->Join('line_stations as end_line_station','Line.id', '=', 'end_line_station.line_id')
            ->where('start_line_station.id', $startStationId)
            ->where('end_line_station.id', $endStationId)
            ->whereRaw('start_line_station.stop_order <= end_line_station.stop_order')
            ->get();

            return response()->json($lines);
    }

    /**
     * get all available Trips for the selected line (route).
     */
    public function getAvailableTrips(Request $request)
    {
        $request->validate([
            'line_list' => 'required|exists:line,id',
        ]);


        $line_id = $request->line_list;

        $trips = Trip::where('line_id', $line_id)->get();

        return response()->json(  $trips);
    }

    /**
     * get all available Seats for the selected trip Bus.
     */
    public function getSeats(Request $request)
    {

        $request->validate([
            'trip_id' => 'required|exists:trip,id',
        ]);

        $tripId = $request->trip_id;
        $startStation = $request->start_station;
        $endStation = $request->end_station;
        $lineId = $request->line_id;

        $trip = Trip::findOrFail($tripId);

        // get all available Seats for the selected trip Bus
        $startLineStation = LineStations::where('line_id', $lineId)->where('station_id', $startStation)->first();
        $startLineStationOrder = $startLineStation->stop_order;
        $endLineStation = LineStations::where('line_id', $lineId)->where('station_id', $endStation)->first();
        $endLineStationOrder = $endLineStation->stop_order;

        // get all Booked Seats for the selected trip
        // where stop order of start and end station of booked trip intersects with stop order of start and end station of user
        $bookings = Bookings::select('Bookings.seat_id')->where('trip_id', $tripId)
            ->leftJoin('line_stations as start_line_station', 'start_line_station.id', '=', 'Bookings.start_line_station_id')
            ->leftJoin('line_stations as end_line_station','end_line_station.id', '=', 'Bookings.end_line_station_id')
            ->where(function ($query) use ($startLineStationOrder, $endLineStationOrder) {
                $query->whereBetween('start_line_station.stop_order', [$startLineStationOrder, $endLineStationOrder])
                    ->orWhereBetween('end_line_station.stop_order',[$startLineStationOrder, $endLineStationOrder])
                    ->orWhere(function ($subQuery)  use ($startLineStationOrder, $endLineStationOrder){
                        $subQuery->where('start_line_station.stop_order', '<', $startLineStationOrder)
                            ->where('end_line_station.stop_order', '>', $endLineStationOrder);
                    });
            })
            ->pluck('Bookings.seat_id');

        // get all available seats except the booked seats
        $seats = Seats::whereNotIn('id', $bookings)->where('bus_id', $trip['bus_id'])->get();


        return response()->json( $seats);
    }

    /**
     * Book trip for the loggedin user with selected data in the form.
     */
    public function bookTrip(Request $request)
    {
        $startStation = $request->start_station;
        $endStation = $request->end_station;
        $tripId = $request->trip_id;
        $seatId = $request->seat_id;
        $user = Auth::user();


        $booking = new Bookings();
        $booking->start_line_station_id= $startStation;
        $booking->end_line_station_id= $endStation;
        $booking->trip_id= $tripId;
        $booking->seat_id= $seatId;
        $booking->user_id= $user->id;
        $booking->save();



        return response()->json( $request);
    }



}
