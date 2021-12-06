<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of Time Commitment:-</h2>
@include('backend.includes.travel.travelDetails')
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
        <th>FROM</th>
        <th>TO</th>
    </tr>
    </thead>
    <tbody>
    @foreach($timecommitment as $tc)
        <tr>
            <td> {{$tc->from}} </td>
            <td> {{$tc->to}} </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
