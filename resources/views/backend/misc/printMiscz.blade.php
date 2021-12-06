<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of Miscellaneous:-</h2>
@include('backend.includes.employee.employeeDetails')
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
        <th>Particular</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($miscz as $misc)
        <tr>
            <td> {{$misc->particular}} </td>
            <td> {{$misc->date}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
