<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of AirlinesStaff:-</h2>
@include('backend.includes.airlinesmanagement.airlinesDetails')
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
        <th>Staff ID</th>
        <th>Name</th>
        <th>Position</th>
        <th>Remarks</th>
        <th>Mobile No</th>
        <th>Email</th>
    </tr>
    </thead>
    <tbody>
    @foreach($airlinesstaff as $as)
        <tr>
            <td> {{$as->staff_id}} </td>
            <td> {{$as->name}}</td>
            <td> {{$as->position}}</td>
            <td> {{$as->remarks}}</td>
            <td> {{$as->mobile}} </td>
            <td> {{$as->email}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
