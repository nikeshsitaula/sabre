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
            <td>{{$visit->ta_id}}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>{{$visit->date}}</td>
        </tr>
        <tr>
            <td>Detail</td>
            <td>{{$visit->detail}}</td>
        </tr>
        <tr>
            <td>User</td>
            <td>{{$visit->user}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{$visit->created_at}}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{$visit->updated_at}}</td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
