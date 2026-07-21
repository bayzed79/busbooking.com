<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/editdata.css') }}">
    <title>Edit Bus Information</title>
</head>

<body>
    <div class="container">
        <h2>Edit Bus Information</h2>
        <form action="{{ route('bus.update', ['bus' => $bus->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="bus_name">Departing Time:</label><br>
            <input type="text" id="bus_name" name="bus_name" value="{{ $bus->bus_name }}"><br><br>

            <label for="departing_time">Departing Time:</label><br>
            <input type="text" id="departing_time" name="departing_time" value="{{ $bus->departing_time }}"><br><br>

            <label for="coach_no">Coach Number:</label><br>
            <input type="text" id="coach_no" name="coach_no" value="{{ $bus->coach_no }}"><br><br>

            <label for="starting_point">Starting Point:</label><br>
            <input type="text" id="starting_point" name="starting_point" value="{{ $bus->starting_point }}"><br><br>

            <label for="ending_point">Ending Point:</label><br>
            <input type="text" id="ending_point" name="ending_point" value="{{ $bus->ending_point }}"><br><br>

            <label for="fare">Fare:</label><br>
            <input type="text" id="fare" name="fare" value="{{ $bus->fare }}"><br><br>

            <label for="coach_type">Coach Type:</label><br>
            <input type="text" id="coach_type" name="coach_type" value="{{ $bus->coach_type }}"><br><br>

            <label for="seats_available">Seats Available:</label><br>
            <input type="text" id="seats_available" name="seats_available" value="{{ $bus->seats_available }}"><br><br>
            <input type="submit" value="Update">
        </form>
    </div>
</body>

</html>