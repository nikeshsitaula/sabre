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
            <td>Airlines ID</td>
            <td>{{$airlinesstaff->ai_id}}</td>
        </tr>
        <tr>
            <td>Staff ID</td>
            <td>{{$airlinesstaff->staff_id}}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{$airlinesstaff->name}}</td>
        </tr>
        <tr>
            <td>Position</td>
            <td>{{$airlinesstaff->position}}</td>
        </tr>
        <tr>
            <td>Remarks</td>
            <td>{{$airlinesstaff->remarks}}</td>
        </tr>
        <tr>
            <td>Mobile No</td>
            <td>{{$airlinesstaff->mobile}}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{$airlinesstaff->email}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($airlinesstaff->created_at))
                    {{$airlinesstaff->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($airlinesstaff->updated_at))
                    {{$airlinesstaff->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
