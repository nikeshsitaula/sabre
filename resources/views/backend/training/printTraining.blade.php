<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Employee Number: {{$training->first()->emp_no}}</h2>
@include('backend.includes.employee.employeeDetails')
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
        <th>Training</th>
        <th>Institute</th>
        <th>Duration</th>
    </tr>
    </thead>
    <tbody>
    @foreach($training as $tra)
        <tr>
            <td> {{$tra->training}} </td>
            <td> {{$tra->institute}}</td>
            <td> {{$tra->duration}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
