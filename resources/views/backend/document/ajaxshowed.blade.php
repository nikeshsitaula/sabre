<div class="content">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Field</th>
                    <th>Detail</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Emp No</td>
                    <td>{{$document->emp_no}}</td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td>{{$document->name}}</td>
                </tr>
                <tr>
                    <td>Created By</td>
                    <td>{{$created_by->name}}</td>
                </tr>
                <tr>
                    <td>Updated By</td>
                    <td>
                        @if($updated_by)
                            {{$updated_by->name}}
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            @foreach($images as $image)
                <a href="/storage/document_images/{{$image->name}}"><img class="img-responsive" style="width:150px; height: 150px;"
                                                                         src="/storage/document_images/{{$image->name}}"/></a>
            @endforeach
        </div>
        <!-- /form inputs -->
    </div>
</div>
