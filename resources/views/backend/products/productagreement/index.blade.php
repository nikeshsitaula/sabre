@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <a href="#" id="printDoc"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2 mr-2"><b><i
                    class="icon-printer2"></i></b> Export Product Agreement</a>
        <div class="panel-heading mdl-color-text--red">Product Agreement</div>

        <div class="row">
            {!!Form::label('p_id','Product ID',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">
                {!! Form::select('p_id',$p_id,$value=null,['class'=>"form-control select2",'placeholder'=>'']) !!}
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
                    <table id="productagreement-table" class="table table-striped table-bordered mdl-data-table mt-2">
                        <thead>
                        <tr>
                            {{--                            <th>product ID</th>--}}
                            <th>Travel Agency Name</th>
                            <th>Travel ID</th>
                            <th>Agreement Date(YYYY-MM-DD)</th>
                            <th>Agreement Number</th>
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
                        <h5 class="modal-title" id="myModalTitle">Product Agreement</h5>
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
            $('#productagreement-table').hide();
            //used to store the selected product id from dropdown (its set as a global variable)
            var p_id = null;
            var current_page = null;
            $(".select2").select2({
                placeholder: "Select anyone",
                theme: 'modern',
                allowClear: true,
                minimumInputLength: 2
            });

            $('.select2').change(function (e) {
                e.preventDefault();
                $('#productagreement-table').show();
                //removing pagination and re adding it inside paginateBox div
                reloadPagination();
                //get the value of selected item from dropdown and store it
                p_id = $(this).val();
                //checks if selected value length is greater then 0. if not 0 then table won't show / load
                if (p_id.length > 0) {
                    // param is sent as fetch_data(default page id , employee id)
                    fetch_data(1, p_id);
                }
            });

            $('.search').click(function (e) {
                e.preventDefault();
                from = $('#dateFrom').val();
                to = $('#dateTo').val();
                $('#productagreement-table').show();
                //removing pagination and re adding it inside paginateBox div
                reloadPagination();
                //get the value of selected item from dropdown and store it
                p_id = $('.select2').val();
                //checks if selected value length is greater then 0. if not 0 then table won't show / load
                fetch_data(1, p_id, from, to);
            });

            function reloadPagination() {
                $('#pagination').remove();
                $('#paginateBox').html("<div id='pagination' class='mt-2'></div>");
            }

            function fetch_data(pageid, p_id, from, to) {

                $.ajax({
                    url: "productsagreement/fetch_data/?page=" + pageid,
                    method: "GET",
                    data: {
                        'p_id': p_id,
                        'from': from,
                        'to': to
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
                            // html += '<td contenteditable class="column_name" data-column_name="p_id" data-id="' + data[count].id + '">' + data[count].p_id + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="travelname" data-id="' + data[count].id + '">' + data[count].travelname + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="ta_id" data-id="' + data[count].id + '">' + data[count].ta_id + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="agreementdate" data-id="' + data[count].id + '">' + data[count].agreementdate + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="agreementnumber" data-id="' + data[count].id + '">' + data[count].agreementnumber + '</td>';
                            html += '<td><a data-id="' + data[count].id + '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> <button type="button" class="btn btn-danger btn-xs delete" id="' + data[count].id + '"><i class="fas fa-trash-alt"></i></button></td></tr>';
                        }
                        html += '<tr>';
                        // html += '<td id="p_id"></td>';
                        html += '<td contenteditable id="travelname"></td>';
                        html += '<td contenteditable id="ta_id"></td>';
                        html += '<td contenteditable id="agreementdate"></td>';
                        html += '<td contenteditable id="agreementnumber"></td>';
                        html += '<td><button type="button" class="btn btn-success btn-xs" id="add">Add</button></td></tr>';
                        $('tbody').html(html);
                        // $('#p_id').text(p_id);
                        // console.log('last page:' + last_page);

                        //using twitter bootstrap plugin

                        $('#pagination').twbsPagination({
                            totalPages: last_page,
                            visiblePages: 7,
                            initiateStartPageClick: false,
                            onPageClick: function (event, page) {
                                p_id = $('.select2').val();
                                fetch_data(page, p_id, from, to);
                            }
                        });
                    }
                });
            }

            var _token = $('input[name="_token"]').val();

            $(document).on('click', '#add', function () {
                var p_id = $('.select2').val();
                // var travelname = $('#travelname').text();
                var ta_id = $('#ta_id').text();
                var agreementdate = $('#agreementdate').text();
                var agreementnumber = $('#agreementnumber').text();
                if (p_id != '' && ta_id != '' && agreementdate != '' && agreementnumber != '') {
                    $.ajax({
                        url: "{{ route('productsagreement.store') }}",
                        method: "POST",
                        data: {
                            p_id: p_id,
                            // travelname: travelname,
                            ta_id: ta_id,
                            agreementdate: agreementdate,
                            agreementnumber: agreementnumber,
                            _token: _token
                        },
                        success: function (data) {
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
                            else
                                $('#message').html(data);
                            reloadPagination();
                            fetch_data(1, p_id);
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
                        url: "{{ route('productsagreement.update') }}",
                        method: "POST",
                        data: {column_name: column_name, column_value: column_value, id: id, _token: _token},
                        success: function (data) {
                            hideErrorMessage();
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
                            else
                                $('#message').html(data);
                            hideErrorMessage();
                            fetch_data(1, p_id);
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
                        url: "{{ route('productsagreement.delete_data') }}",
                        method: "POST",
                        data: {id: id, _token: _token},
                        success: function (data) {
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
                            else
                                $('#message').html(data);
                            hideErrorMessage();
                            reloadPagination();
                            fetch_data(1, p_id);
                        }
                    });
                }
            });


        });
        $('#productagreement-table').on('click', 'a#openShow', function (e) {
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
                url: 'productsagreement/showed/' + id,
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
            var p_id = $('.select2').val();
            from = $('#dateFrom').val();
            to = $('#dateTo').val();
            $.ajax({
                url: 'productsagreement/printproductsagreement/',
                method: 'GET',
                data: {
                    'from': from,
                    'to': to,
                    'p_id': p_id
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
