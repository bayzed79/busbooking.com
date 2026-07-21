<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Ticket - {{ $order->transaction_id }}</title>
    <style>
        @page {
            margin: 0;
            size: A4 portrait;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1e293b;
            background-color: #ffffff;
            margin: 0;
            padding: 30px 40px;
            font-size: 13px;
            line-height: 1.5;
        }

        /* Container Card */
        .ticket-wrapper {
            border: 2px solid #2563eb;
            border-radius: 12px;
            overflow: hidden;
            background: #ffffff;
        }

        /* Header Header */
        .header-bar {
            background: #2563eb;
            color: #ffffff;
            padding: 20px 25px;
        }

        .brand-title {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 1px;
            margin: 0;
        }

        .ticket-type-badge {
            float: right;
            background: #10b981;
            color: #ffffff;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Hero Journey Banner */
        .journey-banner {
            background: #f8fafc;
            border-bottom: 1.5px dashed #cbd5e1;
            padding: 18px 25px;
        }

        .route-title {
            font-size: 20px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 5px;
        }

        .journey-meta {
            color: #64748b;
            font-size: 12px;
        }

        /* Content Sections */
        .content-section {
            padding: 20px 25px;
        }

        .section-heading {
            font-size: 14px;
            font-weight: bold;
            color: #2563eb;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        /* Data Tables */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .info-table td {
            padding: 8px 10px;
            vertical-align: top;
        }

        .label {
            color: #64748b;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .value {
            color: #0f172a;
            font-size: 13px;
            font-weight: 600;
        }

        /* Seat & Fare Breakdown Table */
        .fare-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .fare-table th {
            background: #f1f5f9;
            color: #475569;
            font-size: 11px;
            text-transform: uppercase;
            text-align: left;
            padding: 8px 12px;
            border-bottom: 2px solid #cbd5e1;
        }

        .fare-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
        }

        .seat-pill {
            display: inline-block;
            background: #2563eb;
            color: #ffffff;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 12px;
            margin-right: 4px;
        }

        /* QR Code & Verification Stub */
        .verification-stub {
            background: #f8fafc;
            border-top: 2px dashed #cbd5e1;
            padding: 20px 25px;
        }

        .qr-box {
            float: right;
            text-align: center;
        }

        .notice-list {
            margin: 0;
            padding-left: 18px;
            color: #475569;
            font-size: 11px;
        }

        .notice-list li {
            margin-bottom: 4px;
        }

        .footer-note {
            text-align: center;
            font-size: 10px;
            color: #94a3b8;
            margin-top: 20px;
        }

        .clear {
            clear: both;
        }
    </style>
</head>
<body>

    <div class="ticket-wrapper">
        <!-- Top Header Bar -->
        <div class="header-bar">
            <span class="ticket-type-badge">CONFIRMED (PAID)</span>
            <div class="brand-title">JatraPoth E-TICKET</div>
            <div style="font-size: 11px; opacity: 0.9; margin-top: 2px;">Official Passenger Boarding Pass</div>
        </div>

        <!-- Hero Journey Route Banner -->
        <div class="journey-banner">
            <div class="route-title">
                {{ $bus->starting_point ?? 'Origin' }} &nbsp;to&nbsp; {{ $bus->ending_point ?? 'Destination' }}
            </div>
            <div class="journey-meta">
                Date of Journey: <strong>{{ $bus->date ?? 'N/A' }}</strong> &nbsp;|&nbsp; 
                Departure Time: <strong>{{ $bus->departing_time ?? 'N/A' }}</strong> &nbsp;|&nbsp; 
                Coach: <strong>{{ $bus->coach_no ?? 'N/A' }}</strong> ({{ $bus->coach_type ?? 'AC' }})
            </div>
        </div>

        <!-- Main Ticket Details Grid -->
        <div class="content-section">
            <div class="section-heading">Passenger & Booking Information</div>
            
            <table class="info-table">
                <tr>
                    <td width="50%">
                        <div class="label">Passenger Name</div>
                        <div class="value">{{ $order->name }}</div>
                    </td>
                    <td width="50%">
                        <div class="label">Transaction ID</div>
                        <div class="value" style="color: #2563eb;">{{ $order->transaction_id }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="label">Mobile Number</div>
                        <div class="value">{{ $order->phone }}</div>
                    </td>
                    <td>
                        <div class="label">Booking Date & Time</div>
                        <div class="value">{{ $order->created_at ? $order->created_at->format('d M Y, h:i:s A') : date('d M Y') }}</div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div class="label">Email Address</div>
                        <div class="value">{{ $order->email }}</div>
                    </td>
                    <td>
                        <div class="label">Operator Name</div>
                        <div class="value">{{ $bus->bus_name ?? 'JatraPoth Express' }}</div>
                    </td>
                </tr>
            </table>

            <!-- Seat & Fare Table -->
            <div class="section-heading">Booked Seats & Payment Breakdown</div>
            <table class="fare-table">
                <thead>
                    <tr>
                        <th>Booked Seats</th>
                        <th>Coach Class</th>
                        <th>Fare / Seat</th>
                        <th style="text-align: right;">Total Paid Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            @php
                                $seats = is_array($ticketlist) ? $ticketlist : json_decode($ticketlist, true);
                                if (!is_array($seats)) { $seats = [$order->ticketlist]; }
                            @endphp
                            @foreach($seats as $seat)
                                <span class="seat-pill">{{ $seat }}</span>
                            @endforeach
                        </td>
                        <td>{{ $bus->coach_type ?? 'Standard' }}</td>
                        <td>BDT {{ number_format(floatval($bus->fare)) }}</td>
                        <td style="text-align: right; font-weight: bold; color: #10b981; font-size: 15px;">
                            BDT {{ number_format(floatval($order->amount)) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Verification & Boarding Stub -->
        <div class="verification-stub">
            <div class="qr-box">
                @php
                    $qrData = "Ticket:" . $order->transaction_id . "|Bus:" . ($bus->coach_no ?? '101') . "|Seats:" . implode(',', $seats);
                @endphp
                <img src="data:image/svg+xml;base64,{!! base64_encode(SimpleSoftwareIO\QrCode\Facades\QrCode::size(120)->generate($qrData)) !!}" alt="QR Code" width="120" height="120">
                <div style="font-size: 9px; color: #64748b; margin-top: 4px;">Scan at Boarding Gate</div>
            </div>

            <div style="margin-right: 140px;">
                <div style="font-weight: bold; color: #0f172a; margin-bottom: 6px;">Important Passenger Guidelines:</div>
                <ol class="notice-list">
                    <li>Please report at the boarding counter at least <strong>20 minutes prior</strong> to departure time.</li>
                    <li>Present this printed E-Ticket or digital PDF along with a valid photo ID (NID/Passport/Student ID).</li>
                    <li>Luggage allowance is up to 20kg per passenger. Excess luggage is subject to operator fees.</li>
                    <li>For support or queries, contact JatraPoth Helpline: <strong>+880 1995-46531</strong> or email <strong>hafizursiam@gmail.com</strong>.</li>
                </ol>
            </div>
            <div class="clear"></div>
        </div>
    </div>

    <div class="footer-note">
        This is a computer-generated official ticket document. No manual signature required. &copy; {{ date('Y') }} JatraPoth.com
    </div>

</body>
</html>


