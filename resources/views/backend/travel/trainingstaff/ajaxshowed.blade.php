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
            <td>Travel Agency ID</td>
            <td>{{$trainingstaff->ta_id}}</td>
        </tr>
        <tr>
            <td>Staff_no</td>
            <td>{{$trainingstaff->staff_no}}</td>
        </tr>
        <tr>
            <td>Course</td>
            <td>{{$trainingstaff->course}}</td>
        </tr>
        <tr>
            <td>To</td>
            <td>{{$trainingstaff->to}}</td>
        </tr>
        <tr>
            <td>From</td>
            <td>{{$trainingstaff->from}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{$trainingstaff->created_at}}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{$trainingstaff->updated_at}}</td>
        </tr>

        {{--<tr>--}}
        {{--<td>Created By</td>--}}
        {{--<td>{{$created_by->name}}</td>--}}
        {{--</tr>--}}
        {{--<tr>--}}
        {{--<td>Updated By</td>--}}
        {{--<td>--}}
        {{--@if($updated_by)--}}
        {{--{{$updated_by->name}}--}}
        {{--@endif--}}
        {{--</td>--}}
        {{--</tr>--}}

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
