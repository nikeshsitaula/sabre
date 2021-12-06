<div class="content">

    <table class="table table-bordered table-striped" id="experience-table">
        <thead>
        <tr>
            <th> Position</th>
            <th> Organization  </th>
            <th> Duration </th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($experience as $exp)
            <tr>

                <td> {{$exp->position}} </td>
                <td> {{$exp->organization}} </td>
                <td> {{$exp->duration}} </td>
                <td>
                    <a data-id="{{$exp->id}}" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a>
                    <a href="experience/edit/{{$exp->id}}" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a>
                    <a href="experience/destroy/{{$exp->id}}" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$experience->links()}}
</div>
