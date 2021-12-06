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
            <td>SMA Id</td>
            <td>{{$smaothercost->sma_id}}</td>
        </tr>
        <tr>
            <td>Description</td>
            <td>{{$smaothercost->description}}</td>
        </tr>
        <tr>
            <td>Amount</td>
            <td>{{$smaothercost->amount}}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>{{$smaothercost->date}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($smaothercost->created_at))
                    {{$smaothercost->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($smaothercost->updated_at))
                    {{$smaothercost->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
