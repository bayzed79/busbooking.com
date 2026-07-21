@extends('mainlayout')
@section('content')
<h2>Buses Information</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Date</th>
            <th>Bus Name</th>
            <th>Departing Time</th>
            <th>Coach No</th>
            <th>Starting Point</th>
            <th>Ending Point</th>
            <th>Fare</th>
            <th>Coach Type</th>
            <th>Available</th>
            <th>Total</th>
            <th>View</th>
            {{-- <th>Created At</th>
            <th>Updated At</th> --}}
        </tr>
    </thead>
    <tbody>
        @foreach ($buses as $key => $bus)
        <tr>

            <td>{{ $key + 1 }}</td>
            <td>{{ $bus->date }}</td>
            <td>{{ $bus->bus_name }}</td>
            <td>{{ $bus->departing_time }}</td>
            <td>{{ $bus->coach_no }}</td>
            <td>{{ $bus->starting_point }}</td>
            <td>{{ $bus->ending_point }}</td>
            <td>{{ $bus->fare }}</td>
            <td>{{ $bus->coach_type }}</td>
            <td>{{ $bus->seats_available }}</td>
            <td>{{ $bus->total_seats }}</td>
            <td><a href="{{ route('seat_view', ['id' => $bus->id]) }}">View</a></td>
            {{-- <td>{{ $bus->created_at }}</td>
            <td>{{ $bus->updated_at }}</td> --}}
        </tr>
        @endforeach

    </tbody>
</table>
@endsection