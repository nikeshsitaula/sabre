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
            <td>FROM</td>
            <td>{{$timecommitment->from}}</td>
        </tr>
        <tr>
            <td>TO</td>
            <td>{{$timecommitment->to}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($timecommitment->created_at))
                    {{$timecommitment->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($timecommitment->updated_at))
                    {{$timecommitment->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
