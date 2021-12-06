<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of LNIATA:-</h2>
@include('backend.includes.travel.travelDetails')
<br/>
<table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
    <thead>
    <tr>
        <th>pcc</th>
        <th>lniata</th>
        <th>user</th>
        <th>remark</th>
    </tr>
    </thead>
    <tbody>
    @foreach($lniata as $lniata)
        <tr>
            <td> {{$lniata->pcc}} </td>
            <td> {{$lniata->lniata}}</td>
            <td> {{$lniata->user}}</td>
            <td> {{$lniata->remark}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
