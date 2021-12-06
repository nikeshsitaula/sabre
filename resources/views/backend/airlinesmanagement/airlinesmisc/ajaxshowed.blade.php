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
            <td>{{$airlinesmisc->ai_id}}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>{{$airlinesmisc->date}}</td>
        </tr>
        <tr>
            <td>Details</td>
            <td>{{$airlinesmisc->particular}}</td>
        </tr>

        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($airlinesmisc->created_at))
                    {{$airlinesmisc->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($airlinesmisc->updated_at))
                    {{$airlinesmisc->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
