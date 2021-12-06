@if(!empty($smaval))
    <table class="table table-hover table-striped">

        <tbody>

        <tr>
            <td>{{$smaval->sma_id}}({{$smaval->name}})</td>
            <td>From: {{$smaval->from}}</td>
            <td>To: {{$smaval->to}}</td>
        </tr>
        <tr>
            <td>Estimated Cost: {{$smaval->estimatedcost}}</td>
            <td>Actual Cost: {{$smaval->actualcost}}</td>
        </tr>

        </tbody>

    </table>
@endif
