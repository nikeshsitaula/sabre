@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="content">

        <div class="row mb-2">
            <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
        </div>

        {!! Form::open(['method'=>'get','route'=>['dashboard.index'],'class'=>'form-horizontal','role'=>'form']) !!}

        <div class="form-group row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        {!!Form::label('emp_no','Employee No',['class'=>'col-form-label require']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Form::select('emp_no',$emp_no,$value=null,['class'=>"form-control select2",'placeholder'=>'','required'=>'required']) !!}
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
                @if(!empty($employee))
                    <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                        <div class="col-md-12">
                            <h4 class="text-secondary">Employee Full Detail</h4>
                            @include('backend.includes.employee.employeeDetails')
                        </div>
                    </div>
                @endif

                {{--Experience--}}
                @if(!empty($experience))
                    <div>
                        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                            <div class="col-md-12">
                                <h4 class="text-secondary">Experience</h4>

                                <table class="table table-hover ">
                                    <tr colspan="6" style="background-color: #F7F7F7">
                                        <th>Position</th>
                                        <th>Organization</th>
                                        <th>Duration</th>
                                    </tr>

                                    @foreach ($experience as $exp)
                                        <tr>

                                            <td>
                                                {{$exp->position}}
                                            </td>
                                            <td>
                                                {{$exp->organization}}
                                            </td>
                                            <td>
                                                {{$exp->duration}}
                                            </td>

                                        </tr>
                                    @endforeach
                                </table>
                                {{--{{$experience->appends(['emp_no' => $employee->emp_no])->links()}}--}}
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Career--}}
                @if(!empty($career))
                    <div>
                        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                            <div class="col-md-12">
                                <h4 class="text-secondary">Career</h4>

                                <table class="table table-hover ">
                                    <tr colspan="6" style="background-color: #F7F7F7">
                                        <th>Position</th>
                                        <th>Date</th>
                                    </tr>

                                    @foreach ($career as $car)
                                        <tr>
                                            <td>
                                                {{$car->position}}
                                            </td>
                                            <td>
                                                {{$car->date}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                {{--education--}}
                @if(!empty($education))
                    <div>
                        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                            <div class="col-md-12">
                                <h4 class="text-secondary">Education</h4>

                                <table class="table table-hover ">
                                    <tr colspan="3" style="background-color: #F7F7F7">
                                        <th>Qualification</th>
                                        <th>Institute</th>
                                        <th>Year</th>
                                    </tr>

                                    @foreach ($education as $edu)
                                        <tr>
                                            <td>
                                                {{$edu->qualification}}
                                            </td>
                                            <td>
                                                {{$edu->institute}}
                                            </td>
                                            <td>
                                                {{$edu->year}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                {{--training--}}
                @if(!empty($training))
                    <div>
                        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                            <div class="col-md-12">
                                <h4 class="text-secondary">Traning</h4>

                                <table class="table table-hover ">
                                    <tr colspan="3" style="background-color: #F7F7F7">
                                        <th>Training</th>
                                        <th>Institute</th>
                                        <th>Duration</th>
                                    </tr>
                                    @foreach ($training as $tra)
                                        <tr>

                                            <td>
                                                {{$tra->training}}
                                            </td>
                                            <td>
                                                {{$tra->institute}}
                                            </td>
                                            <td>
                                                {{$tra->duration}}
                                            </td>

                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                {{--misc--}}
                @if(!empty($training))
                    <div>
                        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                            <div class="col-md-12">
                                <h4 class="text-secondary">Miscellaneous</h4>

                                <table class="table table-hover ">
                                    <tr colspan="6" style="background-color: #F7F7F7">
                                        <th>Particular</th>
                                        <th>Date</th>
                                    </tr>
                                    @foreach ($miscz as $misc)
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

                {{--Document--}}
                @if(!empty($document))
                    <div>
                        <div class="row" style="backdrop-filter: opacity(0.3%); background-color: white;">
                            <div class="col-md-12">
                                <h4 class="text-secondary">Document</h4>

                                <table class="table table-hover ">
                                    <tr colspan="1" style="background-color: #F7F7F7">
                                        <th >Documents Provided</th>
                                    </tr>
                                    @foreach ($document as $doc)
                                        <tr>

                                            <td>
                                                {{$doc->name}}
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
