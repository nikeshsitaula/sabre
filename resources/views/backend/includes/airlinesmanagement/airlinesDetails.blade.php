@if(!empty($airlines))
    <table class="table table-hover table-striped">

        <tbody>

        <tr>
            <td>{{$airlines->name}}({{$airlines->ai_id}})</td>
            <td>{{$airlines->address}}</td>
            <td>Phone No: {{$airlines->phone}}</td>
        </tr>
        <tr>
            <td>Numeric IATA: {{$airlines->numericiata}}</td>
            <td>Alphanumeric IATA: {{ $airlines->alphanumericiata }}</td>
        </tr>
        <tr>
            <td>FAX No: {{ $airlines->fax }}</td>
            <td>Email: {{ $airlines->email }}</td>

        </tr>

        </tbody>

    </table>
@endif
