<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of Experience:-</h2>
@include('backend.includes.employee.employeeDetails')
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
        <th>Position</th>
        <th>Organization</th>
        <th>Duration</th>
    </tr>
    </thead>
    <tbody>
    @foreach($experience as $exp)
        <tr>
            <td> {{$exp->position}} </td>
            <td> {{$exp->organization}}</td>
            <td> {{$exp->duration}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
