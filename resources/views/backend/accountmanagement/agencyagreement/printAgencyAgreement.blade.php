<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of Agency Agreement:-</h2>
@include('backend.includes.travel.travelDetails')
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
        <th>Upperlimit</th>
        <th>Lowerlimit</th>
        <th>value</th>
    </tr>
    </thead>
    <tbody>
    @foreach($agencyagreement as $ag)
        <tr>
            <td> {{$ag->upperlimit}} </td>
            <td> {{$ag->lowerlimit}} </td>
            <td> {{$ag->value}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
