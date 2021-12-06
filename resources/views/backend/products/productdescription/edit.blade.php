@extends('backend.layouts.app')

@section('content')
    <div class="content">

        <!-- Form inputs -->

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Edit Products</h5>
        </div>

        <div class="card-body">

            {!! Form::model($products,['method'=>'PUT','route'=>['products.update',$products->id],'class'=>'form-horizontal','role'=>'form']) !!}

            {!!Form::label('p_id','Products',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::number('p_id',$value=null,['class'=>"form-control",'required'=>'required', 'readonly' => 'true']) !!}
            </div>
            {!!Form::label('name','Name',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('name',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>
            {!!Form::label('description','Description',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">

                {!! Form::text('description',$value=null,['class'=>"form-control",'required'=>'required']) !!}
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary legitRipple">Submit <i
                    class="icon-paperplane ml-2"></i></button>
        </div>

        {!! Form::close() !!}

    </div>

@endsection
