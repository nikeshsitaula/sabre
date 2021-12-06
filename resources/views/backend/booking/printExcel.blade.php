<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
        <th>Month</th>
        <th>Year</th>
        <th>Sabre Bookings</th>
        <th>Amadeus</th>
        <th>Travel Port</th>
        <th>Others</th>
        <th>Travel ID</th>
        <th>Market Share</th>
        <th>Account Manager</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $mv)
        <tr>
            <td>{{ $mv->month }}</td>
            <td>{{ $mv->year }}</td>
            <td>{{ $mv->sabre_bookings }}</td>
            <td>{{ $mv->amadeus }}</td>
            <td>{{ $mv->travel_port }}</td>
            <td>{{ $mv->others }}</td>
            <td>{{ $mv->ta_id }}</td>
            <td>{{ $mv->marketsharecommitment }}</td>
            <td>{{ $mv->accountmanager }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<br>

