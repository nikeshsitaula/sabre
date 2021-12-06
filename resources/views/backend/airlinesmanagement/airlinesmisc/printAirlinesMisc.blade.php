<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of Airlines Miscellaneous:-</h2>
@include('backend.includes.airlinesmanagement.airlinesDetails')
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
        <th>Date</th>
        <th>Particular</th>
    </tr>
    </thead>
    <tbody>
    @foreach($airlinesmisc as $am)
        <tr>
            <td> {{$am->date}} </td>
            <td> {{$am->particular}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
