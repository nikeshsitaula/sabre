@extends('backend.layouts.app')

@section('content')
    <div class="content">

        <!-- Form inputs -->

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Add Employee</h5>
        </div>

        <div class="card-body">

            {!! Form::open(['method'=>'POST','route'=>['employee.store'],'class'=>'form-horizontal','role'=>'form']) !!}

            <div class="form-group row">
                {!!Form::label('emp_no','Employee Number',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::number('emp_no',$value=null,['class'=>"form-control emp_no",'required'=>'required']) !!}
                    {{--message will be displayed here--}}
                    <div id="message"></div>
                </div>
                {!!Form::label('name','Name',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('name',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>
                {!!Form::label('address','Address',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('address',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>
                {!!Form::label('mobile','Mobile',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('mobile',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>
                {!!Form::label('res_phone','Res Phone',['class'=>'col-form-label col-lg-2 ']) !!}
                <div class="col-lg-10">

                    {!! Form::number('res_phone',$value=null,['class'=>"form-control",'maxlength' => 190]) !!}
                </div>
                {{--{!!Form::label('position','Position',['class'=>'col-form-label col-lg-2 require']) !!}--}}
                {{--<div class="col-lg-10">--}}

                {{--{!! Form::text('position',$value=null,['class'=>"form-control"]) !!}--}}
                {{--</div>--}}
                {{--{!!Form::label('level','Level',['class'=>'col-form-label col-lg-2 require']) !!}--}}
                {{--<div class="col-lg-10">--}}

                {{--{!! Form::text('level',$value=null,['class'=>"form-control"]) !!}--}}
                {{--</div>--}}
                {!!Form::label('dob','DOB (YYYY-MM-DD)',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('dob',$value=null,['class'=>"form-control ",'required pattern'=>"(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))", 'title'=>"Enter a date in this format YYYY-MM-DD"]) !!}
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
        // $('#datePicker').datepicker({
        //     format: 'YYYY-MM-DD',
        // })

        $(document).ready(function () {
            $('.emp_no').on('change', function () {
                var emp_no = $(this).val();
                console.log('employee no:' + emp_no);

                //check if emp no input field has some value , if form input is empty then dont check for user existence
                if (emp_no.length > 0) {

                    $.ajax({
                        url: '{{url('employee/checkEmployeeExistence')}}',
                        method: 'GET',
                        data: {
                            'emp_no': emp_no //this is the input which is sent in GET Request as parameter
                        },
                        dataType: 'json',
                        //function(data) has (data) which is the json response
                        success: function (data) {
                            // data is the response from controller after checking user
                            //if data has two param: status and message
                            //if message is false it means employee already exist else doesn't
                            console.log(data);
                            //check if employee exist
                            if (data.message === false) {
                                $('#message').html('<small class="text-danger">employee already exist</small>');
                            } else {
                                $('#message').html('<small class="text-success">new employee : available</small>');
                            }
                        }
                    });
                } else {//if emp no has no input value in form then display nothing
                    $('#message').html('');
                }
            });
        });
    </script>
@endpush
