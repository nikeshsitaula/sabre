@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="content">

        {!! Form::open(['method'=>'get','route'=>['accountdashboard.index'],'class'=>'form-horizontal','role'=>'form']) !!}

                <div class="form-group row">
            <div class="col-md-6">
                <div class="row">
                    <a href="{{ 'dashboard/viewdetails'}}" id="#"
                       class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2 mr-2"><b><i
                                class="icon-paste2"></i></b> view all incentive controller data</a>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
        <a href="#" id="printDoc" onclick="printPage()"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2 mr-2"><b><i
                    class="icon-printer2"></i></b> Export</a>
        <div id="print">
            <div>
                {{--General Info--}}
                @if(!empty($accountdashboard))
                    <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                        <div class="col-md-12">
                            <h4 class="text-secondary">Travel Agency Full Detail</h4>
                            @include('backend.includes.travel.travelDetails')
                        </div>
                    </div>
                @endif

                @if(!empty($incentivecontroller))
                    <div>
                        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                            <div class="col-md-12">
                                <h4 class="text-secondary">Incentive Controller</h4>

                                @foreach ($incentivecontroller as $ic)
                                    <table class="table table-hover table-striped">
                                            <strong>Travel Agency</strong> : {{travelAgencyByField($ic->ta_id,'ta_name')}}
                                        <strong>Address</strong> : {{travelAgencyByField($ic->ta_id,'ta_address')}}
                                        <strong>Phone</strong> : {{travelAgencyByField($ic->ta_id,'ta_phone')}}
                                        <strong>Email</strong> : {{travelAgencyByField($ic->ta_id,'ta_email')}}
                                        <strong>IATA NO</strong> : {{travelAgencyByField($ic->ta_id,'ta_iata_no')}}
                                        <strong>Account Manager</strong> : {{accountManagerName($ic->ta_id)}}

                                        <tr colspan="6" style="background-color: #F7F7F7">
                                            <th>Travel ID</th>
                                            <th>Volume Commitment</th>
                                            <th>Contact Period</th>
                                            <th>Target Segment</th>
                                            <th>Segment to Month</th>
                                            <th>Start Date</th>
                                            <th>Market Share</th>
                                            <th>To Month Market share</th>
                                            <th>Month</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                {{$ic->ta_id}}
                                            </td>
                                            <td>
                                                {{$ic->volumecommitment}}
                                            </td>
                                            <td>
                                                {{$ic->contactperiod}}
                                            </td>
                                            <td>
                                                {{$ic->targetsegment}}
                                            </td>
                                            <td>
                                                {{$ic->segmenttomonth}}
                                            </td>
                                            <td>
                                                {{$ic->startdate}}
                                            </td>
                                            <td>
                                                {{$ic->marketshare}}
                                            </td>
                                            <td>
                                                {{$ic->tomonthmarketshare}}
                                            </td>
                                            <td>
                                                {{$ic->month}}
                                            </td>
                                        </tr>
                                    </table>
                                    <br>
                                @endforeach
                                {{$incentivecontroller->links()}}
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </div>
@endsection
@push('scripts')
    <script>
        //for select
        // $(".select2").select2({
        //     placeholder: "Select anyone",
        //     theme: 'modern',
        //     allowClear: true,
        //
        // });

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
