@extends('backend.layouts.app')

@section('content')
    <div class="content">

        <!-- Form inputs -->

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Edit SMA</h5>
        </div>

        <div class="card-body">

            {!! Form::model($sales,['method'=>'PUT','route'=>['sales.update',$sales->id],'class'=>'form-horizontal','role'=>'form']) !!}

            {!!Form::label('sma_id','SMA ID',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::number('sma_id',$value=null,['class'=>"form-control",'required'=>'required', 'readonly' => 'true']) !!}
            </div>
            {!!Form::label('name','Name',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('name',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>
            {!!Form::label('description','Description',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('description',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>
            {!!Form::label('estimatedcost','Estimated Cost',['class'=>'col-form-label col-lg-2 ']) !!}
            <div class="col-lg-10">

                {!! Form::text('estimatedcost',$value=null,['class'=>"form-control"]) !!}
            </div>
            {!!Form::label('actualcost','Actual Cost',['class'=>'col-form-label col-lg-2 ']) !!}
            <div class="col-lg-10">

                {!! Form::text('actualcost',$value=null,['class'=>"form-control"]) !!}
            </div>
            {!!Form::label('from','From',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('from',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>
            {!!Form::label('to','To',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('to',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>


        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary legitRipple">Submit <i
                    class="icon-paperplane ml-2"></i></button>
        </div>

        {!! Form::close() !!}

    </div>

@endsection
