<div class="content">

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th> emp no</th>
            <th> qualification</th>
            <th> institute  </th>
            <th> year </th>

        </tr>
        </thead>
        <tbody>
        @foreach($education as $edu)
            <tr>
                <td> {{$edu->emp_no}} </td>
                <td> {{$edu->qualification}} </td>
                <td> {{$edu->institute}} </td>
                <td> {{$edu->year}} </td>

            </tr>
        @endforeach
        </tbody>
    </table>

</div>
