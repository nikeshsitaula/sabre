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
        <th>PCC</th>
        <th>Travel ID</th>
        <th>FIT calc</th>
        <th>GIT calc</th>
        <th>Incentives</th>
        <th>Volume Share</th>
        <th>Account Manager</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $rv)
        <tr>
            <td>{{ $rv->month }}</td>
            <td>{{ $rv->year }}</td>
            <td>{{ $rv->pcc }}</td>
            <td>{{ $rv->ta_id }}</td>
            <td>{{ $rv->fit_calc }}</td>
            <td>{{ $rv->git_calc}}</td>
            <td>{{ $rv->incentives }}</td>
            <td>{{ $rv->marketsharecommitment }}</td>
            <td>{{ $rv->accountmanager }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<br>

