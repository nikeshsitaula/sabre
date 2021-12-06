<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body>
<br style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of AirlinesVisit:-</h2>
@include('backend.includes.airlinesmanagement.airlinesDetails')
<br/>
@foreach($airlinesvisit as $av)
    <h4 class="text-center">{{$av->user}}</h4>
    <hr>
    <p class="text-center">{{$av->details}}</p>
    </br>
    </br>
@endforeach
</body>
</html>
