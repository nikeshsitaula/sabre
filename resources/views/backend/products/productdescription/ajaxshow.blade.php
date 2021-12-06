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
            <td>Product ID</td>
            <td>{{$products->p_id}}</td>
        </tr>
        <tr>
            <td>Name</td>
            <td>{{$products->name}}</td>
        </tr>
        <tr>
            <td>Description</td>
            <td>{{$products->description}}</td>
        </tr>

        <tr>
            <td>Created At</td>
            <td>
                @if(!empty($products->created_at))
                    {{$products->created_at}}
                @endif
            </td>
        </tr>
        <tr>
            <td>Updated At</td>
            <td>
                @if(!empty($products->updated_at))
                    {{$products->updated_at}}
                @endif
            </td>
        </tr>

        </tbody>
    </table>
    <!-- /form inputs -->
</div>
