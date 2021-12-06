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
            <td>{{$airlinesvisit->ai_id}}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>{{$airlinesvisit->date}}</td>
        </tr>
        <tr>
            <td>Details</td>
            <td>{{$airlinesvisit->details}}</td>
        </tr>
        <tr>
            <td>User</td>
            <td>{{$airlinesvisit->user}}</td>
        </tr>

        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($airlinesvisit->created_at))
                    {{$airlinesvisit->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($airlinesvisit->updated_at))
                    {{$airlinesvisit->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
