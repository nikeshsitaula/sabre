@extends('backend.layouts.app')

@section('content')
    <div class="content">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Add Experience</h5>
        </div>

        <div class="card-body">

            {{--            {!! Form::open(['method'=>'POST','route'=>['experience.store'],'class'=>'form-horizontal','role'=>'form']) !!}--}}
            <form>
                <div class="form-group row">
                    {!!Form::label('emp_no','Employee Number',['class'=>'col-form-label col-lg-2 require']) !!}
                    <div class="col-lg-10">
                        {!! Form::select('emp_no',$emp_no,$value=null,['class'=>"form-control select2",'placeholder'=>'']) !!}
                    </div>

                    <div class="col-lg-12">
                        <div id="experienceData"></div>
                    </div>

                    <div class="col-lg-4">

                        {!! Form::text('position',$value=null,['class'=>"form-control toHide",'required'=>'required']) !!}
                    </div>

                    <div class="col-lg-4">

                        {!! Form::text('organization',$value=null,['class'=>"form-control toHide",'required'=>'required']) !!}
                    </div>

                    <div class="col-lg-4">

                        {!! Form::text('duration',$value=null,['class'=>"form-control toHide",'required'=>'required']) !!}
                    </div>

                </div>

                <div class="text-right">
                    {{ Form::button('Submit <i class="icon-paperplane ml-2"></i>', ['type' => 'submit', 'class' => 'btn btn-primary legitRipple'] )  }}
                </div>
            </form>
            {{--            {!! Form::close() !!}--}}

        </div>
        <!-- /form inputs -->
        <!-- Modal -->
        <div class="modal fade" id="showData" tabindex="-1" role="dialog" aria-labelledby="showData"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalTitle">Experience</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body modal-lg" id="showRemoteData" style="height:350px;">

                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary mt-5" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                url: '{{url('employee/experience/search')}}' + '/' + emp_id + '?page=' + page,
                method: 'GET',
                success: function (data) {
                    console.log(data);
                    $('#experienceData').html(data);
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
                url: '{{url('employee/experience/search')}}' + '/' + emp_id,
                method: 'GET',
                success: function (data) {
                    console.log(data);
                    $('#experienceData').html(data);
                    $("#experienceData").waitMe("hide");
                }
            });
        });

        function showWaitMe() {
            $('#experienceData').waitMe({
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
            var organization = $('input[name=organization]').val();
            var duration = $('input[name=duration]').val();
            console.log('form inputs:'+emp_no+" "+position+" "+organization+" "+duration)
            var _token = '{{csrf_token()}}';
            $.ajax({
                url: '{{ route('experience.store') }}',
                method: 'POST',
                data: {
                    'emp_no': emp_no,
                    'position': position,
                    'organization': organization,
                    'duration': duration,
                    '_token': _token
                },
                dataType: 'json',
                success: function (data) {
                    console.log(data);
                    refreshTable();
                    resetForm();
                    $("#experienceData").waitMe("hide");
                }
            });
        });
        function  resetForm() {
            $('input[name=position]').val('');
            $('input[name=organization]').val('');
            $('input[name=duration]').val('');
        }
        function refreshTable() {
            var emp_id = $('.select2').val();
            showWaitMe();
            $.ajax({
                url: '{{url('employee/experience/search')}}' + '/' + emp_id,
                method: 'GET',
                success: function (data) {
                    console.log(data);
                    $('#experienceData').html(data);
                    $("#experienceData").waitMe("hide");
                }
            });
        }
        $('#experienceData').on('click', 'a#openShow', function (e) {
            e.preventDefault();
            $('#showData').modal('show');
            console.log('open show clicked')
            $('#showRemoteData').waitMe({
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

            var id = $(this).data('id');
            $.ajax({
                url: 'experience/showed/' + id,
                method: 'GET',
                success: function (data) {

                    console.log(data);

                    $('#showRemoteData').html(data);

                    $("#showRemoteData").waitMe("hide");

                }
            });
        });
    </script>
@endpush

