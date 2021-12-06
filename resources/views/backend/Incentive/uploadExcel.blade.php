@extends('backend.layouts.app')
@section('content')
    <div class="content">
        {!! Form::open(['method'=>'POST','route'=>['revenue.uploadExcel'],'class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data']) !!}
        <div class="row ">
            {!!Form::label('revenue','Upload Revenue Excel',['class'=>'col-form-label col-lg-2 require']) !!}

            <div class="form-group row col-lg-10 ">
                {{Form::file('revenue', ['class' =>' form-control','required'=>'required'])}}
            </div>
        </div>
        {{--{{Form::submit('Submit ', ['class' => 'btn btn-primary legitRipple'])}}--}}
        <div class="text-right">
            {{ Form::button('Submit <i class="icon-paperplane ml-2"></i>', ['type' => 'submit', 'class' => 'btn btn-primary legitRipple'] )  }}
        </div>
        {!! Form::close() !!}
    </div>
@endsection
