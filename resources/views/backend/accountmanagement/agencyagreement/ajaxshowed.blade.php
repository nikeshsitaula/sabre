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
            <td>UpperLimit</td>
            <td>{{$agencyagreement->upperlimit}}</td>
        </tr>
        <tr>
            <td>LowerLimit</td>
            <td>{{$agencyagreement->lowerlimit}}</td>
        </tr>
        <tr>
            <td>Value</td>
            <td>{{$agencyagreement->value}}</td>
        </tr>
        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($agencyagreement->created_at))
                    {{$agencyagreement->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($agencyagreement->updated_at))
                    {{$agencyagreement->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
