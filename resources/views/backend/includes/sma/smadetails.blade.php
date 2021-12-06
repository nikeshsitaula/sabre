@if(!empty($smaval))
    <table class="table table-hover table-striped">

        <tbody>

        <tr>
            <td>{{$smaval->sma_id}}({{$smaval->name}})</td>
        </tr>
        <tr>
            <td>From: {{$smaval->from}}</td>
            <td>To: {{$smaval->to}}</td>
        </tr>

        </tbody>

    </table>
@endif
