<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of SMA Prize:-</h2>
@include('backend.includes.sma.smadetails')
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
{{--        <th>SMA ID</th>--}}
        <th>Travel ID</th>
        <th>Travel Agency</th>
        <th>Staff No</th>
        <th>Prize Amount</th>
        <th>Prize Other</th>
    </tr>
    </thead>
    <tbody>
    @foreach($smaprize as $sm)
        <tr>
{{--            <td> {{$sm->sma_id}} </td>--}}
            <td> {{$sm->ta_id}}</td>
            <td> {{$sm->travelname}}</td>
            <td> {{$sm->staff_no}}</td>
            <td> {{$sm->prizeamount}}</td>
            <td> {{$sm->prizeother}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
