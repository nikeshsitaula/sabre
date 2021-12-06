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
            <td>Airlines ID</td>
            <td>{{$airlines->ai_id}}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{$airlines->name}}</td>
        </tr>
        <tr>
            <td>Address</td>
            <td>{{$airlines->address}}</td>
        </tr>
        <tr>
            <td>Numeric IATA No</td>
            <td>{{$airlines->numericiata}}</td>
        </tr>
        <tr>
            <td>AlphaNumeric IATA No</td>
            <td>{{$airlines->alphanumericiata}}</td>
        </tr>
        <tr>
            <td>Phone</td>
            <td>{{$airlines->phone}}</td>
        </tr>
        <tr>
            <td>Email</td>
            <td>{{$airlines->email}}</td>
        </tr>
        <tr>
            <td>Fax No</td>
            <td>{{$airlines->fax}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($airlines->created_at))
                    {{$airlines->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($airlines->updated_at))
                    {{$airlines->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
