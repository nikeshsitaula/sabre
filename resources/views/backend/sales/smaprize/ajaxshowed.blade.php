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
            <td>{{$smaprize->sma_id}}</td>
        </tr>
        <tr>
            <td>Travel Id</td>
            <td>{{$smaprize->ta_id}}</td>
        </tr>
        <tr>
            <td>Staff No</td>
            <td>{{$smaprize->staff_no}}</td>
        </tr>
        <tr>
            <td>Prize Amount</td>
            <td>{{$smaprize->prizeamount}}</td>
        </tr>
        <tr>
            <td>Prize Other</td>
            <td>{{$smaprize->prizeother}}</td>
        </tr>

        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($smaprize->created_at))
                    {{$smaprize->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($smaprize->updated_at))
                    {{$smaprize->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
