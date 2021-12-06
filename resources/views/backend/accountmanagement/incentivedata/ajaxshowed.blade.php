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
            <th>Travel ID</th>
            <td>{{$incentivedata->ta_id}}</td>
        </tr>
        <tr>
            <th>Volume Commitment</th>
            <td>{{$incentivedata->volumecommitment}}</td>
        </tr>
        <tr>
            <th>Contact Period</th>
            <td>{{$incentivedata->contactperiod}}</td>
        </tr>
        <tr>
            <th>Target Segment</th>
            <td>{{$incentivedata->targetsegment}}</td>
        </tr>
        <tr>
            <th>Segment To Month</th>
            <td>{{$incentivedata->segmenttomonth}}</td>
        </tr>
        <tr>
            <th>Start Date</th>
            <td>{{$incentivedata->startdate}}</td>
        </tr>
        <tr>
            <th>Market Share</th>
            <td>{{$incentivedata->marketshare}}%</td>
        </tr>
        <tr>
            <th>ToMonth Market Share</th>
            <td>{{$incentivedata->tomonthmarketshare}}</td>
        </tr>
        <tr>
            <th>Month</th>
            <td>{{$incentivedata->month}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($incentivedata->created_at))
                    {{$incentivedata->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($incentivedata->updated_at))
                    {{$incentivedata->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
