<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Reservation System</title>
    <link rel="stylesheet" href="{{ asset('css/homeview.css') }}">
</head>
<body>

<form action="search.php" method="GET">
    <label for="origin">Origin:</label>
    <input type="text" id="origin" name="origin" list="cityList" placeholder="Choose a destinaiton" required>

    <label for="destination">Destination:</label>
    <input type="text" id="destination" name="destination" list="cityList" placeholder="Choose a destinaiton" required>

    <datalist id="cityList">
        <option value="Barishal">
        <option value="Chattogram">
        <option value="Dhaka">
        <option value="Khulna">
        <option value="Rajshahi">
        <option value="Rangpur">
        <option value="Mymensingh">
        <option value="Sylhet">
    </datalist>

    <label for="depart-date">Departure Date:</label>
    <input type="date" id="depart-date" name="depart-date" required>

    <label for="return-date">Return Date:</label>
    <input type="date" id="return-date" name="return-date">

    <input type="submit" value="Search Bus">
</form>

<script src="{{ asset('js/homeview.js') }}"></script>

</body>
</html>
