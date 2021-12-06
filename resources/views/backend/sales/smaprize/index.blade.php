@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <div class="panel-heading mdl-color-text--red">SMA Prize</div>
        <a href="#" id="printDoc"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2 mr-2"><b><i
                    class="icon-printer2"></i></b> Export SMA Other Cost</a>
        <div class="row">
            {!!Form::label('sma_id','SMA ID',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">
                {!! Form::select('sma_id',$sma_id,$value=null,['class'=>"form-control select2",'placeholder'=>'']) !!}
            </div>

        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div id="message"></div>
                <div class="table-responsive">
                    <table id="smaprize-table" class="table table-striped table-bordered mdl-data-table mt-2">
                        <thead>
                        <tr>
                            {{--<th>SMA ID</th>--}}
                            <th>Travel ID</th>
                            <th>Staff No</th>
                            <th>Prize Amount</th>
                            <th>Prize Other</th>
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
                        <h5 class="modal-title" id="myModalTitle">SMA Other Cost</h5>
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
            $('#smaprize-table').hide();
            //used to store the selected travelagency id from dropdown (its set as a global variable)
            var sma_id = null;
            var current_page = null;
            $(".select2").select2({
                placeholder: "Select anyone",
                theme: 'modern',
                allowClear: true,
                minimumInputLength:2
            });

            $('.select2').change(function (e) {
                e.preventDefault();
                $('#smaprize-table').show();
                //removing pagination and re adding it inside paginateBox div
                reloadPagination();
                //get the value of selected item from dropdown and store it
                sma_id = $(this).val();
                //checks if selected value length is greater then 0. if not 0 then table won't show / load
                if (sma_id.length > 0) {
                    // param is sent as fetch_data(default page id , travelagency id)
                    fetch_data(1,sma_id);
                }
            });
            function reloadPagination() {
                $('#pagination').remove();
                $('#paginateBox').html("<div id='pagination' class='mt-2'></div>");
            }

            function fetch_data(pageid, sma_id) {

                $.ajax({
                    url: "smaprize/fetch_data/?page=" + pageid,
                    method: "GET",
                    data: {
                        'sma_id': sma_id
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
                            // html += '<td contenteditable class="column_name" data-column_name="sma_id" data-id="' + data[count].id + '">' + data[count].sma_id + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="ta_id" data-id="' + data[count].id + '">' + data[count].ta_id + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="staff_no" data-id="' + data[count].id + '">' + data[count].staff_no + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="prizeamount" data-id="' + data[count].id + '">' + data[count].prizeamount + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="prizeother" data-id="' + data[count].id + '">' + data[count].prizeother + '</td>';
                            html += '<td><a data-id="'+data[count].id+'" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> <button type="button" class="btn btn-danger btn-xs delete" id="' + data[count].id + '"><i class="fas fa-trash-alt"></i></button></td></tr>';
                        }
                        html += '<tr>';
                        // html += '<td id="sma_id"></td>';
                        html += '<td contenteditable id="ta_id"></td>';
                        html += '<td contenteditable id="staff_no"></td>';
                        html += '<td contenteditable id="prizeamount"></td>';
                        html += '<td contenteditable id="prizeother"></td>';
                        html += '<td><button type="button" class="btn btn-success btn-xs" id="add">Add</button></td></tr>';
                        $('tbody').html(html);
                        // $('#sma_id').text(sma_id);
                        // console.log('last page:' + last_page);

                        //using twitter bootstrap plugin

                        $('#pagination').twbsPagination({
                            totalPages: last_page,
                            visiblePages: 7,
                            initiateStartPageClick: false,
                            onPageClick: function (event, page) {
                                sma_id = $('.select2').val();
                                fetch_data(page, sma_id);
                            }
                        });
                    }
                });
            }

            var _token = $('input[name="_token"]').val();

            $(document).on('click', '#add', function () {
                var sma_id = $('.select2').val();
                var ta_id = $('#ta_id').text();
                var staff_no = $('#staff_no').text();
                var prizeamount = $('#prizeamount').text();
                var prizeother = $('#prizeother').text();
                if (sma_id != '' && ta_id != '' && staff_no != '' && prizeamount != '' && prizeother != '') {
                    $.ajax({
                        url: "{{ route('smaprize.store') }}",
                        method: "POST",
                        data: {
                            sma_id: sma_id,
                            ta_id: ta_id,
                            staff_no: staff_no,
                            prizeamount: prizeamount,
                            prizeother: prizeother,
                            _token: _token
                        },
                        success: function (data) {
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
                            else
                                $('#message').html(data);
                            reloadPagination();
                            fetch_data(1, sma_id);
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
                        url: "{{ route('smaprize.update') }}",
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
                        url: "{{ route('smaprize.delete_data') }}",
                        method: "POST",
                        data: {id: id, _token: _token},
                        success: function (data) {
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
                            else
                                $('#message').html(data);
                            hideErrorMessage();
                            reloadPagination();
                            fetch_data(1, sma_id);
                        }
                    });
                }
            });


        });

        $('#smaprize-table').on('click', 'a#openShow', function (e) {
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
                url: 'smaprize/showed/' + id,
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
            var emp = $('.select2').val();
            if (emp !== '') {
                var id = $('.select2').val()
                $.ajax({
                    url: 'smaprize/printsmaprize/' + id,
                    method: 'GET',
                    success: function (data) {
                        printPages(data);
                    }
                });
            } else {
                alert('please select a sales and marketing id first');
            }
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
