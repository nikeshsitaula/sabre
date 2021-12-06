<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Printing Details of MIDT:-</h2>
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
    @foreach($midt as $mid)
        <tr>
            <td> {{$mid->month}} </td>
            <td> {{$mid->year}}</td>
            <td> {{$mid->sabre_bookings}} </td>
            <td> {{$mid->amadeus}}</td>
            <td> {{$mid->travel_port}}</td>
            <td> {{$mid->others}}</td>
            <td> {{$mid->ta_id}}</td>
            <td> {{$mid->marketsharecommitment}}</td>
            <td> {{$mid->accountmanager}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
