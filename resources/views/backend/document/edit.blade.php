@extends('backend.layouts.app')

@section('content')
    <div class="content">

        <!-- Form inputs -->

        <div class="card-header header-elements-inline">
            <h5 class="card-title">Add Experience</h5>
        </div>

        <div class="card-body">

            {!! Form::model($document,['method'=>'PUT','route'=>['document.update',$document->id],'class'=>'form-horizontal','role'=>'form']) !!}

            <div class="form-group row">
                {!!Form::label('emp_no','Employee Number',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">
                    {!! Form::select('emp_no',$emp_no,$value=null,['class'=>"form-control select2",'placeholder'=>'']) !!}
                </div>
                {!!Form::label('name','Name',['class'=>'col-form-label col-lg-2 require']) !!}
                <div class="col-lg-10">

                    {!! Form::text('name',$value=null,['class'=>"form-control",'required'=>'required']) !!}
                </div>
            </div>
        </div>

        <div class="text-right">
            <button type="submit" class="btn btn-primary legitRipple">Submit <i
                    class="icon-paperplane ml-2"></i></button>
        </div>

        {!! Form::close() !!}

        {!! Form::open(['method'=>'POST','route'=>['document.addImage', $document->id],'class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data']) !!}

        <div class="row">
            {!! Form::hidden('emp_no',$document->emp_no,['class'=>"form-control"]) !!}
            {!!Form::label('document','Add Document',['class'=>'col-form-label col-md-2 require']) !!}
            <div class="col-md-10">
                {{Form::file('document[]', ['class' =>' form-control','multiple' => true,'required' => 'required'])}}
            </div>
            <div class="text-right col-md-3">
                <button type="submit" class="btn btn-success legitRipple">Add <i
                        class="icon-plus3 ml-2"></i></button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

        <div class="row">
            @foreach($images as $image)
                <div class="col-md-2">
                    <div class="row">
                        <div class="col-md-12" style="text-align: center">
                            <a href="/storage/document_images/{{$image->name}}"><img class="img-responsive"
                                                                                     style="width:150px; height: 150px;"
                                                                                     src="/storage/document_images/{{$image->name}}"/></a>
                        </div>
                        <div class="col-md-12" style="text-align: center">
                            <a href="{{ route('document.deleteImage', $image->id) }}" onclick="return confirm('Are you sure?')"
                               class="btn btn-danger legitRipple mt-1" >Delete &nbsp;<i class="fas fa-trash-alt"></i></a>
                        </div>
                    </div>
                </div>

            @endforeach
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
    </script>
@endpush
