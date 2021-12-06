@extends('backend.layouts.app')

@section('content')
    <div class="content">
        <div id="trainingData"></div>

        <!-- Form inputs -->

            <div class="card-header header-elements-inline">
                <h5 class="card-title">Add Training</h5>
            </div>

            <div class="card-body">

                {!! Form::open(['method'=>'POST','route'=>['training.store'],'class'=>'form-horizontal','role'=>'form']) !!}

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

                <div class="text-right">
                    {{ Form::button('Submit <i class="icon-paperplane ml-2"></i>', ['type' => 'submit', 'class' => 'btn btn-primary legitRipple'] )  }}
                </div>

                {!! Form::close() !!}

            </div>

        <!-- /form inputs -->

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

        $('.select2').change(function (e) {
            e.preventDefault();
            var emp_id = $(this).val();
            console.log(emp_id);
            $.ajax({
                url: '{{url('employee/training/search')}}'+'/' + emp_id,
                method: 'GET',
                success: function(data){

                    console.log(data);

                    $('#trainingData').html(data);

                    $("#showRemoteData").waitMe("hide");

                }
            });
        });

    </script>
@endpush
