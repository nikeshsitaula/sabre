@extends('backend.layouts.app')

@section('title', app_name() . ' | ' . __('strings.backend.dashboard.title'))

@section('content')
    <div class="content">
        <div class="row">
            <strong>@lang('strings.backend.dashboard.welcome') {{ $logged_in_user->name }}!</strong>
        </div>


        {!! Form::open(['method'=>'get','route'=>['admin.dashboard'],'class'=>'form-horizontal','role'=>'form']) !!}

        <div class="form-group row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-3">
                        {!!Form::label('emp_no','Employee No',['class'=>'col-form-label require']) !!}
                    </div>
                    <div class="col-md-6">
                        {!! Form::select('emp_no',$emp_no,$value=null,['class'=>"form-control select2",'placeholder'=>'','required'=>'required']) !!}
                    </div>
                    <div class="col-md-3">
                        {{ Form::button('View Details <i class="icon-paperplane ml-2"></i>', ['type' => 'submit', 'class' => 'btn btn-primary legitRipple'] )  }}
                    </div>
                </div>
            </div>
        </div>

        {!! Form::close() !!}
        @if(!empty($employee))
            <div
                style="background-color: #f5f5f5; padding: 20px;border-top-left-radius:2em;border-top-right-radius:2em;border-bottom-right-radius:2em;border-bottom-left-radius:2em; ">
                <h2 class="text-secondary"
                    style="text-align: center; color: #000000 !important; z-index: 1001 !important;">Employee
                    Details</h2>
                <div class="row" style="backdrop-filter: opacity(0.3%)">

                    <div class="col-md-4">
                        <h4 class="text-secondary">General Info</h4>
                        <p><strong>Employee</strong> No:
                            @foreach ($employee as $emp)
                                {{$emp->emp_no}}
                            @endforeach
                        </p>

                        <p>Name: @foreach ($employee as $emp)
                                {{$emp->name}}
                            @endforeach</p>
                        <p>Phone: @foreach ($employee as $emp)
                                {{$emp->mobile}}
                            @endforeach</p>
                        <p>Address: @foreach ($employee as $emp)
                                {{$emp->address}}
                            @endforeach</p>
                        <p>Res Phone: @foreach ($employee as $emp)
                                {{$emp->res_phone}}
                            @endforeach</p>
                        <p>Date of Birth: @foreach ($employee as $emp)
                                {{$emp->dob}}
                            @endforeach</p>
                    </div>
                    @if(!empty($experience))
                        <div class="col-md-4">
                            <h4 class="text-secondary">Experience</h4>
                            <p>Position: @foreach ($experience as $exp)
                                    {{$exp->position}}
                                @endforeach</p>
                            <p>Organization: @foreach ($experience as $exp)
                                    {{$exp->organization}}
                                @endforeach</p>
                            <p>Duration: @foreach ($experience as $exp)
                                    {{$exp->duration}}
                                @endforeach</p>
                        </div>
                    @endif
                    @if(!empty($career))
                        <div class="col-md-4">
                            <h4 class="text-secondary">Career</h4>
                            <p>Position: @foreach ($career as $car)
                                    {{$car->position}}
                                @endforeach</p>
                            <p>Date: @foreach ($career as $car)
                                    {{$car->date}}
                                @endforeach</p>
                        </div>
                    @endif
                    @if(!empty($education))
                        <div class="col-md-4">
                            <h4 class="text-secondary">Education</h4>
                            <p>Qualification: @foreach ($education as $edu)
                                    {{$edu->qualification}}
                                @endforeach</p>edu
                            <p>Institute: @foreach ($education as $edu)
                                    {{$edu->institute}}
                                @endforeach</p>
                            <p>Year: @foreach ($education as $edu)
                                    {{$edu->year}}
                                @endforeach</p>
                        </div>
                    @endif
                    @if(!empty($training))
                        <div class="col-md-4">
                            <h4 class="text-secondary">Training</h4>
                            <p>Training: @foreach ($training as $tra)
                                    {{$tra->training}}
                                @endforeach</p>
                            <p>Institute: @foreach ($training as $tra)
                                    {{$tra->institute}}
                                @endforeach</p>
                            <p>Duration: @foreach ($training as $tra)
                                    {{$tra->duration}}
                                @endforeach</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
@push('scripts')
    <script>
        //for select
        $(".select2").select2({
            placeholder: "Select anyone",
            theme: 'modern',
            allowClear: true,

        });
    </script>
@endpush
