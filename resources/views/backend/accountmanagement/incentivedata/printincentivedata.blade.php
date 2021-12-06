<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of Agency Agreement:-</h2>
@include('backend.includes.travel.travelDetails')
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
        <th>Volume Commitment</th>
        <th>Contact Period</th>
        <th>Target Segment</th>
        <th>Segment To Month</th>
        <th>Start Date</th>
        <th>Market Share</th>
        <th>ToMonth Market Share</th>
        <th>Month</th>
    </tr>
    </thead>
    <tbody>
    @foreach($incentivedata as $icd)
        <tr>
            <td> {{$icd->volumecommitment}} </td>
            <td> {{$icd->contactperiod}} </td>
            <td> {{$icd->targetsegment}}</td>
            <td> {{$icd->segmenttomonth}}</td>
            <td> {{$icd->startdate}}</td>
            <td> {{$icd->marketshare}}</td>
            <td> {{$icd->tomonthmarketshare}}</td>
            <td> {{$icd->month}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
