<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Printing Details of Incentive:-</h2>
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
        <th>Month</th>
        <th>Year</th>
        <th>PCC</th>
        <th>Travel ID</th>
        <th>FIT Calculation</th>
        <th>GIT Calculation</th>
        <th>Incentive</th>
        <th>Volume Share</th>
        <th>Account Manager</th>
    </tr>
    </thead>
    <tbody>
    @foreach($incentive as $inc)
        <tr>
            <td> {{$inc->month}} </td>
            <td> {{$inc->year}}</td>
            <td> {{$inc->pcc}} </td>
            <td> {{$inc->ta_id}}</td>
            <td> {{$inc->fit_calc}}</td>
            <td> {{$inc->git_calc}}</td>
            <td> {{$inc->incentives}}</td>
            <td> {{$inc->marketsharecommitment}}</td>
            <td> {{$inc->accountmanager}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
