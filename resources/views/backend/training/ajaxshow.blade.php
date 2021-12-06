<div class="content">

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th> emp no</th>
            <th> training</th>
            <th> institute  </th>
            <th> duration </th>

        </tr>
        </thead>
        <tbody>
        @foreach($training as $tra)
            <tr>
                <td> {{$tra->emp_no}} </td>
                <td> {{$tra->training}} </td>
                <td> {{$tra->institute}} </td>
                <td> {{$tra->duration}} </td>

            </tr>
        @endforeach
        </tbody>
    </table>

</div>
