<table class="table table-hover table-striped">

    <tbody>

    <tr>
        <td>{{$employee->name}}({{$employee->emp_no}})</td>
        <td>{{$position_pluck}}</td>
    </tr>
    <tr>
        <td>{{$employee->address}}</td>
        <td>DOB: {{$employee->dob}}</td>
    </tr>
    <tr>
        <td>Mobile: {{$employee->mobile}}</td>
        <td>Res. Phone: {{ $employee->res_phone }}</td>
        <td>Education: {{ $education_pluck }}</td>

    </tr>

    </tbody>

</table>
