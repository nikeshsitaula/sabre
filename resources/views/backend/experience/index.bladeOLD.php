<!--@extends('backend.layouts.app')-->
<!--@section('content')-->
<!--    <div class="content">-->
<!--        <a href="{{route('experience.create')}}" class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right "><b><i class="icon-graduation"></i></b> Add Experience</a>-->
<!---->
<!--        <div class="row">-->
<!---->
<!---->
<!--            {{--<div id="experienceData"></div>--}}-->
<!---->
<!--            <div class="card-header header-elements-inline">-->
<!--                <h5 class="card-title">Add Experience</h5>-->
<!--            </div>-->
<!---->
<!--            <div class="card-body">-->
<!---->
<!--                {!! Form::open(['method'=>'POST','route'=>['experience.store'],'class'=>'form-horizontal','role'=>'form']) !!}-->
<!---->
<!--                <div class="form-group row">-->
<!--                    {!!Form::label('emp_no','Employee Number',['class'=>'col-form-label col-lg-2 require']) !!}-->
<!--                    <div class="col-lg-10">-->
<!--                        {!! Form::select('emp_no',$emp_no,$value=null,['class'=>"form-control select2",'placeholder'=>'']) !!}-->
<!--                    </div>-->
<!---->
<!--                    {!!Form::label('position','Position',['class'=>'col-form-label col-lg-2 require toHide']) !!}-->
<!--                    <div class="col-lg-10">-->
<!---->
<!--                        {!! Form::text('position',$value=null,['class'=>"form-control toHide",'required'=>'required']) !!}-->
<!--                    </div>-->
<!--                    {!!Form::label('organization','Organization',['class'=>'col-form-label col-lg-2 require toHide']) !!}-->
<!--                    <div class="col-lg-10">-->
<!---->
<!--                        {!! Form::text('organization',$value=null,['class'=>"form-control toHide",'required'=>'required']) !!}-->
<!--                    </div>-->
<!--                    {!!Form::label('duration','Duration',['class'=>'col-form-label col-lg-2 require toHide']) !!}-->
<!--                    <div class="col-lg-10">-->
<!---->
<!--                        {!! Form::text('duration',$value=null,['class'=>"form-control toHide",'required'=>'required']) !!}-->
<!--                    </div>-->
<!---->
<!--                </div>-->
<!---->
<!--                <div class="text-right">-->
<!--                    {{ Form::button('Submit <i class="icon-paperplane ml-2"></i>', ['type' => 'submit', 'class' => 'btn btn-primary legitRipple'] )  }}-->
<!--                </div>-->
<!---->
<!--            {!! Form::close() !!}-->
<!---->
<!---->
<!--            <!-- /form inputs -->-->
<!--            </div>-->
<!---->
<!--            <!-- Modal -->-->
<!--            <div class="modal fade" id="showData" tabindex="-1" role="dialog" aria-labelledby="showData"-->
<!--                 aria-hidden="true">-->
<!--                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">-->
<!--                    <div class="modal-content">-->
<!--                        <div class="modal-header">-->
<!--                            <h5 class="modal-title" id="myModalTitle">Employee</h5>-->
<!--                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                                <span aria-hidden="true">&times;</span>-->
<!--                            </button>-->
<!--                        </div>-->
<!--                        <div class="modal-body modal-lg" id="showRemoteData" style="height:350px;">-->
<!---->
<!--                        </div>-->
<!--                        <div class="modal-footer mt-3">-->
<!--                            <button type="button" class="btn btn-secondary mt-5" data-dismiss="modal">Close</button>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!---->
<!--        <table class="mdl-data-table mt-2 experience-table" id="experience-table" style="width: 1000px;">-->
<!--            <thead>-->
<!--            <tr>-->
<!--                <th>Emp No</th>-->
<!--                <th>Position</th>-->
<!--                <th>Organization</th>-->
<!--                <th>Duration</th>-->
<!--                <th>Action</th>-->
<!--            </tr>-->
<!--            </thead>-->
<!--        </table>-->
<!--    </div>-->
<!---->
<!--@endsection-->
<!--@push('scripts')-->
<!--    <script>-->
<!--        //hides the table-->
<!--        $('#experience-table').hide();-->
<!--        $('.toHide').hide();-->
<!--        //for dropdown-->
<!--        $(".select2").select2({-->
<!--            placeholder: "Select anyone",-->
<!--            theme: 'modern',-->
<!--            allowClear: true,-->
<!--        });-->
<!---->
<!--        //when any dropdown item is selected then this event is triggered and the value of selected item is fetched-->
<!--        $('.select2').change(function (e) {-->
<!--            e.preventDefault();-->
<!--            //get the value of selected item from dropdown-->
<!--            var emp_id = $(this).val();-->
<!--            console.log(emp_id);-->
<!--            //checks if selected value length is greater then 0. if not 0 then table won't show / load-->
<!--            if (emp_id.length > 0) {-->
<!--                $('#experience-table').show();-->
<!--                $('.toHide').show();-->
<!--                $('#experience-table').DataTable().destroy();-->
<!---->
<!--                var table = $('#experience-table').DataTable({-->
<!--                    processing: true,-->
<!--                    serverSide: true,-->
<!--                    ajax: '{{url('employee/experience/list/experience')}}' + '/' + emp_id,-->
<!--                    columns: [-->
<!--                        {data: 'emp_no', name: 'emp_no'},-->
<!--                        {data: 'position', name: 'position'},-->
<!--                        {data: 'organization', name: 'organization'},-->
<!--                        {data: 'duration', name: 'duration'},-->
<!--                        {data: 'action', name: 'action'},-->
<!--                    ],-->
<!--                    searching: false-->
<!--                });-->
<!---->
<!--                $('#experience-table').on('click', 'a#openShow', function (e) {-->
<!--                    e.preventDefault();-->
<!--                    $('#showData').modal('show');-->
<!---->
<!--                    $('#showRemoteData').waitMe({-->
<!--                        effect: 'bounce',-->
<!--                        text: 'Loading...',-->
<!--                        bg: "rgba(255,255,255,0.7)",-->
<!--                        color: "#000",-->
<!--                        maxSize: '',-->
<!--                        waitTime: -1,-->
<!--                        textPos: 'vertical',-->
<!--                        fontSize: '',-->
<!--                        source: '',-->
<!--                    });-->
<!---->
<!--                    var id = $(this).data('id');-->
<!--                    $.ajax({-->
<!--                        url: 'experience/showed/' + id,-->
<!--                        method: 'GET',-->
<!--                        success: function (data) {-->
<!---->
<!--                            console.log(data);-->
<!---->
<!--                            $('#showRemoteData').html(data);-->
<!---->
<!--                            $("#showRemoteData").waitMe("hide");-->
<!---->
<!--                        }-->
<!--                    });-->
<!--                });-->
<!--            }-->
<!--            {{--$.ajax({--}}-->
<!--            {{--url: '{{url('employee/experience/search')}}'+'/' + emp_id,--}}-->
<!--            {{--method: 'GET',--}}-->
<!--            {{--success: function(data){--}}-->
<!---->
<!--            {{--console.log(data);--}}-->
<!---->
<!--            {{--$('#experienceData').html(data);--}}-->
<!---->
<!--            {{--$("#showRemoteData").waitMe("hide");--}}-->
<!---->
<!--            {{--}--}}-->
<!--            {{--});--}}-->
<!--        });-->
<!---->
<!---->
<!--        $('.experience-table tbody').on('dblclick', 'tr', function () {-->
<!--            console.log('clicked');-->
<!--            var data = table.row(this).data();-->
<!--            window.location.replace('experience/edit/' + data.id);-->
<!--        });-->
<!--    </script>-->
<!---->
<!---->
<!--@endpush-->
