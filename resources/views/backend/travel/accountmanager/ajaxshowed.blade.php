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
            <td>{{$accountmanager->ta_id}}</td>
        </tr>
        <tr>
            <td>Account Manager</td>
            <td>{{$accountmanager->accountmanager}}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>{{$accountmanager->date}}</td>
        </tr>

        <tr>
            <td>Created At</td>
            <td>{{$accountmanager->created_at}}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{$accountmanager->updated_at}}</td>
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
