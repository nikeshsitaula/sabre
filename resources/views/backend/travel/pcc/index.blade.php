@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <div class="panel-heading mdl-color-text--red">PCC</div>
        <a href="#" id="printDoc"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2 mr-2"><b><i
                    class="icon-printer2"></i></b> Export PCC</a>
        <div class="row">
            {!!Form::label('ta_id','Travel Agency ID',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">
                {!! Form::select('ta_id',$ta_id,$value=null,['class'=>"form-control select2",'placeholder'=>'']) !!}
            </div>

        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div id="message"></div>
                <div class="table-responsive">
                    <table id="pcc-table" class="table table-striped table-bordered mdl-data-table mt-2">
                        <thead>
                        <tr>
                            {{--<th>TravelAgency ID</th>--}}
                            <th>PCC</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Fax</th>
                            <th>Email</th>
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
                        <h5 class="modal-title" id="myModalTitle">PCC</h5>
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
            $('#pcc-table').hide();
            //used to store the selected travelagency id from dropdown (its set as a global variable)
            var ta_id = null;
            var current_page = null;
            $(".select2").select2({
                placeholder: "Select anyone",
                theme: 'modern',
                allowClear: true,
                minimumInputLength:2
            });

            $('.select2').change(function (e) {
                e.preventDefault();
                $('#pcc-table').show();
                //removing pagination and re adding it inside paginateBox div
                reloadPagination();
                //get the value of selected item from dropdown and store it
                ta_id = $(this).val();
                //checks if selected value length is greater then 0. if not 0 then table won't show / load
                if (ta_id.length > 0) {
                    // param is sent as fetch_data(default page id , travelagency id)
                    fetch_data(1,ta_id);
                }
            });
            function reloadPagination() {
                $('#pagination').remove();
                $('#paginateBox').html("<div id='pagination' class='mt-2'></div>");
            }

            function fetch_data(pageid, ta_id) {

                $.ajax({
                    url: "pcc/fetch_data/?page=" + pageid,
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
                            // html += '<td contenteditable class="column_name" data-column_name="ta_id" data-id="' + data[count].id + '">' + data[count].ta_id + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="br_pcc" data-id="' + data[count].id + '">' + data[count].br_pcc + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="br_address" data-id="' + data[count].id + '">' + data[count].br_address + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="br_phone" data-id="' + data[count].id + '">' + data[count].br_phone + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="br_fax_no" data-id="' + data[count].id + '">' + data[count].br_fax_no + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="br_email" data-id="' + data[count].id + '">' + data[count].br_email + '</td>';
                            html += '<td><a data-id="'+data[count].id+'" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> <button type="button" class="btn btn-danger btn-xs delete" id="' + data[count].id + '"><i class="fas fa-trash-alt"></i></button></td></tr>';
                        }
                        html += '<tr>';
                        // html += '<td id="ta_id"></td>';
                        html += '<td contenteditable id="br_pcc"></td>';
                        html += '<td contenteditable id="br_address"></td>';
                        html += '<td contenteditable id="br_phone"></td>';
                        html += '<td contenteditable id="br_fax_no"></td>';
                        html += '<td contenteditable id="br_email"></td>';
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
                                fetch_data(page, ta_id);
                            }
                        });
                    }
                });
            }

            var _token = $('input[name="_token"]').val();

            $(document).on('click', '#add', function () {
                var ta_id = $('.select2').val();
                var br_pcc = $('#br_pcc').text();
                var br_address = $('#br_address').text();
                var br_phone = $('#br_phone').text();
                var br_fax_no = $('#br_fax_no').text();
                var br_email = $('#br_email').text();
                if (ta_id != '' && br_pcc != '' && br_address != '' && br_phone != '' && br_email != '' ) {
                    $.ajax({
                        url: "{{ route('pcc.store') }}",
                        method: "POST",
                        data: {
                            ta_id: ta_id,
                            br_pcc: br_pcc,
                            br_address: br_address,
                            br_phone: br_phone,
                            br_fax_no: br_fax_no,
                            br_email: br_email,
                            _token: _token
                        },
                        success: function (data) {
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
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
                        url: "{{ route('pcc.update') }}",
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
                        url: "{{ route('pcc.delete_data') }}",
                        method: "POST",
                        data: {id: id, _token: _token},
                        success: function (data) {
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
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

        $('#pcc-table').on('click', 'a#openShow', function (e) {
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
                url: 'pcc/showed/' + id,
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
                    url: 'pcc/printPCC/' + id,
                    method: 'GET',
                    success: function (data) {
                        printPages(data);
                    }
                });
            } else {
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

    </script>
@endpush
