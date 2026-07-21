@extends('mainlayout')
{{-- a $bus variable is passed here --}}
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
</style>
@section('content')
<div class="container mt-5" style="display: flex; flex-direction: column; align-items: center;">
    @php
    $view = $bus->view;
    $prices = $bus->fare;
    $price = (int) $prices;
    // $price = integer value of $prices
    @endphp

    {{-- <h2>{{ $view }}</h2> --}}
    <div class="row">
        <div class="col-5">
            <p> Available: {{ $bus->seats_available }} Total : {{ $bus->total_seats }}</p>
            @if (Session::has('error'))
            <div class="alert alert-danger"> {{ Session::get('error') }}</div>
            @endif
            <input type="hidden" id="sohel" name="bus_id" value={{ $price }}>

            <form action="{{ route('payment_details') }} " method="GET">
                <input type="hidden" name="id" value="{{ $bus->id }}">
                <div class="form-group row">
                    <table>
                        @php
                        $total_seats = $bus->total_seats;
                        $index = 0;
                        $rows = range('A', 'Z');
                        $columns = range(1, 4); // Column labels
                        @endphp

                        @foreach ($rows as $row)
                        @foreach ($columns as $column)
                        @php
                        $name = $row . $column;
                        @endphp
                        <td>
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

                        @if ($index == $total_seats)
                        @break
                        @endif
                        @endforeach

                        @if ($index == $total_seats)
                        @break
                        @endif
                        </tr>
                        @endforeach
                    </table>
                </div>




                <button type="submit" class="btn btn-primary mt-3">Submit</button>
            </form>
        </div>
        <div class="col mt-5 bg-success ms-4" style="height: 400px">
            <h4>Selected Tickets:</h4>
            <div id="selected-tickets"></div>
            <h4>Total Price:</h4>
            <div id="total-price">$0</div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.seat.available input[type="checkbox"]');
        const selectedTicketsDiv = document.getElementById('selected-tickets');
        const totalPriceDiv = document.getElementById('total-price');
        let selectedTickets = [];
        let totalPrice = 0;

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const seatName = checkbox.name;
                // let price = {
                //     !!$price!!
                // };
                // const price = "<?php echo $price; ?>";
                // var price = {
                //     !!json_encode($price) !!
                // };
                let price = document.getElementById('sohel').value;



                price = parseInt(price);
                // let price = 160;
                // console.log(price);

                if (checkbox.checked) {
                    selectedTickets.push(seatName);
                    totalPrice += price;
                } else {
                    selectedTickets = selectedTickets.filter(ticket => ticket !== seatName);
                    totalPrice -= price;
                }

                updateDisplay();
            });
        });

        function updateDisplay() {
            selectedTicketsDiv.innerHTML = selectedTickets.length > 0 ? selectedTickets.join(', ') : 'None';
            totalPriceDiv.innerHTML = `BDT ${totalPrice.toFixed(2)}`;
        }

        updateDisplay();
    });

</script>
@endsection