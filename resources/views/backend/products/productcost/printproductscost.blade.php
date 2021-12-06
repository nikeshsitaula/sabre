<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of Product Cost:-</h2>
@include('backend.includes.product.productdetails')
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
{{--        <th>Product ID</th>--}}
        <th>Agreement No</th>
        <th>Travel Agency</th>
        <th>Entry Date</th>
        <th>Period</th>
        <th>Cost</th>
        <th>Payment</th>
        <th>Balance</th>
        <th>Account Manager</th>
    </tr>
    </thead>
    <tbody>
    @foreach($productscost as $pc)
        <tr>
{{--            <td> {{$pc->p_id}} </td>--}}
            <td> {{$pc->agreementnumber}}</td>
            <td> {{$pc->ta_id}} ({!! getTravelName($pc->ta_id) !!})</td>
            <td> {{$pc->entrydate}}</td>
            <td> {{$pc->period}}</td>
            <td> {{$pc->cost}}</td>
            <td> {{$pc->received}}</td>
            <td> {{$pc->balance}}</td>
            <td> {{$pc->accountmanager}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
