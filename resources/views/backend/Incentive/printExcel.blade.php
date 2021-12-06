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
    @foreach($data as $iv)
        <tr>
            <td>{{ $iv->month }}</td>
            <td>{{ $iv->year }}</td>
            <td>{{ $iv->pcc }}</td>
            <td>{{ $iv->ta_id }}</td>
            <td>{{ $iv->fit_calc }}</td>
            <td>{{ $iv->git_calc}}</td>
            <td>{{ $iv->incentives }}</td>
            <td>{{ $iv->marketsharecommitment }}</td>
            <td>{{ $iv->accountmanager }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<br>

