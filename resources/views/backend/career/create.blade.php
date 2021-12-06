@extends('backend.layouts.app')

@section('content')
    <div class="content">
        <div id="careerData"></div>

        <!-- Form inputs -->

            <div class="card-header header-elements-inline">
                <h5 class="card-title">Add Career</h5>
            </div>

            <div class="card-body">

                {!! Form::open(['method'=>'POST','route'=>['career.store'],'class'=>'form-horizontal','role'=>'form']) !!}

                <div class="form-group row">
                    {!!Form::label('emp_no','Employee Number',['class'=>'col-form-label col-lg-2 require']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('emp_no',$emp_no,$value=null,['class'=>"form-control select2",'placeholder'=>'']) !!}
                    </div>
                    {!!Form::label('position','Position',['class'=>'col-form-label col-lg-2 require']) !!}
                    <div class="col-lg-10">

                        {!! Form::text('position',$value=null,['class'=>"form-control",'required'=>'required']) !!}
                    </div>
                    {!!Form::label('date','Date',['class'=>'col-form-label col-lg-2 require']) !!}
                    <div class="col-lg-10">

                        {!! Form::text('date',$value=null,['class'=>"form-control",'required'=>'required']) !!}
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
        $('.toHide').hide();
        //for select
        $(".select2").select2({
            placeholder: "Select anyone",
            theme: 'modern',
            allowClear: true,
        });

        //its for pagination. when user click on
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var emp_id = $('.select2').val();
            var page = $(this).attr('href').split('page=')[1];
            showWaitMe();
            console.log(page)
            $.ajax({
                url: '{{url('employee/career/search')}}' + '/' + emp_id + '?page=' + page,
                method: 'GET',
                success: function (data) {
                    console.log(data);
                    $('#careerData').html(data);
                    $("#showRemoteData").waitMe("hide");

                }
            });
        });

        $('.select2').change(function (e) {
            var emp_id = $(this).val();
            console.log(emp_id);
            showWaitMe();
            $('.toHide').show();
            $.ajax({
                url: '{{url('employee/career/search')}}' + '/' + emp_id,
                method: 'GET',
                success: function (data) {
                    console.log(data);
                    $('#careerData').html(data);
                    $("#careerData").waitMe("hide");
                }
            });
        });

        function showWaitMe() {
            $('#careerData').waitMe({
                effect: 'bounce',
                text: 'Loading...',
                bg: "rgba(255,255,255,0.7)",
                color: "#000",
                maxSize: '',
                waitTime: -1,
                textPos: 'vertical',
                fontSize: '',
                source: '',
            });
        }

        $("form").submit(function (e) {
            e.preventDefault();
            console.log('submit clicked');
            var emp_no = $('.select2').val();
            var position = $('input[name=position]').val();
            var date = $('input[name=date]').val();
            console.log('form inputs:'+emp_no+" "+position+" "+date+")
            var _token = '{{csrf_token()}}';
            $.ajax({
                url: '{{ route('career.store') }}',
                method: 'POST',
                data: {
                    'emp_no': emp_no,
                    'position': position,
                    'date': date,
                    '_token': _token
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    refreshTable();
                    resetForm();
                    $("#careerData").waitMe("hide");
                }
            });
        });
        function  resetForm() {
            $('input[name=position]').val('');
            $('input[name=date]').val('');
        }
        function refreshTable() {
            var emp_id = $('.select2').val();
            showWaitMe();
            $.ajax({
                url: '{{url('employee/career/search')}}' + '/' + emp_id,
                method: 'GET',
                success: function (data) {
                    console.log(data);
                    $('#careerData').html(data);
                    $("#careerData").waitMe("hide");
                }
            });
        }
    </script>
@endpush
