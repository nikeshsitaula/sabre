@extends('backend.layouts.app')

@section('content')
    <div class="content">

        <!-- Form inputs -->

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Add Airlines</h5>
        </div>

        <div class="card-body">

            {!! Form::open(['method'=>'POST','route'=>['airlines.store'],'class'=>'form-horizontal','role'=>'form']) !!}

            <div class="form-group row">
                {!!Form::label('ai_id','Airlines ID',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::number('ai_id',$value=null,['class'=>"form-control ai_id",'required'=>'required']) !!}
                    {{--message will be displayed here--}}
                    <div id="message"></div>
                </div>
                {!!Form::label('name','Name',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('name',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>
                {!!Form::label('address','Address',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10" >

                    {!! Form::text('address',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>

                {!!Form::label('numericiata','Numeric IATA No',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10" >

                    {!! Form::text('numericiata',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>

                {!!Form::label('alphanumericiata','AlphaNumeric IATA No',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10" >

                    {!! Form::text('alphanumericiata',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>

                {!!Form::label('phone','Phone No',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::number('phone',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>

                {!!Form::label('email','Email Id',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10" >

                    {!! Form::text('email',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>

                {!!Form::label('fax','Fax No',['class'=>'col-form-label col-lg-2']) !!}
                <div class="col-lg-10" >

                    {!! Form::text('fax',$value=null,['class'=>"form-control",'maxlength' => 190]) !!}
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
        $(document).ready(function () {
            $('.ai_id').on('change', function () {
                var ai_id = $(this).val();
                console.log('airlines agency id:' + ai_id);

                //check if ai_id input field has some value , if form input is null then dont check for user existence
                if (ai_id.length > 0) {

                    $.ajax({
                        url: '{{url('airlines/checkAirlinesExistence')}}',
                        method: 'GET',
                        data: {
                            'ai_id': ai_id //this is the input which is sent in GET Request as parameter
                        },
                        dataType: 'json',
                        //function(data) has (data) which is the json response
                        success: function (data) {
                            // data is the response from controller after checking user
                            //if data has two param: status and message
                            //if message is false it means airlines agency already exist else doesn't
                            console.log(data);
                            //check if airlines agency exist
                            if (data.message === false) {
                                $('#message').html('<small class="text-danger">airlines agency already exist</small>');
                            } else {
                                $('#message').html('<small class="text-success">new airlines agency : available</small>');
                            }
                        }
                    });
                } else {//if ai_id has no input value in form then display nothing
                    $('#message').html('');
                }
            });
        });
    </script>
@endpush
