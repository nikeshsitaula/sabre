<table>
    <thead>
    <tr>
        <th>Emp No</th>
        <th>Name</th>
        <th>Position</th>
        <th>Level</th>
        <th>Address</th>
        <th>Mobile</th>
        <th>Res Phone</th>
        <th>DOB</th>
    </tr>
    </thead>
    <tbody>
    @foreach($employees as $emp)
        <tr>
            <td>{{ $emp->emp_no }}</td>
            <td>{{ $emp->name }}</td>
            <td>{{ $emp->position }}</td>
            <td>{{ $emp->level }}</td>
            <td>{{ $emp->address }}</td>
            <td>{{ $emp->mobile }}</td>
            <td>{{ $emp->res_phone }}</td>
            <td>{{ $emp->dob }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
