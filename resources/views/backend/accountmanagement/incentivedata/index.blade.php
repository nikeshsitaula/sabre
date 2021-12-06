@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <div class="panel-heading mdl-color-text--red">Incentive Controller</div>
        <a href="#" id="printDoc"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2 mr-2"><b><i
                    class="icon-printer2"></i></b> Export</a>

        <a href="#" id="updateincentivedata"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2 mr-2"><b><i
                    class="icon-paste2"></i></b> Update Incentive Controller</a>

        <div class="row">
            {!!Form::label('ta_id','Travel Agency ID',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">
                {!! Form::select('ta_id',$ta_id,$value=null,['class'=>"form-control select2",'placeholder'=>'']) !!}
            </div>
        </div>
        <div class="float-right mt-2">
            <button class="search btn btn-primary" style="padding-top: 5px;">Search</button>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div id="message"></div>
                <div class="table-responsive">
                    <table id="incentivedata-index" class="table table-striped table-bordered mdl-data-table mt-2">
                        <thead>
                        <tr>
                            {{--<th>Travel Agency ID</th>--}}
                            <th>Volume Commitment</th>
                            <th>Contact Period (MM)</th>
                            <th>Target Segment</th>
                            <th>Segment To Month</th>
                            <th>Start Date(YYYY-MM-DD)</th>
                            <th>Market Share (%)</th>
                            <th>ToMonth Market Share</th>
                            <th>Month</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                    {{ csrf_field() }}
                </div>
                <div id="paginateBox">
                    <div id="pagination" class="mt-2"></div>
                </div>

            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="showData" tabindex="-1" role="dialog" aria-labelledby="showData" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalTitle">Incentive Controller</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body modal-lg" id="showRemoteData" style="height:500px;">

                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary mt-5" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>


        $(document).ready(function () {
            //hides the table initially
            $('#incentivedata-index').hide();
            //used to store the selected travelagency id from dropdown (its set as a global variable)
            var ta_id = null;
            var current_page = null;
            $(".select2").select2({
                placeholder: "Select anyone",
                theme: 'modern',
                allowClear: true,
                minimumInputLength: 2
            });
            $(".search").click(function (e) {

                    e.preventDefault();
                    $('#incentivedata-index').show();
                    //removing pagination and re adding it inside paginateBox div
                    reloadPagination();
                    //get the value of selected item from dropdown and store it
                    ta_id = $('.select2').val();
                    //checks if selected value length is greater then 0. if not 0 then table won't show / load

                    // param is sent as fetch_data(default page id , travelagency id)
                    fetch_data(1, ta_id);

                }
            );

            function reloadPagination() {
                $('#pagination').remove();
                $('#paginateBox').html("<div id='pagination' class='mt-2'></div>");
            }

            function fetch_data(pageid, ta_id) {
                $.ajax({
                    url: "incentivedata/fetch_data/?page=" + pageid,
                    method: "GET",
                    data: {
                        'ta_id': ta_id
                    },
                    dataType: "json",
                    success: function (data) {
                        //data includes last_page which has total pages
                        var last_page = data['last_page'];
                        // console.log('current_page=' + data['current_page'] + ' from=' + data['from'] + ' last_page=' + data['last_page']);
                        data = data.data;
                        var html = '';
                        for (var count = data.length - 1; count >= 0; count--) {
                            html += '<tr>';
                            html += '<td contenteditable class="column_name" data-column_name="volumecommitment" data-id="' + data[count].id + '">' + data[count].volumecommitment + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="contactperiod" data-id="' + data[count].id + '">' + data[count].contactperiod + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="targetsegment" data-id="' + data[count].id + '">' + data[count].targetsegment + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="segmenttomonth" data-id="' + data[count].id + '">' + data[count].segmenttomonth + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="startdate" data-id="' + data[count].id + '">' + data[count].startdate + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="marketshare" data-id="' + data[count].id + '">' + data[count].marketshare + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="tomonthmarketshare" data-id="' + data[count].id + '">' + data[count].tomonthmarketshare + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="month" data-id="' + data[count].id + '">' + data[count].month + '</td>';
                            html += '<td><a data-id="' + data[count].id + '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> <button type="button" class="btn btn-danger btn-xs delete" id="' + data[count].id + '"><i class="fas fa-trash-alt"></i></button></td></tr>';
                        }
                        html += '<tr>';
                        html += '<td contenteditable id="volumecommitment"></td>';
                        html += '<td contenteditable id="contactperiod"></td>';
                        html += '<td contenteditable id="targetsegment"></td>';
                        html += '<td contenteditable id="segmenttomonth"></td>';
                        html += '<td contenteditable id="startdate"></td>';
                        html += '<td contenteditable id="marketshare"></td>';
                        html += '<td contenteditable id="tomonthmarketshare"></td>';
                        html += '<td contenteditable id="month"></td>';
                        // html += '<td id="ta_id"></td>';
                        html += '<td><button type="button" class="btn btn-success btn-xs" id="add">Add</button></td></tr>';
                        $('tbody').html(html);
                        // $('#ta_id').text(ta_id);
                        // console.log('last page:' + last_page);

                        //using twitter bootstrap plugin

                        $('#pagination').twbsPagination({
                            totalPages: last_page,
                            visiblePages: 7,
                            initiateStartPageClick: false,
                            onPageClick: function (event, page) {
                                ta_id = $('.select2').val();
                                fetch_data(page, ta_id, from, to);
                            }
                        });
                    }
                });
            }

            var _token = $('input[name="_token"]').val();

            $(document).on('click', '#add', function () {
                var ta_id = $('.select2').val();
                var volumecommitment = $('#volumecommitment').text();
                var contactperiod = $('#contactperiod').text();
                var targetsegment = $('#targetsegment').text();
                var segmenttomonth = $('#segmenttomonth').text();
                var startdate = $('#startdate').text();
                var marketshare = $('#marketshare').text();
                var tomonthmarketshare = $('#tomonthmarketshare').text();
                var month = $('#month').text();
                if (startdate != '') {
                    $.ajax({
                        url: "{{ route('incentivedata.store') }}",
                        method: "POST",
                        data: {
                            ta_id: ta_id,
                            volumecommitment: volumecommitment,
                            contactperiod: contactperiod,
                            targetsegment: targetsegment,
                            segmenttomonth: segmenttomonth,
                            startdate: startdate,
                            marketshare: marketshare,
                            tomonthmarketshare: tomonthmarketshare,
                            month: month,
                            _token: _token
                        },
                        success: function (data) {
                            if (data.indexOf("You do not have permission to do that.") >= 0)
                                alert('You do not have permission to do that.');
                            else
                                $('#message').html(data);
                            reloadPagination();
                            fetch_data(1, ta_id);
                            hideErrorMessage();
                        }
                    });
                } else {
                    $('#message').html("<div class=\"alert alert-danger\" role=\"alert\">\n" +
                        "        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                        "            <span aria-hidden=\"true\">&times;</span>\n" +
                        "        </button>\n" +
                        "\tStart Date must be entered\n" +
                        "    </div>");

                    hideErrorMessage();
                }
            });
            $(document).on('blur', '.column_name', function () {
                var column_name = $(this).data("column_name");
                var column_value = $(this).text();
                var id = $(this).data("id");

                if (column_value != '') {
                    $.ajax({
                        url: "{{ route('incentivedata.update') }}",
                        method: "POST",
                        data: {column_name: column_name, column_value: column_value, id: id, _token: _token},
                        success: function (data) {
                            hideErrorMessage();
                            if (data.indexOf("You do not have permission to do that.") >= 0)
                                alert('You do not have permission to do that.');
                            else
                                $('#message').html(data);
                        }
                    })
                } else {
                    $('#message').html("<div class=\"alert alert-danger\" role=\"alert\">\n" +
                        "        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                        "            <span aria-hidden=\"true\">&times;</span>\n" +
                        "        </button>\n" +
                        "\tEnter some value \n" +
                        "    </div>");
                    hideErrorMessage();
                }
            });

            $(document).on('click', '.delete', function () {
                var id = $(this).attr("id");
                if (confirm("Are you sure you want to delete this records?")) {
                    $.ajax({
                        url: "{{ route('incentivedata.delete_data') }}",
                        method: "POST",
                        data: {id: id, _token: _token},
                        success: function (data) {
                            if (data.indexOf("You do not have permission to do that.") >= 0)
                                alert('You do not have permission to do that.');
                            else
                                $('#message').html(data);
                            hideErrorMessage();
                            reloadPagination();
                            fetch_data(1, ta_id);
                        }
                    });
                }
            });
        });

        $('#incentivedata-index').on('click', 'a#openShow', function (e) {
            e.preventDefault();
            $('#showData').modal('show');

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
                url: 'incentivedata/showed/' + id,
                method: 'GET',
                success: function (data) {

                    console.log(data);

                    $('#showRemoteData').html(data);

                    $("#showRemoteData").waitMe("hide");

                }
            });
        });

        //Print Document
        $('#printDoc').on('click', function () {
            var ta_id = $('.select2').val();
            if(ta_id !==''){
                var id = $('.select2').val();
                $.ajax({
                    url: 'incentivedata/printincentivedata/' + id,
                    method: 'GET',
                    success: function (data) {
                        printPages(data);
                    }
                });
            }else {
                alert('please select a travel agency first');
            }
        });
        function printPages(data) {
            var WinPrint = window.open('', '', 'left=0,top=0,width=1024,height=768,toolbar=0,scrollbars=0,status=0');
            WinPrint.document.open()
            WinPrint.document.write(data);
            WinPrint.document.close();
            WinPrint.print();
        }

        //Update Account Manager Document
        var _token = $('input[name="_token"]').val();

        $('#updateincentivedata').on('click', function () {
            var ta_id = $('.select2').val();
            if(ta_id !==''){
                var dateval = prompt("Please enter a date(YYYY-MM-DD):");
                console.log(dateval);
                $.ajax({
                    headers: {
                        'X-CSRF-Token': _token
                    },
                    url: 'incentivedata/updateincentivedata/' + ta_id,
                    data:{
                        'endDate': dateval
                    },
                    method: 'POST',
                    success: function (data) {
                        console.log(data);
                        // reloadPagination();
                        history.go(0);
                        alert('successfully updated data of incentive controller');
                    }

                });
            }else {
                alert('please select a travel agency first');
            }
        });

    </script>
@endpush
