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
            <td>{{$lniata->ta_id}}</td>
        </tr>
        <tr>
            <td>PCC</td>
            <td>{{$lniata->pcc}}</td>
        </tr>
        <tr>
            <td>LNIATA</td>
            <td>{{$lniata->lniata}}</td>
        </tr>
        <tr>
            <td>User</td>
            <td>{{$lniata->user}}</td>
        </tr>
        <tr>
            <td>Remark</td>
            <td>{{$lniata->remark}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{$lniata->created_at}}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{$lniata->updated_at}}</td>
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
