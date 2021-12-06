<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of Product Cost Entry:-</h2>
<br/>
@if(!empty($productcostentries))
    <div>
        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
            <div class="col-md-12">
                <table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
                    @foreach ($productcostentries as $pc => $users_list)

                        <thead>
                        <th colspan="5">
                            <br> <br>
                            <h3>Agreement Number: {!! $pc.'  &nbsp;&nbsp; Product ID: '.getProductID($pc)!!}</h3>
                        </th>
                        <tr colspan="5" style="background-color: #F7F7F7">
                            {{--                                                <th>Agreement Number</th>--}}
                            <th>Travel Agency</th>
                            <th>Cost</th>
                            <th>Payment</th>
                            <th>Balance</th>
                            <th>Date</th>
                        </tr>
                        </thead>

                        @foreach ($users_list as $user)
                            <tr>
                                {{--                                                <td>{{ $user->agreementnumber }}</td>--}}
                                <td>{{ $user->ta_id }} ({!! getTravelName($user->ta_id) !!})</td>
                                <td>{{ $user->cost }}</td>
                                <td>{{ $user->payment }}</td>
                                <td>{{ $user->balance }}</td>
                                <td>{{ $user->date }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endif
