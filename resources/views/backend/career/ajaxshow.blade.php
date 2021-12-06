<div class="content">

    <table id="careerData" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th> Position</th>
            <th> Date</th>
            <th>Action</th>

        </tr>
        </thead>
        <tbody>
        @foreach($career as $car)
            <tr>
                <td> {{$car->position}} </td>
                <td> {{$car->date}} </td>
                <td>
                    <a data-id="{{$car->id}}" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a>
                    <a href="career/edit/{{$car->id}}" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>
                    <a href="career/destroy/{{$car->id}}" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$career->links()}}
</div>
