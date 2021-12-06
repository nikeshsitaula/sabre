@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <a href="#" id="printDoc"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2 mr-2"><b><i
                    class="icon-printer2"></i></b> Export Miscellaneous</a>
        <div class="panel-heading mdl-color-text--red">Miscellaneous</div>

        <div class="row">
            {!!Form::label('emp_id','Employee Number',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">
                {!! Form::select('emp_id',$emp_no,$value=null,['class'=>"form-control select2",'placeholder'=>'']) !!}
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-body">
                <div id="message"></div>
                <div class="table-responsive">
                    <table id="miscz-table" class="table table-striped table-bordered mdl-data-table mt-2">
                        <thead>
                        <tr>
{{--                            <th>Emp No</th>--}}
                            <th>Particular</th>
                            <th>Date</th>
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
                        <h5 class="modal-title" id="myModalTitle">Miscellaneous</h5>
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
            $('#miscz-table').hide();
            var emp_id = null;
            var current_page = null;
            $(".select2").select2({
                placeholder: "Select anyone",
                minimumInputLength: 2,
                theme: 'modern',
                allowClear: true,
            });

            $('.select2').change(function (e) {
                e.preventDefault();
                $('#miscz-table').show();
                //removing pagination and re adding it inside paginateBox div
                reloadPagination();
                //get the value of selected item from dropdown and store it
                emp_id = $(this).val();
                //checks if selected value length is greater then 0. if not 0 then table won't show / load
                if (emp_id.length > 0) {
                    fetch_data(1, emp_id);
                }
            });

            function reloadPagination() {
                $('#pagination').remove();
                $('#paginateBox').html("<div id='pagination' class='mt-2'></div>");
            }

            function fetch_data(pageid, emp_id) {

                $.ajax({
                    url: "miscz/fetch_data/?page=" + pageid,
                    method: "GET",
                    data: {
                        'emp_no': emp_id
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
                            // html += '<td contenteditable class="column_name" data-column_name="emp_no" data-id="' + data[count].id + '">' + data[count].emp_no + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="particular" data-id="' + data[count].id + '">' + data[count].particular + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="date" data-id="' + data[count].id + '">' + data[count].date + '</td>';
                            html += '<td><a data-id="' + data[count].id + '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> <button type="button" class="btn btn-danger btn-xs delete" id="' + data[count].id + '"><i class="fas fa-trash-alt"></i></button></td></tr>';
                        }
                        html += '<tr>';
                        // html += '<td id="emp_no"></td>';
                        html += '<td contenteditable id="particular"></td>';
                        html += '<td contenteditable id="date"></td>';
                        html += '<td><button type="button" class="btn btn-success btn-xs" id="add">Add</button></td></tr>';
                        $('tbody').html(html);
                        // $('#emp_no').text(emp_id);
                        // console.log('last page:' + last_page);

                        //using twitter bootstrap plugin

                        $('#pagination').twbsPagination({
                            totalPages: last_page,
                            visiblePages: 7,
                            initiateStartPageClick: false,
                            onPageClick: function (event, page) {
                                emp_id = $('.select2').val();
                                fetch_data(page, emp_id);
                            }
                        });
                    }
                });
            }

            var _token = $('input[name="_token"]').val();

            $(document).on('click', '#add', function () {
                var emp_no = $('.select2').val();
                var particular = $('#particular').text();
                var date = $('#date').text();
                if (emp_no != '' && particular != '' && date != '' ) {
                    $.ajax({
                        url: "{{ route('miscz.store') }}",
                        method: "POST",
                        data: {
                            emp_no: emp_no,
                            particular: particular,
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
                            fetch_data(1, emp_id);
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
                        url: "{{ route('miscz.update') }}",
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
                        url: "{{ route('miscz.delete_data') }}",
                        method: "POST",
                        data: {id: id, _token: _token},
                        success: function (data) {
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
                            else
                                $('#message').html(data);
                            hideErrorMessage();
                            // reloadPagination();
                            fetch_data(current_page, emp_id);

                        }
                    });
                }
            });


        });

        $('#miscz-table').on('click', 'a#openShow', function (e) {
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
                url: 'miscz/showed/' + id,
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
            if(emp !==''){
                var id = $('.select2').val()
                $.ajax({
                    url: 'miscz/printMiscz/' + id,
                    method: 'GET',
                    success: function (data) {
                        printPages(data);
                    }
                });
            }else {
                alert('please select an employee first');
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
