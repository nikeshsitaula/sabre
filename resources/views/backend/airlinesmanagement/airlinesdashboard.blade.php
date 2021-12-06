@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="content">

        <div class="row mb-2">
            <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
        </div>

        {!! Form::open(['method'=>'get','route'=>['airlinesdashboard.index'],'class'=>'form-horizontal','role'=>'form']) !!}

        <div class="form-group row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        {!!Form::label('ai_id','Airlines ID',['class'=>'col-form-label require']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Form::select('ai_id',$ai_id,$value=null,['class'=>"form-control select2",'placeholder'=>'','required'=>'required']) !!}
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
                @if(!empty($airlines))
                    <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                        <div class="col-md-12">
                            <h4 class="text-secondary">Airlines Full Detail</h4>
                            @include('backend.includes.airlinesmanagement.airlinesDetails')
                        </div>
                    </div>
                @endif

                {{--Airlines--}}
                @if(!empty($airlinesstaff))
                    <div>
                        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                            <div class="col-md-12">
                                <h4 class="text-secondary">Airlines Staff</h4>

                                <table class="table table-hover ">
                                    <tr colspan="6" style="background-color: #F7F7F7">
                                        <th>Staff ID</th>
                                        <th>Name</th>
                                        <th>Position</th>
                                        <th>Remarks</th>
                                        <th>Mobile No</th>
                                        <th>Email</th>
                                    </tr>

                                    @foreach ($airlinesstaff as $as)
                                        <tr>

                                            <td>
                                                {{$as->staff_id}}
                                            </td>
                                            <td>
                                                {{$as->name}}
                                            </td>
                                            <td>
                                                {{$as->position}}
                                            </td>
                                            <td>
                                                {{$as->remarks}}
                                            </td>
                                            <td>
                                                {{$as->mobile}}
                                            </td>
                                            <td>
                                                {{$as->email}}
                                            </td>

                                        </tr>
                                    @endforeach
                                </table>
                                {{--{{$experience->appends(['ai_id' => $employee->ai_id])->links()}}--}}
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Airlines Visit--}}
                @if(!empty($airlinesvisit))
                    <div>
                        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                            <div class="col-md-12">
                                <h4 class="text-secondary">Airlines Visit</h4>

                                <table class="table table-hover ">
                                    <tr colspan="3" style="background-color: #F7F7F7">
                                        <th>Date</th>
                                        <th>Details</th>
                                        <th>User</th>
                                    </tr>

                                    @foreach ($airlinesvisit as $av)
                                        <tr>
                                            <td>
                                                {{$av->date}}
                                            </td>
                                            <td>
                                                {{$av->details}}
                                            </td>
                                            <td>
                                                {{$av->user}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                {{--Airline Miscellaneous--}}
                @if(!empty($airlinesmisc))
                    <div>
                        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                            <div class="col-md-12">
                                <h4 class="text-secondary">Airlines Miscellaneous</h4>

                                <table class="table table-hover ">
                                    <tr colspan="2" style="background-color: #F7F7F7">
                                        <th>Date</th>
                                        <th>Particular</th>
                                    </tr>

                                    @foreach ($airlinesmisc as $am)
                                        <tr>
                                            <td>
                                                {{$am->date}}
                                            </td>
                                            <td>
                                                {{$am->particular}}
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
