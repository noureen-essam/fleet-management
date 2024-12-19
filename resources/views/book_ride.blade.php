<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Book Ride') }}
        </h2>
    </x-slot>
    <head>
        <title>Available Trips</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
        <meta name="csrf-token" content="{{ csrf_token() }}">

    </head>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="container mt-5">
                        <h2>Select Trip</h2>
                        <form id="trip-form" >
                            <div class="mb-3">
                                <label for="start_station" class="form-label">Start Station</label>
                                <select class="form-select" id="start_station" name="start_station" required>
                                    <option value="">Select Start Station</option>
                                    @foreach($stations as $station)
                                        <option value="{{ $station->id }}">{{ $station->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="end_station" class="form-label">End Station</label>
                                <select class="form-select" id="end_station" name="end_station" required>
                                    <option value="">Select End Station</option>
                                    @foreach($stations as $station)
                                        <option value="{{ $station->id }}">{{ $station->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" id="search-trips" class="btn btn-primary">Search Trip Routes</button>
                        </form>

                        <form id="line-form" >
                            <h3 class="mt-5">Available Routes(Lines)</h3>
                            <select class="form-select" id="line_list" name="line_list" onchange="getTripsOfSelectedLine(event)">
                                <!-- Lines will be displayed here -->
                            </select>
                        </form>

                        <form id="trip-book-form" >
                            <div class="mb-3">
                                <h3 class="mt-5">Available Trips</h3>
                                <select class="form-select" id="Trip_list" name="Trip_list"  onchange="getSeatsValue(event)">
                                    <!-- Trips will be displayed here -->
                                </select>
                            </div>
                            <div class="mb-3">
                                <h3 class="mt-5">Available Seats</h3>
                                <select class="form-select" id="seats_list" name="seats_list"  >
                                    <!-- Seats will be displayed here -->
                                </select>
                            </div>
                            <button type="submit" id="book-trip" class="btn btn-primary">Book Trip</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#search-trips').click(function(e) {
                e.preventDefault();

                console.log('search-trips');
                const startStation = $('#start_station').val();
                const endStation = $('#end_station').val();
                console.log(startStation);
                console.log(endStation);

                if (!startStation || !endStation) {
                    alert('Please select both start and end stations.');
                    return;
                }
                let form = $('#trip-form')[0];
                let data = new FormData(form);

                // Fetch available trips
                $.ajax({
                    url: "{{ route('getlines') }}",
                    method: 'POST',
                    data : data,
                    dataType:"JSON",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData : false,
                    contentType:false,
                    success: function(response) {
                        console.log(response);
                        $('#line_list').empty();

                        $('#seats_list').empty();

                        $('#Trip_list').empty();
                        if (response.length > 0) {
                            response.forEach(function(line) {
                                $("#line_list").append('<option class="list-group-item">select Line.</option>');
                                $("#line_list").append('<option value="' + line.id + '">' + line.name + ' </option>');
                            });
                        } else {
                            $('#line_list').append('<option class="list-group-item">No seats available.</option>');

                            $('#seats_list').empty();

                            $('#Trip_list').empty();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(error);

                    }
                });
            });



            $('#book-trip').click(function(e) {
                e.preventDefault();

                const startStation = $('#start_station').val();
                const endStation = $('#end_station').val();
                const trip_id = $('#Trip_list').val();
                const seat_id = $('#seats_list').val();

                if (!startStation || !endStation || !trip_id || !seat_id) {
                    alert('Please complete fields.');
                    return;
                }

                $.ajax({
                    method: 'POST',
                    url: '/book/trip',
                    data: {
                        start_station: startStation,
                        end_station: endStation,
                        trip_id: trip_id,
                        seat_id: seat_id
                    },
                    success: function(response) {
                        window.location = "/dashboard";
                    },
                    error: function(xhr, status, error) {
                        console.log(error);
                    }
                });
            });


        });


        function getTripsOfSelectedLine(event) {
            console.log("Value: " + event.target.value + "; Display: " + event.target[event.target.selectedIndex].text + ".");
            console.log(event.target.value);

            let form = $('#line-form')[0];
            let data = new FormData(form);
            $line_id = event.target.value;

            // Fetch available trips
            $.ajax({
                url: "{{ route('gettrips') }}",
                method: 'POST',
                data: data,
                dataType:"JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                processData : false,
                contentType:false,

                success: function(response) {
                    console.log('hey');
                    console.log(response);
                    $('#Trip_list').empty();
                    if (response.length > 0) {
                        response.forEach(function(trip) {
                            $("#Trip_list").append('<option class="list-group-item">select Trip.</option>');
                            $("#Trip_list").append('<option value="' + trip.id + '">' + 'Bus : ' + trip.bus.plate_number +' Dep Time: ' + trip.dep_time+  ' </option>');
                        });
                    } else {
                        $('#Trip_list').append('<option class="list-group-item">No trips available.</option>');
                    }
                },
                error: function(xhr, status, error) {
                    console.log(error);

                }
            });

        }

        function getSeatsValue(event) {
            console.log("Value: " + event.target.value + "; Display: " + event.target[event.target.selectedIndex].text + ".");
            console.log(event.target.value);

            $trip_id = event.target.value;
            const startStation = $('#start_station').val();
            const endStation = $('#end_station').val();
            const lineId = $('#line_list').val();
            if(! isNaN($trip_id)) {

                $.ajax({
                    method: 'POST',
                    url: '/get/seats',
                    data: {
                        start_station: startStation,
                        end_station: endStation,
                        trip_id: $trip_id,
                        line_id: lineId
                    },
                    success: function (response) {
                        console.log('hey');
                        console.log(response);

                        $('#seats_list').empty();

                        if (response.length > 0) {
                            $("#seats_list").append('<option class="list-group-item">select Seat.</option>');
                            response.forEach(function (seat) {
                                $("#seats_list").append('<option value="' + seat.id + '">' + seat.seat_number + ' </option>');
                            });
                        } else {

                            $('#seats_list').append('<option class="list-group-item">No Seat available.</option>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.log(error);

                    }
                });
            }else{

                $('#seats_list').empty();
            }

        }


    </script>

</x-app-layout>
