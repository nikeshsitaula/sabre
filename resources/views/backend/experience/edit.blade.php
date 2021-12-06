@extends('backend.layouts.app')

@section('content')
    <div class="content">

        <!-- Form inputs -->

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Add Experience</h5>
        </div>

        <div class="card-body">

            {!! Form::model($experience,['method'=>'PUT','route'=>['experience.update',$experience->id],'class'=>'form-horizontal','role'=>'form']) !!}

            <div class="form-group row">
                {!!Form::label('emp_no','Employee Number',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">
                    {!! Form::select('emp_no',$emp_no,$value=null,['class'=>"form-control select2",'placeholder'=>'']) !!}
                </div>
                {!!Form::label('position','Position',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('position',$value=null,['class'=>"form-control",'required'=>'required']) !!}
                </div>
                {!!Form::label('organization','Organization',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('organization',$value=null,['class'=>"form-control",'required'=>'required']) !!}
                </div>
                {!!Form::label('duration','Duration',['class'=>'col-form-label col-lg-2 require']) !!}
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
