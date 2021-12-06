@if(!empty($productval))
    <table class="table table-hover table-striped">

        <tbody>

        <tr>
            <td> Agreement Number:{{$productval->agreementnumber}}    Product ID: {{$productval->p_id}}  </td>
        </tr>
        <tr>
            <td>Agreement Date: {{$productval->agreementdate}}</td>
        </tr>

        </tbody>

    </table>
@endif
