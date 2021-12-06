<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of  PCC:-</h2>
@include('backend.includes.travel.travelDetails')
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
        <th>pcc</th>
        <th>Address</th>
        <th>Phone</th>
        <th>Fax</th>
        <th>Email</th>
    </tr>
    </thead>
    <tbody>
    @foreach($pcc as $pc)
        <tr>
            <td> {{$pc->br_pcc}} </td>
            <td> {{$pc->br_address}}</td>
            <td> {{$pc->br_phone}} </td>
            <td> {{$pc->br_fax_no}}</td>
            <td> {{$pc->br_email}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
