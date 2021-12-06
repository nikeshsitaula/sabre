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
            <td>{{$education->emp_no}}</td>
        </tr>
        <tr>
            <td>Qualification</td>
            <td>{{$education->qualification}}</td>
        </tr>
        <tr>
            <td>Institute</td>
            <td>{{$education->institute}}</td>
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
