<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of Staff Training:-</h2>
@include('backend.includes.travel.travelDetails')
<br/>
@if(!empty($trainingstaff))
    <table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
        <thead>
        <tr>
            <th>Staff No</th>
            <th>Course</th>
            <th>From</th>
            <th>To</th>
        </tr>
        </thead>
        <tbody>
        @foreach($trainingstaff as $st)
            <tr>
                <td> {{$st->staff_no}} </td>
                <td> {{$st->course}}</td>
                <td> {{$st->from}}</td>
                <td> {{$st->to}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endif

@if(!empty($trainingstaffall))
    @foreach($trainingstaffall as $key=>$st)
        <h3>Travel ID: {!! $key.'  &nbsp;&nbsp; Name: '.getTravelName($key)!!}</h3>
        <table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
            <thead>
            <tr>
                <th>Staff No</th>
                <th>Course</th>
                <th>To</th>
                <th>From</th>
            </tr>
            </thead>
            <tbody>
            @foreach($st as $key=>$s)
                <tr>
                    <td> {{$s->staff_no}} </td>
                    <td> {{$s->course}}</td>
                    <td> {{$s->to}}</td>
                    <td> {{$s->from}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <br>
        <br>
    @endforeach
    @endif

</body>
</html>
