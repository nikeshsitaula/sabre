<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of  Staff:-</h2>
@include('backend.includes.travel.travelDetails')
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
        <th>PCC</th>
        <th>Staff Number</th>
        <th>Name</th>
        <th>Position</th>
        <th>Mobile</th>
        <th>Email</th>
    </tr>
    </thead>
    <tbody>
    @foreach($staff as $st)
        <tr>
            <td> {{$st->pcc}} </td>
            <td> {{$st->staff_no}}</td>
            <td> {{$st->name}}</td>
            <td> {{$st->position}}</td>
            <td> {{$st->mobile}}</td>
            <td> {{$st->email_id}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
