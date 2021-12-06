@if(!empty($travelagency))
<table class="table table-hover table-striped">

    <tbody>

    <tr>
        <td>{{$travelagency->ta_name}}({{$travelagency->ta_id}})</td>
        <td>{{$travelagency->ta_address}}</td>
    </tr>
    <tr>
        <td>Phone: {{$travelagency->ta_phone}}</td>
        <td>IATA No: {{ $travelagency->ta_iata_no }}</td>
    </tr>
    <tr>
        <td>FAX No: {{ $travelagency->ta_fax_no }}</td>
        <td>Email: {{ $travelagency->ta_email }}</td>

    </tr>

    </tbody>

</table>
@endif
