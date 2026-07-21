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
            Seat Info
        </a>
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="{{ url('showdata') }}">Buslist</a></li>
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
<style>
    .seatview {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
        grid-gap: 10px;
    }

    .seat {
        border: 1px solid black;
        padding: 10px;
        text-align: center;
    }

    .available {
        background-color: lightgreen;
    }

    .selected {
        background-color: lightblue;
    }

    .unavailable {
        background-color: gray;
        cursor: not-allowed;
    }

    .disabled {
        background-color: lightgray;
    }

    /* Center the table in the middle of the container */
    /* .container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        /* Full viewport height */
    /* } */

    */ table {
        border-collapse: collapse;
    }

    td {
        padding: 5px;
    }
</style>

@section('content')
<div class="container mt-5" style="display: flex; flex-direction: column; align-items: center;">
    <form action="#" method="GET">
        <div class="form-group row">
            <table>
                @php
                $view = $bus->view;
                $index = 0;
                $rows = range('A', 'J');
                $columns = range(1, 4); // Column labels
                @endphp

                @foreach ($rows as $row)
                <tr>
                    @foreach ($columns as $column)
                    @php
                    $name = $row . $column;
                    @endphp
                    <td>
                        {{-- <input type="checkbox" id="{{ $index }}" name="{{ $name }}" value="1"
                            class="form-check-input">
                        <label for="{{ $name }}" class="form-check-label">{{ $name }}</label> --}}
                        @if ($view[$index] == '1')
                        <div class="seat unavailable">
                            <input type="checkbox" id="{{ $index }}" name="{{ $name }}" value="1" disabled>
                            <label for="{{ $name }}">{{ $name }}</label>
                        </div>
                        @else
                        <div class="seat available">
                            <input type="checkbox" id="{{ $index }}" name="{{ $name }}" value="1">
                            <label for="{{ $name }}">{{ $name }}</label>
                        </div>
                        @endif
                    </td>
                    @php
                    $index = $index + 1;
                    @endphp
                    @endforeach

                </tr>
                @endforeach
            </table>
        </div>

    </form>
</div>


@endsection