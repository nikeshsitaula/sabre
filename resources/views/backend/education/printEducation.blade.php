<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of Education:-</h2>
@include('backend.includes.employee.employeeDetails')
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
        <th>Qualification</th>
        <th>Education</th>
        <th>Year</th>
    </tr>
    </thead>
    <tbody>
    @foreach($education as $edu)
        <tr>
            <td> {{$edu->qualification}} </td>
            <td> {{$edu->institute}}</td>
            <td> {{$edu->year}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
