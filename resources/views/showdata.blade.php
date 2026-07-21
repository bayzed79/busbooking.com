@extends('admin.layout')
@section('navbar')
<ul class="navbar-nav ms-auto">

    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin_show_all_user') }}">Users</a>
    </li>
    <li class=" nav-item">
        <a class="nav-link" href="{{ route('adminOrders') }}">Orders</a>
    </li>
    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">Add Bus</a>
    </li> --}}
    <li class="nav-item dropdown">
        <a class="btn btn-primary dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            Show Bus
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{ route('admin_seat_info_button')}}">Seat View</a></li>
            <li><a class="dropdown-item" href="{{ url('createdata') }}">Add Bus</a></li>
        </ul>
    </li>
    <li class="nav-item">
        <form action="{{ route('admin.dashboard') }}" method="GET">
            @csrf
            <button type="submit" class="btn btn-link nav-link">Logout</button>
        </form>

    </li>
</ul>


@endsection
@section('content')

<div class="container mt-5">


    @if (Session::has('msg'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ Session::get('msg') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ url('createdata') }}" class="btn btn-primary">Add Bus</a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Bus Name</th>
                    <th>Departing Time</th>
                    <th>Coach-No</th>
                    <th>Starting Point</th>
                    <th>Ending Point</th>
                    <th>Fare</th>
                    <th>Coach Type</th>
                    <th>Seats Available</th>
                    {{-- <th>View</th> --}}
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($showdata as $key => $value)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $value->bus_name }}</td>
                    <td>{{ $value->departing_time }}</td>
                    <td>{{ $value->coach_no }}</td>
                    <td>{{ $value->starting_point }}</td>
                    <td>{{ $value->ending_point }}</td>
                    <td>{{ $value->fare }}</td>
                    <td>{{ $value->coach_type }}</td>
                    <td>{{ $value->seats_available }}</td>
                    {{-- <td>{{ $value->view }}</td> --}}
                    <td>
                        <a href="{{ url('editdata', ['id' => $value->id]) }}"
                            class="btn btn-success btn-sm mb-1">Edit</a>

                        <form id="delete-form-{{ $value->id }}" action="{{ route('bus.destroy', $value->id) }}"
                            method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>

                        <button type="button" class="btn btn-danger btn-sm" onclick="event.preventDefault();
                            if(confirm('Are you sure you want to delete this bus record?')) {
                                document.getElementById('delete-form-{{ $value->id }}').submit();
                            }">
                            Delete
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    {{ $showdata->links() }}

</div>

@endsection