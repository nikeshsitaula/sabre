<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of Product Cost :-</h2>
<br/>
@if(!empty($productcostentries))
    <div>
        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
            <div class="col-md-12">
                <table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
                    @foreach ($productcostentries as $pid => $users_list)

                        <thead>
                        <th colspan="8">
                            <br> <br>
                            <h3>Product ID: {!! $pid.'  &nbsp;&nbsp; Name: '.getProductName($pid)!!}</h3>
                        </th>
                        <tr colspan="8" style="background-color: #F7F7F7">
                            {{--                                                <th>Agreement Number</th>--}}
                            <th>Agreement Number</th>
                            <th>Travel Agency</th>
                            <th>Period</th>
                            <th>Cost</th>
                            <th>Payment</th>
                            <th>Balance</th>
                            <th>Entry Date</th>
                            <th>Account Manager</th>
                        </tr>
                        </thead>

                        @foreach ($users_list as $user)
                            <tr>
                                {{--                                                <td>{{ $user->agreementnumber }}</td>--}}
                                <td>{{ $user->agreementnumber }}</td>
                                <td>{{ $user->ta_id }} ({!! getTravelName($user->ta_id) !!})</td>
                                <td>{{ $user->period }}</td>
                                <td>{{ $user->cost }}</td>
                                <td>{{ $user->received }}</td>
                                <td>{{ $user->balance }}</td>
                                <td>{{ $user->entrydate }}</td>
                                <td>{{ $user->accountmanager }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endif
