@extends('backend.layouts.app')

@section('content')
    <div class="content">

        <!-- Form inputs -->

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Add Travel Agency</h5>
        </div>

        <div class="card-body">

            {!! Form::open(['method'=>'POST','route'=>['travel.store'],'class'=>'form-horizontal','role'=>'form']) !!}

            <div class="form-group row">
                {!!Form::label('ta_id','Travel Agency Number',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::number('ta_id',$value=null,['class'=>"form-control ta_id",'required'=>'required']) !!}
                    {{--message will be displayed here--}}
                    <div id="message"></div>
                </div>
                {!!Form::label('ta_name','Name',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('ta_name',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>
                {!!Form::label('address','Address',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10" >

                    {!! Form::text('ta_address',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>
                {!!Form::label('phone','Phone No',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::number('ta_phone',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>

                {!!Form::label('iata','IATA No',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10" >

                    {!! Form::text('ta_iata_no',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>

                {!!Form::label('fax','Fax No',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10" >

                    {!! Form::text('ta_fax_no',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>

                {!!Form::label('email','Email Id',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10" >

                    {!! Form::text('ta_email',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
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
            $('.ta_id').on('change', function () {
                var ta_id = $(this).val();
                console.log('travel agency id:' + ta_id);

                //check if ta_id input field has some value , if form input is null then dont check for user existence
                if (ta_id.length > 0) {

                    $.ajax({
                        url: '{{url('travel/checkTravelExistence')}}',
                        method: 'GET',
                        data: {
                            'ta_id': ta_id //this is the input which is sent in GET Request as parameter
                        },
                        dataType: 'json',
                        //function(data) has (data) which is the json response
                        success: function (data) {
                            // data is the response from controller after checking user
                            //if data has two param: status and message
                            //if message is false it means travel agency already exist else doesn't
                            console.log(data);
                            //check if travel agency exist
                            if (data.message === false) {
                                $('#message').html('<small class="text-danger">travel agency already exist</small>');
                            } else {
                                $('#message').html('<small class="text-success">new travel agency : available</small>');
                            }
                        }
                    });
                } else {//if ta_id has no input value in form then display nothing
                    $('#message').html('');
                }
            });
        });
    </script>
@endpush
