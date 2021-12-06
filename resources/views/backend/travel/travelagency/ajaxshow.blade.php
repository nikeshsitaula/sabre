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
            <td>{{$travel->ta_id}}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{$travel->ta_name}}</td>
        </tr>
        <tr>
            <td>Address</td>
            <td>{{$travel->ta_address}}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{$travel->ta_phone}}</td>
        </tr>
        <tr>
            <td>IATA No</td>
            <td>{{$travel->ta_iata_no}}</td>
        </tr>
        <tr>
            <td>Fax No</td>
            <td>{{$travel->ta_fax_no}}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{$travel->ta_email}}</td>
        </tr>
        <tr>
            <td>Account Manager</td>
            <td>{{$travel->accountmanager}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($travel->created_at))
                    {{$travel->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($travel->updated_at))
                    {{$travel->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
