<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of career:-</h2>
@include('backend.includes.employee.employeeDetails')

{{--<h2 class="text-center">Employee Number: {{$career->first()->emp_no}}</h2>--}}
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
        <th>Position</th>
        <th>Level</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($career as $car)
        <tr>
            <td> {{$car->position}} </td>
            <td> {{$car->level}}</td>
            <td> {{$car->date}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
