@extends('backend.layouts.app')

@section('content')
    <div class="content">

        <!-- Form inputs -->

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Add SMA</h5>
        </div>

        <div class="card-body">

            {!! Form::open(['method'=>'POST','route'=>['sales.store'],'class'=>'form-horizontal','role'=>'form']) !!}

            <div class="form-group row">
                {!!Form::label('sma_id','SMA ID',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::number('sma_id',$value=null,['class'=>"form-control sma_id",'required'=>'required']) !!}
                    {{--message will be displayed here--}}
                    <div id="message"></div>
                </div>
                {!!Form::label('name','Name',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('name',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>
                {!!Form::label('description','description',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('description',$value=null,['class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>

                {!!Form::label('estimatedcost','Estimated Cost',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::number('estimatedcost',$value=null,['step'=>"0.0001",'class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}
                </div>

{{--                {!!Form::label('actualcost','Actual Cost',['class'=>'col-form-label col-lg-2 require']) !!}--}}
{{--                <div class="col-lg-10">--}}

{{--                    {!! Form::number('actualcost',$value=null,['step'=>"0.0001",'class'=>"form-control",'required'=>'required','maxlength' => 190]) !!}--}}
{{--                </div>--}}

                {!!Form::label('from','FROM (YYYY-MM-DD)',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('from',$value=null,['class'=>"form-control ",'required pattern'=>"(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))", 'title'=>"Enter a date in this format YYYY-MM-DD"]) !!}
                </div>

                {!!Form::label('to','To (YYYY-MM-DD)',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('to',$value=null,['class'=>"form-control ",'required pattern'=>"(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))", 'title'=>"Enter a date in this format YYYY-MM-DD"]) !!}
                </div>

                <div class="text-right">
                    {{ Form::button('Submit <i class="icon-paperplane ml-2"></i>', ['type' => 'submit', 'class' => 'btn btn-primary legitRipple'] )  }}
                </div>

                {!! Form::close() !!}

            </div>

            <!-- /form inputs -->
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('.sma_id').on('change', function () {
                var sma_id = $(this).val();
                console.log('SMA id:' + sma_id);

                //check if sma_id input field has some value , if form input is null then dont check for user existence
                if (sma_id.length > 0) {

                    $.ajax({
                        url: '{{url('sales/checkSalesExistence')}}',
                        method: 'GET',
                        data: {
                            'sma_id': sma_id //this is the input which is sent in GET Request as parameter
                        },
                        dataType: 'json',
                        //function(data) has (data) which is the json response
                        success: function (data) {
                            // data is the response from controller after checking user
                            //if data has two param: status and message
                            //if message is false it means sales id already exist else doesn't
                            console.log(data);
                            //check if sales id exist
                            if (data.message === false) {
                                $('#message').html('<small class="text-danger">sma id already exist</small>');
                            } else {
                                $('#message').html('<small class="text-success">new sma id agency : available</small>');
                            }
                        }
                    });
                } else {//if sma_id has no input value in form then display nothing
                    $('#message').html('');
                }
            });
        });
    </script>
@endpush
