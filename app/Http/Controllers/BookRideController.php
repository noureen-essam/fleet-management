<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Bookings;
use App\Models\Line;
use App\Models\LineStations;
use App\Models\Seats;
use App\Models\Stations;
use App\Models\Trip;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;


class BookRideController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function index(): View
    {
        $stations = Stations::all();
        return view('book_ride', [
            'stations' => $stations,
        ]);
    }

    public function getAvailableLines(Request $request)
    {

        $request->validate([
            'start_station' => 'required|exists:stations,id',
            'end_station' => 'required|exists:stations,id',
        ]);

        $startStationId = $request->start_station;
        $endStationId = $request->end_station;

        $lines = Line::whereHas('lineStations', function ($query) use ($startStationId) {
            $query->where('station_id', $startStationId);
        })
        ->whereHas('lineStations', function ($query) use ($endStationId){
            $query->where('station_id', $endStationId);
        })
            //->where('lineStations1.stop_order', '<', 'lineStations1.stop_order')
        ->get();


        return response()->json($lines);
    }

    public function getAvailableTrips(Request $request)
    {

        $line_id = $request->line_list;

        $trips = Trip::where('line_id', $line_id)->get();

        return response()->json(  $trips);
    }
    public function getSeats(Request $request)
    {

        $tripId = $request->trip_id;

        $trip = Trip::findOrFail($tripId);
        $seats = Seats::where('bus_id', $trip['bus_id'])->get();


        return response()->json( $seats);
    }
    public function bookTrip(Request $request)
    {
        $startStation = $request->start_station;
        $endStation = $request->end_station;
        $tripId = $request->trip_id;

//        $booking = new Bookings();
//        $booking->start_line_station_id= $startStation;
//        $booking->end_line_station_id= $endStation;
//        $booking->trip_id= $tripId;
//        $booking->save();



        return response()->json( );
    }



}
