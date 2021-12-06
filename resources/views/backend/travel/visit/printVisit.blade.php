<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of Visit:-</h2>
@include('backend.includes.travel.travelDetails')
<br/>
@foreach($visit as $av)
    <h4 class="text-center">{{$av->user}}</h4>
    <hr>
    <p class="text-center">{{$av->detail}}</p>
    </br>
    </br>
@endforeach
</body>
</html>
