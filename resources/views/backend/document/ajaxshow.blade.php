<div class="content">

    <table class="table table-bordered table-striped">
        <thead>
        <tr>

            <th> emp no</th>
            <th> name</th>

        </tr>
        </thead>
        <tbody>
        @if(!empty($document))
            @foreach($document as $doc)
                <tr>
                    <td> {{$doc->emp_no}} </td>
                    <td> {{$doc->name}} </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td> no data</td>
                <td> no data</td>
            </tr>
        @endif
        </tbody>

        <tbody>
        @if(!empty($images))
            @foreach($images as $image)
                <div class="col-md-2 mt-1">
                    <a href="/storage/document_images/{{$image->name}}"><img class="img-responsive" style="width:300px;"
                                                                             src="/storage/document_images/{{$image->name}}"/></a>
                </div>
            @endforeach
        @endif
        </tbody>
    </table>

</div>
