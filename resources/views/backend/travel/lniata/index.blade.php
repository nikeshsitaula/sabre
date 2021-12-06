@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <div id="message"></div>

        <a href="#" id="printDoc"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2 mr-2"><b><i
                    class="icon-printer2"></i></b> Export LNIATA</a>
        <div class="panel-heading mdl-color-text--red">LNIATA</div>

        <div class="row">
            {!!Form::label('ta_id','Travel Agency ID',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">
                {!! Form::select('ta_id',$ta_id,$value=null,['id'=>'ta_id','class'=>"form-control select2",'placeholder'=>'']) !!}
            </div>

            {!!Form::label('pcc','PCC',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">
                {!! Form::select('pcc',['null'=>'null'],$value=null,['id'=>'pcc','class'=>"form-control select2",'placeholder'=>'']) !!}
            </div>
        </div>
        <div class="float-right mt-2">
            <button class="search btn btn-primary" style="padding-top: 5px;">Search</button>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="lniata-table" class="table table-striped table-bordered mdl-data-table mt-2">
                        <thead>
                        <tr>
                            {{--<th>TravelAgency ID</th>--}}
                            <th>pcc</th>
                            <th>lniata</th>
                            <th>user</th>
                            <th>remark</th>
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
                        <h5 class="modal-title" id="myModalTitle">LNIATA</h5>
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
            $('#lniata-table').hide();
            //used user store the selected travelagency id remark dropdown (its set as a global variable)
            var ta_id = null;
            var pcc = null;
            var current_page = null;
            $(".select2").select2({
                placeholder: "Select anyone",
                theme: 'modern',
                allowClear: true,
                minimumInputLength: 2
            });

            $("#pcc").select2({
                placeholder: "Select anyone",
                theme: 'modern',
                allowClear: true,
                ajax: {
                    url: 'staff/filterPCCDropdown',
                    dataType: 'json',
                    type: "GET",
                    quietMillis: 50,
                    data: function (name) {
                        return {
                            value: name.term,
                            ta_id: $('#ta_id').val(),
                            page: name.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    text: 'PCC:'+item.br_pcc+'  Travel Agency:'+item.ta_id+'  Address:'+item.br_address,
                                    id: item.br_pcc,
                                }
                            }),
                            'pagination': {
                                'more': data.data.length
                            }
                        };
                    },
                    cache: true
                },
            });
            $(".search").click(function (e) {
                e.preventDefault();
                //     $('#lniata-table').show();
                //     //removing pagination and re adding it inside paginateBox div
                //     reloadPagination();
                $('#lniata-table').show();
                ta_id = $('#ta_id').val();
                pcc = $('#pcc').val();

                if (ta_id !== '' && pcc !== '') {
                    //removing pagination and re adding it inside paginateBox div
                    reloadPagination();
                    //checks if selected value length is greater then 0. if not 0 then table won't show / load
                    if (ta_id.length > 0) {
                        // param is sent as fetch_data(default page id , travelagency id, pcc, )
                        fetch_data(1, ta_id, pcc);
                    }
                } else if (ta_id !== '' && pcc === '') {
                    //removing pagination and re adding it inside paginateBox div
                    reloadPagination();
                    //get the value of selected item from dropdown and store it

                    //checks if selected value length is greater then 0. if not 0 then table won't show / load
                    if (ta_id.length > 0) {
                        // param is sent as fetch_data(default page id , travelagency id, pcc, )
                        fetch_data(1, ta_id, pcc);
                    }
                } else {
                    $('#message').html('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n                All field are required to search\n            </div>');
                    hideErrorMessage();
                }
            });

            function reloadPagination() {
                $('#pagination').remove();
                $('#paginateBox').html("<div id='pagination' class='mt-2'></div>");
            }

            function fetch_data(pageid, ta_id, pcc) {
                $.ajax({
                    url: "lniata/fetch_data/?page=" + pageid,
                    method: "GET",
                    data: {
                        'ta_id': ta_id,
                        'pcc': pcc,
                    },
                    dataType: "json",
                    success: function (data) {
                        //data includes last_page which has total pages
                        var last_page = data['last_page'];
                        // console.log('current_page=' + data['current_page'] + ' remark=' + data['remark'] + ' last_page=' + data['last_page']);
                        data = data.data;
                        var html = '';
                        for (var count = data.length - 1; count >= 0; count--) {
                            html += '<tr>';
                            // html += '<td contenteditable class="column_name" data-column_name="ta_id" data-id="' + data[count].id + '">' + data[count].ta_id + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="pcc" data-id="' + data[count].id + '">' + data[count].pcc + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="lniata" data-id="' + data[count].id + '">' + data[count].lniata + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="user" data-id="' + data[count].id + '">' + data[count].user + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="remark" data-id="' + data[count].id + '">' + data[count].remark + '</td>';
                            html += '<td><a data-id="' + data[count].id + '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> <button type="button" class="btn btn-danger btn-xs delete" id="' + data[count].id + '"><i class="fas fa-trash-alt"></i></button></td></tr>';
                        }
                        if (ta_id !='' && pcc !==''){
                            html += '<tr>';
                            // html += '<td id="ta_id"></td>';
                            html += '<td contenteditable id="pcc" class="pcc"></td>';
                            html += '<td contenteditable id="lniata"></td>';
                            html += '<td contenteditable id="user"></td>';
                            html += '<td contenteditable id="remark"></td>';
                            html += '<td><button type="button" class="btn btn-success btn-xs" id="add">Add</button></td></tr>';
                        }
                        $('tbody').html(html);
                        if (pcc !== '') {
                            $('.pcc').text(pcc);
                            $('.pcc').attr('contenteditable', 'false');
                        }
                        // console.log('last page:' + last_page);

                        //using twitter bootstrap plugin

                        $('#pagination').twbsPagination({
                            totalPages: last_page,
                            visiblePages: 7,
                            initiateStartPageClick: false,
                            onPageClick: function (event, page) {
                                ta_id = $('.select2').val();
                                fetch_data(page, ta_id, pcc);
                            }
                        });
                    }
                });
            }

            var _token = $('input[name="_token"]').val();

            $(document).on('click', '#add', function () {
                var ta_id = $('.select2').val();
                var pcc = $('#pcc').val();
                var lniata = $('#lniata').text();
                var user = $('#user').text();
                var remark = $('#remark').text();
                if (ta_id != '' && pcc != '' && lniata != '' && user != '' && remark != '') {
                    $.ajax({
                        url: "{{ route('lniata.store') }}",
                        method: "POST",
                        data: {
                            ta_id: ta_id,
                            pcc: pcc,
                            lniata: lniata,
                            user: user,
                            remark: remark,
                            _token: _token
                        },
                        success: function (data) {
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
                            else
                                $('#message').html(data);
                            reloadPagination();
                            fetch_data(1, ta_id, pcc);
                            hideErrorMessage();
                        }
                    });
                } else {
                    $('#message').html("<div class=\"alert alert-danger\" role=\"alert\">\n" +
                        "        <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">\n" +
                        "            <span aria-hidden=\"true\">&times;</span>\n" +
                        "        </button>\n" +
                        "\tAll fields are requred user be filled\n" +
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
                        url: "{{ route('lniata.update') }}",
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
                if (confirm("Are you sure you want user delete this records?")) {
                    $.ajax({
                        url: "{{ route('lniata.delete_data') }}",
                        method: "POST",
                        data: {id: id, _token: _token},
                        success: function (data) {
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
                            else
                                $('#message').html(data);
                            hideErrorMessage();
                            reloadPagination();
                            fetch_data(1, ta_id, pcc);
                        }
                    });
                }
            });


        });

        $('#lniata-table').on('click', 'a#openShow', function (e) {
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
                url: 'lniata/showed/' + id,
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
            var ta_id = $('#ta_id').val();
            var pcc = $('#pcc').val();
            if (ta_id !== '' && pcc !== '') {
                var id = $('#ta_id').val();
                var pcc = $('#pcc').val();
                $.ajax({
                    url: 'lniata/printLniata/' + id,
                    method: 'GET',
                    data: {
                        'pcc': pcc
                    },
                    success: function (data) {
                        printPages(data);
                    }
                });
            } else if (ta_id !== '' && pcc == '') {
                var id = $('#ta_id').val();
                var pcc = $('#pcc').val();
                $.ajax({
                    url: 'lniata/printLniata/' + id,
                    method: 'GET',
                    data: {
                        'pcc': pcc
                    },
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
