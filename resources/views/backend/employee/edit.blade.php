@extends('backend.layouts.app')

@section('content')
    <div class="content">

        <!-- Form inputs -->

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Edit Employee</h5>
        </div>

        <div class="card-body">

            {!! Form::model($employee,['method'=>'PUT','route'=>['employee.update',$employee->id],'class'=>'form-horizontal','role'=>'form']) !!}

            {!!Form::label('emp_no','Employee Number',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::number('emp_no',$value=null,['class'=>"form-control",'required'=>'required', 'readonly' => 'true']) !!}
            </div>
            {!!Form::label('name','Name',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('name',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>
            {!!Form::label('address','Address',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('address',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>
            {!!Form::label('mobile','Mobile',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('mobile',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>
            {!!Form::label('res_phone','Res Phone',['class'=>'col-form-label col-lg-2 ']) !!}
            <div class="col-lg-10">

                {!! Form::number('res_phone',$value=null,['class'=>"form-control"]) !!}
            </div>
            {{--{!!Form::label('position','Position',['class'=>'col-form-label col-lg-2 require']) !!}--}}
            {{--<div class="col-lg-10">--}}

                {{--{!! Form::text('position',$value=null,['class'=>"form-control"]) !!}--}}
            {{--</div>--}}
            {{--{!!Form::label('level','Level',['class'=>'col-form-label col-lg-2 require']) !!}--}}
            {{--<div class="col-lg-10">--}}

                {{--{!! Form::text('level',$value=null,['class'=>"form-control"]) !!}--}}
            {{--</div>--}}
            {!!Form::label('dob','DOB',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('dob',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary legitRipple">Submit <i
                        class="icon-paperplane ml-2"></i></button>
        </div>

        {!! Form::close() !!}

    </div>

@endsection
