@extends('backend.layouts.app')

@section('content')
    <div class="content">

        <!-- Form inputs -->

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Edit Travel Agency</h5>
        </div>

        <div class="card-body">

            {!! Form::model($travel,['method'=>'PUT','route'=>['travel.update',$travel->id],'class'=>'form-horizontal','role'=>'form']) !!}

            {!!Form::label('ta_id','Travel Agency Number',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::number('ta_id',$value=null,['class'=>"form-control",'required'=>'required', 'readonly' => 'true']) !!}
            </div>
            {!!Form::label('name','Name',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('ta_name',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>
            {!!Form::label('address','Address',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('ta_address',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>
            {!!Form::label('phone','Phone No',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::number('ta_phone',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>
            {!!Form::label('iata','IATA No',['class'=>'col-form-label col-lg-2 ']) !!}
            <div class="col-lg-10">

                {!! Form::text('ta_iata_no',$value=null,['class'=>"form-control"]) !!}
            </div>

            {!!Form::label('Fax','FAX No',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('ta_fax_no',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>

            {!!Form::label('Email','Email Id',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('ta_email',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>

        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary legitRipple">Submit <i
                    class="icon-paperplane ml-2"></i></button>
        </div>

        {!! Form::close() !!}

    </div>

@endsection
