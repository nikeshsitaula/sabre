@extends('backend.layouts.app')

@section('content')
    <div class="content">

        <!-- Form inputs -->

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Add Experience</h5>
        </div>

        <div class="card-body">

            {!! Form::model($training,['method'=>'PUT','route'=>['training.update',$training->id],'class'=>'form-horizontal','role'=>'form']) !!}

            <div class="form-group row">
                {!!Form::label('emp_no','Employee Number',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">
                    {!! Form::select('emp_no',$emp_no,$value=null,['class'=>"form-control select2",'placeholder'=>'']) !!}
                </div>
                {!!Form::label('training','Training',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('training',$value=null,['class'=>"form-control",'required'=>'required']) !!}
                </div>
                {!!Form::label('Institute','Institute',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('institute',$value=null,['class'=>"form-control",'required'=>'required']) !!}
                </div>
                {!!Form::label('Duration','Duration',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('duration',$value=null,['class'=>"form-control",'required'=>'required']) !!}
                </div>
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary legitRipple">Submit <i
                        class="icon-paperplane ml-2"></i></button>
        </div>

        {!! Form::close() !!}

    </div>
@endsection
@push('scripts')
    <script>
        //for select
        $(".select2").select2({
            placeholder: "Select anyone",
            theme:'modern',
            allowClear: true,
        });
    </script>
@endpush
