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
            <td>SMA ID</td>
            <td>{{$sales->sma_id}}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{$sales->name}}</td>
        </tr>
        <tr>
            <td>Description</td>
            <td>{{$sales->description}}</td>
        </tr>
        <tr>
            <td>Estimated Cost</td>
            <td>{{$sales->estimatedcost}}</td>
        </tr>
        <tr>
            <td>Actual Cost</td>
            <td>{{$sales->actualcost}}</td>
        </tr>
        <tr>
            <td>From</td>
            <td>{{$sales->from}}</td>
        </tr>
        <tr>
            <td>To</td>
            <td>{{$sales->to}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($sales->created_at))
                    {{$sales->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($sales->updated_at))
                    {{$sales->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
