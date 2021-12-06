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
            <td>{{$accountsmanager->ta_id}}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>{{$accountsmanager->date}}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{$accountsmanager->email}}</td>
        </tr>
        <tr>
            <td>User</td>
            <td>{{$accountsmanager->user}}</td>
        </tr>

        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($accountsmanager->created_at))
                    {{$accountsmanager->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($accountsmanager->updated_at))
                    {{$accountsmanager->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
