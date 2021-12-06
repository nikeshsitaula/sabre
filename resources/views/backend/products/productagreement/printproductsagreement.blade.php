<html>
<head>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap_limitless.min.css')}}" rel="stylesheet" type="text/css">
</head>
<body style="background-color: white;">
<h2 class="text-center">Every Transaction Printing of Product Agreement :-</h2>
@include('backend.includes.product.productdetails')
<br/>
@if(!empty($productsagreement))
    <div>
        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
            <div class="col-md-12">
                <table id="career-table" class="table table-striped table-bordered mdl-data-table mt-2">
                    @foreach ($productsagreement as $pid => $users_list)

                        <thead>
                        <th colspan="8">
                            <br> <br>
                            <h3>Travel ID: {!! $pid.'  &nbsp;&nbsp; Name: '.getTravelName($pid)!!}</h3>
                        </th>
                        <tr colspan="8" style="background-color: #F7F7F7">
                            {{--                                                <th>Agreement Number</th>--}}
                            <th>Agreement Number</th>
                            <th>Agreement Date</th>
                        </tr>
                        </thead>

                        @foreach ($users_list as $user)
                            <tr>
                                {{--                                                <td>{{ $user->agreementnumber }}</td>--}}
                                <td>{{ $user->agreementnumber }}</td>
                                <td>{{ $user->agreementdate }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endif
