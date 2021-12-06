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
            <td>{{$employee->emp_no}}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{$employee->name}}</td>
        </tr>
        <tr>
            <td>Position</td>
            <td>{{$employee->position}}</td>
        </tr>
        <tr>
            <td>Level</td>
            <td>{{$employee->level}}</td>
        </tr>
        <tr>
            <td>Address</td>
            <td>{{$employee->address}}</td>
        </tr>
        <tr>
            <td>Mobile</td>
            <td>{{$employee->mobile}}</td>
        </tr>
        <tr>
            <td>Res Phone</td>
            <td>{{$employee->res_phone}}</td>
        </tr>
        <tr>
            <td>DOB</td>
            <td>{{$employee->dob}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($employee->created_at))
                    {{$employee->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($employee->updated_at))
                    {{$employee->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
