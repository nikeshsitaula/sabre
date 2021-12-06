<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of AccountsManager:-</h2>
@include('backend.includes.travel.travelDetails')
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
        <th>User</th>
        <th>Email</th>
        <th>Date</th>
    </tr>
    </thead>
    <tbody>
    @foreach($accountsmanager as $am)
        <tr>
            <td> {{$am->user}} </td>
            <td> {{$am->email}} </td>
            <td> {{$am->date}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
