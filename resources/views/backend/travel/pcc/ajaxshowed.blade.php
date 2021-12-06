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
            <td>Travel Agency ID</td>
            <td>{{$pcc->ta_id}}</td>
        </tr>
        <tr>
            <td>PCC</td>
            <td>{{$pcc->br_pcc}}</td>
        </tr>
        <tr>
            <td>Address</td>
            <td>{{$pcc->br_address}}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{$pcc->br_phone}}</td>
        </tr>
        <tr>
            <td>Fax</td>
            <td>{{$pcc->br_fax_no}}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{$pcc->br_email}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>{{$pcc->created_at}}</td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>{{$pcc->updated_at}}</td>
        </tr>
        </tbody>
    </table>
    <!-- /form inputs -->
</div>
