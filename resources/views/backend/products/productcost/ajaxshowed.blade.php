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
            <td>Product ID</td>
            <td>{{$productcost->p_id}}</td>
        </tr>
        <tr>
            <td>Travel ID</td>
            <td>{{$productcost->ta_id}}</td>
        </tr>
        <tr>
            <td>Agreement Number</td>
            <td>{{$productcost->agreementnumber}}</td>
        </tr>
        <tr>
            <td>Period</td>
            <td>{{$productcost->period}}</td>
        </tr>
        <tr>
            <td>Entry Date</td>
            <td>{{$productcost->entrydate}}</td>
        </tr>
        <tr>
            <td>Total Cost</td>
            <td>{{$productcost->cost}}</td>
        </tr>
        <tr>
            <td>Total Payment</td>
            <td>{{$productcost->received}}</td>
        </tr>
        <tr>
            <td>Account Manager</td>
            <td>{{$productcost->accountmanager}}</td>
        </tr>
        <tr>
            <td>Balance</td>
            <td>{{$productcost->balance}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($productcost->created_at))
                    {{$productcost->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($productcost->updated_at))
                    {{$productcost->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
