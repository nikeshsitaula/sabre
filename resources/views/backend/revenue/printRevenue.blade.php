<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center"> Printing Details of Revenue:- </h2>
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
    @foreach($revenue as $rev)
        <tr>
            <td> {{$rev->month}} </td>
            <td> {{$rev->year}}</td>
            <td> {{$rev->pcc}} </td>
            <td> {{$rev->ta_id}}</td>
            <td> {{$rev->fit_calc}}</td>
            <td> {{$rev->git_calc}}</td>
            <td> {{$rev->incentives}}</td>
            <td> {{$rev->marketsharecommitment}}</td>
            <td> {{$rev->accountmanager}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
