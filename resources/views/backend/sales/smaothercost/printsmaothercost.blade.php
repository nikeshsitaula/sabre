<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of SMA Other Cost:-</h2>
@include('backend.includes.sma.smadetails')
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
{{--        <th>SMA ID</th>--}}
        <th>Description</th>
        <th>Amount</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($smaothercost as $smp)
        <tr>
{{--            <td> {{$smp->sma_id}} </td>--}}
            <td> {{$smp->description}}</td>
            <td> {{$smp->amount}}</td>
            <td> {{$smp->date}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
