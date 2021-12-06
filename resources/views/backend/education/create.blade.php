@extends('backend.layouts.app')

@section('content')
    <div class="content">
        <div id="educationData"></div>

        <!-- Form inputs -->

            <div class="card-header header-elements-inline">
                <h5 class="card-title">Add Education</h5>
            </div>

            <div class="card-body">

                {!! Form::open(['method'=>'POST','route'=>['education.store'],'class'=>'form-horizontal','role'=>'form']) !!}

                <div class="form-group row">
                    {!!Form::label('emp_no','Employee Number',['class'=>'col-form-label col-lg-2 require']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('emp_no',$emp_no,$value=null,['class'=>"form-control select2",'placeholder'=>'']) !!}
                    </div>
                    {!!Form::label('qualification','Qualification',['class'=>'col-form-label col-lg-2 require']) !!}
                    <div class="col-lg-10">

                        {!! Form::text('qualification',$value=null,['class'=>"form-control",'required'=>'required']) !!}
                    </div>
                    {!!Form::label('institute','Institute',['class'=>'col-form-label col-lg-2 require']) !!}
                    <div class="col-lg-10">

                        {!! Form::text('institute',$value=null,['class'=>"form-control",'required'=>'required']) !!}
                    </div>
                    {!!Form::label('year','Year',['class'=>'col-form-label col-lg-2 require']) !!}
                    <div class="col-lg-10">

                        {!! Form::text('year',$value=null,['class'=>"form-control",'required'=>'required']) !!}
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
                url: '{{url('employee/education/search')}}'+'/' + emp_id,
                method: 'GET',
                success: function(data){

                    console.log(data);

                    $('#educationData').html(data);

                    $("#showRemoteData").waitMe("hide");

                }
            });
        });

    </script>
@endpush
