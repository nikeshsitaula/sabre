@extends('backend.layouts.app')

@section('content')
    <div class="content">
        <div id="documentData"></div>
        <!-- Form inputs -->

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Add Document</h5>
        </div>

        <div class="card-body">

            {!! Form::open(['method'=>'POST','route'=>['document.store'],'class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data']) !!}

            <div class="row ">
                {!!Form::label('emp_no','Employee Number',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">
                    {!! Form::select('emp_no',$emp_no,$value=null,['class'=>"form-control select2",'placeholder'=>'']) !!}
                </div>
                {!!Form::label('name','Name',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('name',$value=null,['class'=>"form-control",'required'=>'required']) !!}
                </div>
                {!!Form::label('document','Upload Documents',['class'=>'col-form-label col-lg-2 require']) !!}

                <div class="form-group row col-lg-10 ">
                    {{Form::file('document[]', ['class' =>' form-control','multiple' => true,'required'=>'required'])}}
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
                url: '{{url('employee/document/showimage')}}'+'/' + emp_id,
                method: 'GET',
                success: function(data){

                    console.log(data);

                    $('#documentData').html(data);

                    $("#showRemoteData").waitMe("hide");

                }
            });
        });

    </script>
@endpush
