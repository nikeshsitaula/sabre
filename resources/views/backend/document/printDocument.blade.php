<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of Document:-</h2>
@include('backend.includes.employee.employeeDetails')
<br/>
    {{--<table class="table table-striped table-bordered ">--}}
        {{--<thead>--}}
        {{--<tr>--}}
            {{--<th>Emp No</th>--}}
            {{--<th>Name</th>--}}
        {{--</tr>--}}
        {{--</thead>--}}
        {{--<tbody>--}}
        {{--@foreach($document as $doc)--}}
            {{--<tr>--}}
                {{--<td>{{ $doc->emp_no }}</td>--}}
                {{--<td>{{ $doc->name }}</td>--}}
            {{--</tr>--}}
        {{--@endforeach--}}
        {{--</tbody>--}}
    {{--</table>--}}

<div class="row">
    <div class="col-md-12">
            @if(count($document)>0)
                <div class="row">
                    @foreach($document as $doc)
                        <div class="col-md-6">
                            <br>
                            <h4>{{$doc->name}}</h4>
                            @foreach($doc->images as $img)
                                <a href="{{asset('storage/document_images').'/'.$img->name}}"><img
                                        class="img-responsive" style="width:300px;"
                                        src="{{asset('storage/document_images').'/'.$img->name}}"/></a>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @else
                <p>No document images available</p>
            @endif

    </div>

</div>
</body>
</html>
