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
            <td>Agreemnt Number</td>
            <td>{{$productcostentry->agreementnumber}}</td>
        </tr>
        <tr>
            <td>Travel ID</td>
            <td>{{$productcostentry->ta_id}}</td>
        </tr>
        <tr>
            <td>Cost</td>
            <td>{{$productcostentry->cost}}</td>
        </tr>
        <tr>
            <td>Payment</td>
            <td>{{$productcostentry->payment}}</td>
        </tr>
        <tr>
            <td>Date</td>
            <td>{{$productcostentry->date}}</td>
        </tr>
        <tr>
            <td>Balance</td>
            <td>{{$productcostentry->balance}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($productcostentry->created_at))
                    {{$productcostentry->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($productcostentry->updated_at))
                    {{$productcostentry->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
