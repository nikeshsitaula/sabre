@extends('backend.layouts.app')

@section('content')
    <div class="content">

        <!-- Form inputs -->

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Edit Airlines</h5>
        </div>

        <div class="card-body">

            {!! Form::model($airlines,['method'=>'PUT','route'=>['airlines.update',$airlines->id],'class'=>'form-horizontal','role'=>'form']) !!}

            {!!Form::label('ai_id','Airlines',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::number('ai_id',$value=null,['class'=>"form-control",'required'=>'required', 'readonly' => 'true']) !!}
            </div>
            {!!Form::label('name','Name',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('name',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>
            {!!Form::label('address','Address',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('address',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>
            {!!Form::label('numericiata','Numeric IATA',['class'=>'col-form-label col-lg-2 ']) !!}
            <div class="col-lg-10">

                {!! Form::text('numericiata',$value=null,['class'=>"form-control"]) !!}
            </div>
            {!!Form::label('alphanumericiata','AlphaNumeric IATA',['class'=>'col-form-label col-lg-2 ']) !!}
            <div class="col-lg-10">

                {!! Form::text('alphanumericiata',$value=null,['class'=>"form-control"]) !!}
            </div>
            {!!Form::label('phone','Phone No',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::number('phone',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>
            {!!Form::label('Email','Email Id',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('email',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>
            {!!Form::label('Fax','FAX No',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('fax',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>

        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary legitRipple">Submit <i
                    class="icon-paperplane ml-2"></i></button>
        </div>

        {!! Form::close() !!}

    </div>

@endsection
