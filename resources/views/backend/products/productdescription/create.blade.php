@extends('backend.layouts.app')

@section('content')
    <div class="content">

        <!-- Form inputs -->

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Add Product</h5>
        </div>

        <div class="card-body">

            {!! Form::open(['method'=>'POST','route'=>['products.store'],'class'=>'form-horizontal','role'=>'form']) !!}

            <div class="form-group row">
                {!!Form::label('p_id','Product ID',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::number('p_id',$value=null,['class'=>"form-control p_id",'required'=>'required']) !!}
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
            $('.p_id').on('change', function () {
                var p_id = $(this).val();
                console.log('product id:' + p_id);

                //check if p_id input field has some value , if form input is null then dont check for user existence
                if (p_id.length > 0) {

                    $.ajax({
                        url: '{{url('products/checkProductExistence')}}',
                        method: 'GET',
                        data: {
                            'p_id': p_id //this is the input which is sent in GET Request as parameter
                        },
                        dataType: 'json',
                        //function(data) has (data) which is the json response
                        success: function (data) {
                            // data is the response from controller after checking user
                            //if data has two param: status and message
                            //if message is false it means product id already exist else doesn't
                            console.log(data);
                            //check if product exists
                            if (data.message === false) {
                                $('#message').html('<small class="text-danger">product id already exists</small>');
                            } else {
                                $('#message').html('<small class="text-success">new product id : available</small>');
                            }
                        }
                    });
                } else {//if p_id has no input value in form then display nothing
                    $('#message').html('');
                }
            });
        });
    </script>
@endpush
