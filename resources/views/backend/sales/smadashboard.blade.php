@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="content">

        <div class="row mb-2">
            <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
        </div>

        {!! Form::open(['method'=>'get','route'=>['smadashboard.index'],'class'=>'form-horizontal','role'=>'form']) !!}

        <div class="form-group row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        {!!Form::label('sma_id','SMA ID',['class'=>'col-form-label require']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Form::select('sma_id',$sma_id,$value=null,['class'=>"form-control select2",'placeholder'=>'','required'=>'required']) !!}
                    </div>
                    <div class="col-md-2">
                        {{ Form::button('View Details <i class="icon-paperplane ml-2"></i>', ['type' => 'submit', 'class' => 'btn btn-primary legitRipple'] )  }}
                    </div>
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
                @if(!empty($smaval))
                    <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                        <div class="col-md-12">
                            <h4 class="text-secondary">SMA Full Detail</h4>
                            @include('backend.includes.sma.smafulldetails')
                        </div>
                    </div>
                @endif

                {{--SMA Prize--}}
                @if(!empty($smaprize))
                    <br>
                    <br>
                    <div>
                        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                            <div class="col-md-12">
                                <h4 class="text-secondary">SMA Prize</h4>

                                <table class="table table-hover">
                                    <tr colspan="5" style="background-color: #F7F7F7">
                                        <th>Travel ID</th>
                                        <th>Travel Agency</th>
                                        <th>Staff No</th>
                                        <th>Prize Amount</th>
                                        <th>Prize Other</th>
                                    </tr>

                                    @foreach ($smaprize as $smap)
                                        <tr>

                                            <td>
                                                {{$smap->ta_id}}
                                            </td>
                                            <td>
                                                {{$smap->travelname}}
                                            </td>
                                            <td>
                                                {{$smap->staff_no}}
                                            </td>
                                            <td>
                                                {{$smap->prizeamount}}
                                            </td>
                                            <td>
                                                {{$smap->prizeother}}
                                            </td>

                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- SMA Other--}}
                @if(!empty($smaother))
                    <div>
                        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                            <div class="col-md-12">
                                <h4 class="text-secondary">SMA Other</h4>

                                <table class="table table-hover">
                                    <tr colspan="3" style="background-color: #F7F7F7">
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                    </tr>

                                    @foreach ($smaother as $smao)
                                        <tr>
                                            <td>
                                                {{$smao->description}}
                                            </td>
                                            <td>
                                                {{$smao->amount}}
                                            </td>
                                            <td>
                                                {{$smao->date}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
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
        $(".select2").select2({
            placeholder: "Select anyone",
            theme: 'modern',
            allowClear: true,
            minimumInputLength:2

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
