<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of Product Cost Entry:-</h2>
@include('backend.includes.product.agreementsDetails')
<br/>
{{--<h3>Agreement Number:{{ $agreementnumbers}} </h3>--}}
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
{{--        <th>Agreement Number</th>--}}
        <th>Travel Agency</th>
        <th>Cost</th>
        <th>Payment</th>
        <th>Balance</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($productcostentry as $pce)
        <tr>
{{--            <td> {{$pce->agreementnumber}}</td>--}}
            <td> {{$pce->ta_id}} ({!! getTravelName($pce->ta_id) !!})</td>
            <td> {{$pce->cost}}</td>
            <td> {{$pce->payment}}</td>
            <td> {{$pce->balance}}</td>
            <td> {{$pce->date}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
