@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <a href="#" id="printDoc"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2 mr-2"><b><i
                    class="icon-printer2"></i></b> Export Visit</a>
        <div class="panel-heading mdl-color-text--red">Visit</div>

        <div class="row">
            {!!Form::label('ta_id','Travel Agency ID',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">
                {!! Form::select('ta_id',$ta_id,$value=null,['class'=>"form-control select2",'placeholder'=>'']) !!}
            </div>
            {!!Form::label('from','From',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">
                {!! Form::text('from',$value=null,['id'=>'dateFrom','class'=>"form-control ",'placeholder'=>'']) !!}
            </div>
            {!!Form::label('to','To',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">
                {!! Form::text('to',$value=null,['id'=>'dateTo','class'=>"form-control ",'placeholder'=>'']) !!}
            </div>
        </div>
        <div class="float-right mt-2">
            <button class="search btn btn-primary" style="padding-top: 5px;">Search</button>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div id="message"></div>
                <div class="table-responsive">
                    <table id="visit-table" class="table table-striped table-bordered mdl-data-table mt-2">
                        <thead>
                        <tr>
                            {{--<th>Trvel Agency ID</th>--}}
                            <th>User</th>
                            <th>Details</th>
                            <th>Date (YYYY-MM-DD)</th>
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
                        <h5 class="modal-title" id="myModalTitle">Visit</h5>
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

@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            //hides the table initially
            $('#visit-table').hide();
            var ta_id = null;
            var current_page = null;
            $(".select2").select2({
                placeholder: "Select anyone",
                minimumInputLength: 2,
                theme: 'modern',
                allowClear: true,
            });

            $('.search').click(function (e) {
                e.preventDefault();
                from = $('#dateFrom').val();
                to = $('#dateTo').val();
                $('#visit-table').show();
                //removing pagination and re adding it inside paginateBox div
                reloadPagination();
                //get the value of selected item from dropdown and store it
                ta_id = $('.select2').val();
                //checks if selected value length is greater then 0. if not 0 then table won't show / load
                fetch_data(1, ta_id, from, to);
            });

            function reloadPagination() {
                $('#pagination').remove();
                $('#paginateBox').html("<div id='pagination' class='mt-2'></div>");
            }

            function fetch_data(pageid, ta_id, from, to) {
                console.log('from:' + from + ' to:' + to)
                $.ajax({
                    url: "visit/fetch_data/?page=" + pageid,
                    method: "GET",
                    data: {
                        'ta_id': ta_id,
                        'from': from,
                        'to': to
                    },
                    dataType: "json",
                    success: function (data) {
                        //data includes last_page which has total pages
                        var last_page = data['last_page'];
                        current_page = data['current_page'];
                        // console.log('current_page=' + data['current_page'] + ' from=' + data['from'] + ' last_page=' + data['last_page']);
                        data = data.data;
                        var html = '';
                        for (var count = data.length - 1; count >= 0; count--) {
                            html += '<tr>';
                            // html += '<td contenteditable class="column_name" data-column_name="ta_id" data-id="' + data[count].id + '">' + data[count].ta_id + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="user" data-id="' + data[count].id + '">' + data[count].user + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="detail" data-id="' + data[count].id + '">' + data[count].detail + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="date" data-id="' + data[count].id + '">' + data[count].date + '</td>';
                            html += '<td><a data-id="' + data[count].id + '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> <button type="button" class="btn btn-danger btn-xs delete" id="' + data[count].id + '"><i class="fas fa-trash-alt"></i></button></td></tr>';
                        }
                        html += '<tr>';
                        // html += '<td id="ta_id"></td>';
                        html += '<td contenteditable id="user"></td>';
                        html += '<td contenteditable id="detail"></td>';
                        html += '<td contenteditable id="date"></td>';
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
                var user = $('#user').text();
                var detail = $('#detail').text();
                var date = $('#date').text();
                if (ta_id != '' && user != '' && detail != '' && date != '') {
                    $.ajax({
                        url: "{{ route('visit.store') }}",
                        method: "POST",
                        data: {
                            ta_id: ta_id,
                            user: user,
                            detail: detail,
                            date: date,
                            _token: _token
                        },
                        success: function (data) {
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
                            else
                                $('#message').html(data);
                            //removing pagination and re adding it inside paginateBox div
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
                        "\tAll fields are requred to be filled\n" +
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
                        url: "{{ route('visit.update') }}",
                        method: "POST",
                        data: {column_name: column_name, column_value: column_value, id: id, _token: _token},
                        success: function (data) {
                            hideErrorMessage();
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
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
                        url: "{{ route('visit.delete_data') }}",
                        method: "POST",
                        data: {id: id, _token: _token},
                        success: function (data) {
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
                            else
                                $('#message').html(data);
                            hideErrorMessage();
                            // reloadPagination();
                            fetch_data(current_page, ta_id);

                        }
                    });
                }
            });


        });

        $('#visit-table').on('click', 'a#openShow', function (e) {
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
                url: 'visit/showed/' + id,
                method: 'GET',
                success: function (data) {

                    console.log(data);

                    $('#showRemoteData').html(data);

                    $("#showRemoteData").waitMe("hide");

                }
            });
        })

        //Print Document
        $('#printDoc').on('click', function () {
            var ta_id = $('.select2').val();
            from = $('#dateFrom').val();
            to = $('#dateTo').val();
            $.ajax({
                url: 'visit/printVisit/',
                method: 'GET',
                data: {
                    'from': from,
                    'to': to,
                    'ta_id': ta_id
                },
                success: function (data) {
                    printPages(data);
                }
            });
        });

        function printPages(data) {
            var WinPrint = window.open('', '', 'left=0,top=0,width=1024,height=768,toolbar=0,scrollbars=0,status=0');
            WinPrint.document.open()
            WinPrint.document.write(data);
            WinPrint.document.close();
            WinPrint.print();
        }
    </script>
@endpush
