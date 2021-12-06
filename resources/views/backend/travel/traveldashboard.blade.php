@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.travel.traveldashboard'))

@section('content')
    <div class="content">

        <div class="row mb-2">
            <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
        </div>

        {!! Form::open(['method'=>'get','route'=>['traveldashboard.index'],'class'=>'form-horizontal','role'=>'form']) !!}

        <div class="form-group row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        {!!Form::label('ta_id','Travel Agency ID',['class'=>'col-form-label require']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Form::select('ta_id',$ta_id,$value=null,['id'=>'ta_id','class'=>"form-control select2",'placeholder'=>'','required'=>'required']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        {!!Form::label('pcc','PCC',['class'=>'col-form-label ']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Form::select('pcc',['null'=>'null'],$value=null,['id'=>'pcc','class'=>"form-control select2 ",'placeholder'=>'']) !!}
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
                @if(!empty($travelagency))
                    <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                        <div class="col-md-12">
                            <h4 class="text-secondary">Travel Agency Full Detail</h4>
                            @include('backend.includes.travel.travelDetails')
                        </div>
                    </div>
                @endif

                {{--PCC--}}
                @if(!empty($pcc))
                    <div>
                        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                            <div class="col-md-12">
                                <h4 class="text-secondary">PCC</h4>

                                <table class="table table-hover ">
                                    <tr colspan="5" style="background-color: #F7F7F7">
                                        <th>PCC</th>
                                        <th>Address</th>
                                        <th>Phone</th>
                                        <th>Fax</th>
                                        <th>Email</th>
                                    </tr>

                                    @foreach ($pcc as $p)
                                        <tr>

                                            <td>
                                                {{$p->br_pcc}}
                                            </td>
                                            <td>
                                                {{$p->br_address}}
                                            </td>
                                            <td>
                                                {{$p->br_phone}}
                                            </td>
                                            <td>
                                                {{$p->br_fax_no}}
                                            </td>
                                            <td>
                                                {{$p->br_email}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                 {{--Staff--}}
                @if(!empty($staff))
                    <div>
                        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                            <div class="col-md-12">
                                <h4 class="text-secondary">Staff</h4>

                                <table class="table table-hover ">
                                    <tr colspan="6" style="background-color: #F7F7F7">
                                        <th>PCC</th>
                                        <th>Staff_no</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Mobile</th>
                                        <th>Email</th>
                                    </tr>

                                    @foreach ($staff as $st)
                                        <tr>
                                            <td>
                                                {{$st->pcc}}
                                            </td>
                                            <td>
                                                {{$st->staff_no}}
                                            </td>
                                            <td>
                                                {{$st->name}}
                                            </td>
                                            <td>
                                                {{$st->position}}
                                            </td>
                                            <td>
                                                {{$st->mobile}}
                                            </td>
                                            <td>
                                                {{$st->email_id}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                {{--LNIATA--}}
                @if(!empty($lniata))
                    <div>
                        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                            <div class="col-md-12">
                                <h4 class="text-secondary">LNIATA</h4>

                                <table class="table table-hover ">
                                    <tr colspan="4" style="background-color: #F7F7F7">
                                        <th>PCC</th>
                                        <th>lniata</th>
                                        <th>User</th>
                                        <th>Remark</th>
                                    </tr>

                                    @foreach ($lniata as $ln)
                                        <tr>
                                            <td>
                                                {{$ln->pcc}}
                                            </td>
                                            <td>
                                                {{$ln->lniata}}
                                            </td>
                                            <td>
                                                {{$ln->user}}
                                            </td>
                                            <td>
                                                {{$ln->remark}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                {{--misc--}}
                @if(!empty($travelmiscz))
                    <div>
                        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                            <div class="col-md-12">
                                <h4 class="text-secondary">Miscellaneous</h4>

                                <table class="table table-hover ">
                                    <tr colspan="6" style="background-color: #F7F7F7">
                                        <th>Particular</th>
                                        <th>Date</th>
                                    </tr>
                                    @foreach ($travelmiscz as $misc)
                                        <tr>

                                            <td>
                                                {{$misc->particular}}
                                            </td>
                                            <td>
                                                {{$misc->date}}
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

        $("#pcc").select2({
            placeholder: "Select anyone",
            theme: 'modern',
            allowClear: true,
            ajax: {
                url: '{{route('staff.filterPCCDropdown')}}',
                dataType: 'json',
                type: "GET",
                quietMillis: 50,
                data: function (name) {
                    return {
                        value: name.term,
                        ta_id: $('#ta_id').val(),
                        page: name.page || 1
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data.data, function (item) {
                            return {
                                text: 'PCC:'+item.br_pcc+'  Travel Agency:'+item.ta_id+'  Address:'+item.br_address,
                                id: item.br_pcc,
                            }
                        }),
                        'pagination': {
                            'more': data.data.length
                        }
                    };
                },
                cache: true
            },
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
