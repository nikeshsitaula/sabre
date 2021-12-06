@if(!empty($productval))
    <table class="table table-hover table-striped">

        <tbody>

        <tr>
            <td>{{$productval->p_id}}({{$productval->name}})</td>
        </tr>
        <tr>
            <td>Description: {{$productval->description}}</td>
        </tr>

        </tbody>

    </table>
@endif
