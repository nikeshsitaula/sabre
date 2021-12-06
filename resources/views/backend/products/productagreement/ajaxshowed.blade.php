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
            <td>{{$productsagreement->p_id}}</td>
        </tr>
        <tr>
            <td>Travel Agency Name</td>
            <td>{{$productsagreement->travelname}}</td>
        </tr>        <tr>
            <td>Travel ID</td>
            <td>{{$productsagreement->ta_id}}</td>
        </tr>
        <tr>
            <td>Agreement Date</td>
            <td>{{$productsagreement->agreementdate}}</td>
        </tr>
        <tr>
            <td>Agreement Number</td>
            <td>{{$productsagreement->agreementnumber}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($productsagreement->created_at))
                    {{$productsagreement->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($productsagreement->updated_at))
                    {{$productsagreement->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
