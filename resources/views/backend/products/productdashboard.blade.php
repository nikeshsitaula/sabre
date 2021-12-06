@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="content">

        <div class="row mb-2">
            <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
        </div>

        {!! Form::open(['method'=>'get','route'=>['productdashboard.index'],'class'=>'form-horizontal','role'=>'form']) !!}

        {{--        <div class="form-group row">--}}
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4">
                    {!!Form::label('ta_id','Travel Agency ID',['class'=>'col-form-label require']) !!}
                </div>
                <div class="col-md-6">
                    {!! Form::select('ta_id',$ta_id,$value=null,['class'=>"form-control select2",'placeholder'=>'']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    {{--                        {!!Form::label('from','From',['class'=>'col-form-label col-lg-2 require']) !!}--}}
                    From
                </div>
                <div class="col-md-6">
                    {!! Form::text('from',$value=null,['id'=>'dateFrom','class'=>"form-control ",'placeholder'=>'']) !!}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    {{--                        {!!Form::label('to','To',['class'=>'col-form-label col-lg-2 require']) !!}--}}
                    To
                </div>
                <div class="col-md-6">
                    {!! Form::text('to',$value=null,['id'=>'dateTo','class'=>"form-control ",'placeholder'=>'']) !!}
                </div>
                <div class="col-md-2">
                    {{ Form::button('View Details <i class="icon-paperplane ml-2"></i>', ['type' => 'submit', 'class' => 'btn btn-primary legitRipple'] )  }}
                </div>
            </div>

        </div>
        {{--        </div>--}}

        {!! Form::close() !!}
        <a href="#" id="printDoc" onclick="printPage()"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2 mr-2"><b><i
                    class="icon-printer2"></i></b> Export</a>
        <div id="print">
            <div>
                {{--General Info--}}
                @if(!empty($travelagency))
                    <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                        <div class="col-md-12">
                            <h4 class="text-secondary">Travel Agency Full Detail</h4>
                            @include('backend.includes.travel.travelDetails')
                        </div>
                    </div>

                    {{--Details--}}
                    @if(!empty($productcostentries))
                        <div>
                            <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                                <div class="col-md-12">
                                    <h4 class="text-secondary">Product Cost Entry Details</h4>

                                    <table class="table table-hover">
                                        @foreach ($productcostentries as $pc => $users_list)
                                            <tr>
                                                <thead>
                                                {{--                                            <th colspan="5">--}}
                                                {{--                                                <br> <br>--}}
                                                {{--                                                Agreement Number: {{ $pc }}: {{ $users_list->count() }} Entries--}}
                                                {{--                                            </th>--}}
                                                <th colspan="5">
                                                    <br> <br>
                                                    Agreement Number: {{ $pc }}
                                                </th>
                                                <tr colspan="6" style="background-color: #F7F7F7">
                                                    {{--                                                <th>Agreement Number</th>--}}
                                                    <th>Cost</th>
                                                    <th>Payment</th>
                                                    <th>Balance</th>
                                                    <th>Date</th>
                                                    <th>Product Detail</th>
                                                </tr>
                                                </thead>
                                            </tr>
                                            @foreach ($users_list as $user)
                                                <tr>
                                                    {{--                                                <td>{{ $user->agreementnumber }}</td>--}}
                                                    <td>{{ $user->cost }}</td>
                                                    <td>{{ $user->payment }}</td>
                                                    <td>{{ $user->balance }}</td>
                                                    <td>{{ $user->date }}</td>
                                                    <td>{{ $user->p_id }} ({{ $user->name }})</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                {{--                -----------------------------------------------------------------------------------------------}}

                {{--General Info--}}
                @if(empty($travelagency))

                    {{--Details--}}
                    @if(!empty($productcostentries))
                        <div>
                            <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                                <div class="col-md-12">
                                    <h4 class="text-secondary">Product Cost Entry Details</h4>

                                    <table class="table table-hover">
                                        @foreach ($productcostentries as $pc => $users_list)
                                            <tr>
                                                <thead>
                                                <th colspan="5">
                                                    <br> <br>
                                                    Agreement Number: {{ $pc }}
                                                </th>
                                                <tr colspan="6" style="background-color: #F7F7F7">
                                                    <th>Travel Agency</th>
                                                    <th>Cost</th>
                                                    <th>Payment</th>
                                                    <th>Balance</th>
                                                    <th>Date</th>
                                                    <th>Product Detail</th>
                                                </tr>
                                                </thead>
                                            </tr>
                                            @foreach ($users_list as $user)
                                                <tr>
                                                    <td>{{ $user->ta_id }} ({!! getTravelName($user->ta_id) !!})</td>
                                                    <td>{{ $user->cost }}</td>
                                                    <td>{{ $user->payment }}</td>
                                                    <td>{{ $user->balance }}</td>
                                                    <td>{{ $user->date }}</td>
                                                    <td>{{ $user->p_id }} ({{ $user->name }})</td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        //for select
        $(".select2").select2({
            placeholder: "Select anyone",
            theme: 'modern',
            allowClear: true,
            minimumInputLength: 2

        });

        function printPage() {
            var prtContent = $("#print")[0];
            var WinPrint = window.open('', '', 'left=0,top=0,width=1024,height=768,toolbar=0,scrollbars=0,status=0');
            WinPrint.document.open()
            WinPrint.document.write('<html><head>')
            WinPrint.document.write('</head><body>');
            WinPrint.document.write('<link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">');
            WinPrint.document.write(prtContent.innerHTML);
            WinPrint.document.write('</body></html>');
            WinPrint.document.close();
            WinPrint.print();
        }
    </script>
@endpush
