<div class="content">
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
            <td>{{$misc->emp_no}}</td>
        </tr>
        <tr>
            <td>Particular</td>
            <td>{{$misc->particular}}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>{{$misc->date}}</td>
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
    <!-- /form inputs -->
</div>
