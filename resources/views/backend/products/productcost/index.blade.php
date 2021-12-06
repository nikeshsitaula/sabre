@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <a href="#" id="printDoc"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2 mr-2"><b><i
                    class="icon-printer2"></i></b> Export Product Cost</a>
        <div class="panel-heading mdl-color-text--red">Product Cost Details</div>

        <div class="row">
            {!!Form::label('p_id','Product ID',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">
                {!! Form::select('p_id',$p_id,$value=null,['id'=>'p_id','class'=>"form-control select2 ta",'placeholder'=>'']) !!}
            </div>
            {!!Form::label('agreementnumber','Agreement Number',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">
                {!! Form::select('agreementnumber',['null'=>'null'],$value=null,['id'=>'agreementnumber','class'=>"form-control select2 ",'placeholder'=>'']) !!}
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
                    <table id="productcost-table" class="table table-striped table-bordered mdl-data-table mt-2">
                        <thead>
                        <tr>
                            {{--                            <th>product ID</th>--}}
                            <th>Agreement Number</th>
                            <th>Period</th>
                            <th>Entry Date(YYYY-MM-DD)</th>
                            <th>Total Cost</th>
                            <th>Total Payment</th>
                            <th>Balance</th>
                            <th>Travel ID</th>
                            <th>Account Manager</th>
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
            $('#productcost-table').hide();
            //used to store the selected product id from dropdown (its set as a global variable)
            var p_id = null;
            var agreementnumber = null;
            var from = null;
            var to = null;
            var current_page = null;
            $(".select2").select2({
                placeholder: "Select anyone",
                theme: 'modern',
                allowClear: true,
                minimumInputLength: 2
            });

            $("#agreementnumber").select2({
                placeholder: "Select anyone",
                theme: 'modern',
                allowClear: true,
                ajax: {
                    url: 'productscost/filterAgreementDropdown',
                    dataType: 'json',
                    type: "GET",
                    quietMillis: 50,
                    data: function (name) {
                        return {
                            value: name.term,
                            p_id: $('#p_id').val(),
                            page: name.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    text: 'Agreement Number:' + item.agreementnumber+ '  Travel Agency:'+item.ta_id+ '('+item.travelname+')',
                                    id: item.agreementnumber,
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


            $('.p_id').change(function (e) {
                $.ajax({
                    url: "productscostentry/checkTravel",
                    method: "GET",
                    data: {
                        'agreementnumber': $('#agreementnumber').val(),
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        if (data.status === false) {
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: data.message,
                            }).then((result) => {
                                location.reload();
                            });
                        }
                    }
                });
            });

            $('#p_id').change(function (e) {
                e.preventDefault();
                // $('#productcostentry-table').show();
                // //removing pagination and re adding it inside paginateBox div
                // reloadPagination();
                // //get the value of selected item from dropdown and store it
                // ta_id = $(this).val();
                // //checks if selected value length is greater then 0. if not 0 then table won't show / load
                // if (ta_id.length > 0) {
                //     // param is sent as fetch_data(default page id , travelagency id)
                //     fetch_data(1, agreementnumber,ta_id);
                // }
                $.ajax({
                    url: "productscost/checkAgreement",
                    method: "GET",
                    data: {
                        'p_id': $('#p_id').val(),
                    },
                    dataType: "json",
                    success: function (data) {
                        console.log(data);
                        if (data.status === false) {
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: data.message,
                            }).then((result) => {
                                location.reload();
                            });
                        }
                    }
                });
            });

            $(".search").click(function (e) {
                e.preventDefault();
                //     $('#productcostentry-table').show();
                //     //removing pagination and re adding it inside paginateBox div
                //     reloadPagination();
                $('#productcost-table').show();
                p_id = $('#p_id').val();
                agreementnumber = $('#agreementnumber').val();
                from = $('#dateFrom').val();
                to = $('#dateTo').val();
                if (p_id !== '' && agreementnumber !== '' && from === '' && to === '') {
                    //removing pagination and re adding it inside paginateBox div
                    reloadPagination();
                    //checks if selected value length is greater then 0. if not 0 then table won't show / load
                    if (p_id.length > 0) {
                        // param is sent as fetch_data(default page id , travelagency id, agreementnumber, )
                        fetch_data(1, p_id, agreementnumber, from, to);
                    }
                } else if (p_id !== '' && agreementnumber === '' && from === '' && to === '') {
                    //removing pagination and re adding it inside paginateBox div
                    reloadPagination();
                    //get the value of selected item from dropdown and store it

                    //checks if selected value length is greater then 0. if not 0 then table won't show / load
                    if (p_id.length > 0) {
                        // param is sent as fetch_data(default page id , travelagency id, agreementnumber, )
                        fetch_data(1, p_id, agreementnumber, from, to);
                    }
                } else if (p_id === '' && agreementnumber === '' && from !== '' && to !== '') {
                    //removing pagination and re adding it inside paginateBox div
                    reloadPagination();
                    //get the value of selected item from dropdown and store it

                    //checks if selected value length is greater then 0. if not 0 then table won't show / load
                    if (from.length > 0 && to.length>0) {
                        // param is sent as fetch_data(default page id , travelagency id, agreementnumber, )
                        fetch_data(1, p_id, agreementnumber, from, to);
                    }
                } else if (p_id !== '' && agreementnumber === '' && from !== '' && to !== '') {
                    //removing pagination and re adding it inside paginateBox div
                    reloadPagination();
                    //get the value of selected item from dropdown and store it

                    //checks if selected value length is greater then 0. if not 0 then table won't show / load
                    if (p_id.length > 0) {
                        // param is sent as fetch_data(default page id , travelagency id, agreementnumber, )
                        fetch_data(1, p_id, agreementnumber, from, to);
                    }
                } else if (p_id !== '' && agreementnumber !== '' && from !== '' && to !== '') {
                    //removing pagination and re adding it inside paginateBox div
                    reloadPagination();
                    //get the value of selected item from dropdown and store it

                    //checks if selected value length is greater then 0. if not 0 then table won't show / load
                    if (p_id.length > 0) {
                        // param is sent as fetch_data(default page id , travelagency id, agreementnumber, )
                        fetch_data(1, p_id, agreementnumber, from, to);
                    }
                }
                else if (p_id === '' && agreementnumber === '' && from === '' && to === '') {
                    reloadPagination();
                    // if (from.length === 0 && to.length===0) {
                    fetch_data(1, p_id, agreementnumber, from, to);
                    // }
                } else {
                    $('#message').html('<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>\n                All field are required to search\n            </div>');
                    hideErrorMessage();
                }
            });

            function reloadPagination() {
                $('#pagination').remove();
                $('#paginateBox').html("<div id='pagination' class='mt-2'></div>");
            }

            function fetch_data(pageid, p_id,agreementnumber, from, to) {
                $.ajax({
                    url: "productscost/fetch_data/?page=" + pageid,
                    method: "GET",
                    data: {
                        'p_id': p_id,
                        'agreementnumber': agreementnumber,
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
                            // html += '<td contenteditable class="column_name" data-column_name="p_id" data-id="' + data[count].id + '">' + data[count].p_id + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="agreementnumber" data-id="' + data[count].id + '">' + data[count].agreementnumber + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="period" data-id="' + data[count].id + '">' + data[count].period + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="entrydate" data-id="' + data[count].id + '">' + data[count].entrydate + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="cost" data-id="' + data[count].id + '">' + data[count].cost + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="received" data-id="' + data[count].id + '">' + data[count].received + '</td>';
                            html += '<td class="column_name" data-column_name="balance" data-id="' + data[count].id + '">' + data[count].balance + '</td>';
                            html += '<td  class="column_name" data-column_name="ta_id" data-id="' + data[count].id + '">' + data[count].ta_id + '</td>';
                            html += '<td class="column_name" data-column_name="accountmanager" data-id="' + data[count].id + '">' + data[count].accountmanager + '</td>';
                            html += '<td><a data-id="' + data[count].id + '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> <button type="button" class="btn btn-danger btn-xs delete" id="' + data[count].id + '"><i class="fas fa-trash-alt"></i></button></td></tr>';
                        }
                        if (p_id !== '' && agreementnumber !== '') {
                            html += '<tr>';
                            // html += '<td id="p_id"></td>';
                            html += '<td contenteditable id="agreementnumber"></td>';
                            html += '<td contenteditable id="period"></td>';
                            html += '<td contenteditable id="entrydate"></td>';
                            html += '<td contenteditable id="cost"></td>';
                            html += '<td contenteditable id="received"></td>';
                            html += '<td  id="balance"></td>';
                            html += '<td id="ta_id"></td>';
                            html += '<td  id="accountmanager"></td>';
                            html += '<td><button type="button" class="btn btn-success btn-xs" id="add">Add</button></td></tr>';
                        }
                        $('tbody').html(html);
                        if (agreementnumber !== '') {
                            $('.agreementnumber').text(agreementnumber);
                            $('.agreementnumber').attr('contenteditable', 'false');
                        }
                        // $('#p_id').text(p_id);
                        // console.log('last page:' + last_page);

                        //using twitter bootstrap plugin

                        $('#pagination').twbsPagination({
                            totalPages: last_page,
                            visiblePages: 7,
                            initiateStartPageClick: false,
                            onPageClick: function (event, page) {
                                p_id = $('.select2').val();
                                fetch_data(page, p_id, agreementnumber, from, to);
                            }
                        });
                    }
                });
            }

            var _token = $('input[name="_token"]').val();

            $(document).on('click', '#add', function () {
                var p_id = $('.select2').val();
                var agreementnumber = $('#agreementnumber').val();
                var period = $('#period').text();
                var entrydate = $('#entrydate').text();
                var cost = $('#cost').text();
                var received = $('#received').text();
                var balance = $('#balance').text();
                var ta_id = $('#ta_id').text();
                var accountmanager = $('#accountmanager').text();

                if (p_id != '' && agreementnumber != '' && period != '' && entrydate != '' && cost != '' && received != '') {
                    $.ajax({
                        url: "{{ route('productscost.store') }}",
                        method: "POST",
                        data: {
                            p_id: p_id,
                            agreementnumber: agreementnumber,
                            period: period,
                            entrydate: entrydate,
                            cost: cost,
                            received: received,
                            // balance: balance,
                            // ta_id: ta_id,
                            // accountmanager: accountmanager,
                            _token: _token
                        },
                        success: function (data) {
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
                            else
                                $('#message').html(data);
                            reloadPagination();
                            fetch_data(1, p_id,agreementnumber);
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
                        url: "{{ route('productscost.update') }}",
                        method: "POST",
                        data: {column_name: column_name, column_value: column_value, id: id, _token: _token},
                        success: function (data) {
                            hideErrorMessage();
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
                            else
                                $('#message').html(data);
                            hideErrorMessage();
                            fetch_data(1, p_id,agreementnumber);
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
                        url: "{{ route('productscost.delete_data') }}",
                        method: "POST",
                        data: {id: id, _token: _token},
                        success: function (data) {
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
                            else
                                $('#message').html(data);
                            hideErrorMessage();
                            reloadPagination();
                            fetch_data(1, p_id,agreementnumber);
                        }
                    });
                }
            });


        });
        $('#productcost-table').on('click', 'a#openShow', function (e) {
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
                url: 'productscost/showed/' + id,
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
            var p_id = $('#p_id').val();
            var agreementnumber = $('#agreementnumber').val();
            var from = $('#dateFrom').val();
            var to = $('#dateTo').val();
            if (p_id !== '' && agreementnumber !== '' && from === '' && to === '') {
                $.ajax({
                    url: 'productscost/printproductscost/' + p_id,
                    method: 'GET',
                    data: {
                        'p_id': p_id,
                        'agreementnumber': agreementnumber
                    },
                    success: function (data) {
                        printPages(data);
                    }
                });
            } else if (p_id !== '' && agreementnumber === '' && from === '' && to === '') {
                console.log('reach first here');
                $.ajax({
                    url: 'productscost/printproductscost/' + p_id,
                    method: 'GET',
                    data: {
                        'p_id': p_id
                    },
                    success: function (data) {
                        printPages(data);
                    }
                });
            } else if (p_id === '' && agreementnumber === '' && from !== '' && to !== '') {
                p_id=0;
                $.ajax({
                    url: 'productscost/printproductscost/' + p_id,
                    method: 'GET',
                    data: {
                        'from': from,
                        'to':to
                    },
                    success: function (data) {
                        printPages(data);
                    }
                });
            }
            else if (p_id !== '' && agreementnumber === '' && from !== '' && to !== '') {
                $.ajax({
                    url: 'productscost/printproductscost/' + p_id,
                    method: 'GET',
                    data: {
                        'p_id':p_id,
                        'from': from,
                        'to':to
                    },
                    success: function (data) {
                        printPages(data);
                    }
                });
            }
            else if (p_id !== '' && agreementnumber !== '' && from !== '' && to !== '') {
                $.ajax({
                    url: 'productscost/printproductscost/' + p_id,
                    method: 'GET',
                    data: {
                        'p_id':p_id,
                        'agreementnumber':agreementnumber,
                        'from': from,
                        'to':to
                    },
                    success: function (data) {
                        printPages(data);
                    }
                });
            }
            else if (p_id === '' && agreementnumber === '' && from === '' && to === '') {
                p_id=0;
                $.ajax({
                    url: 'productscost/printproductscost/' + p_id,
                    method: 'GET',
                    data: {
                    },
                    success: function (data) {
                        printPages(data);
                    }
                });
            }
            else {
                alert('please select a Product ID first');
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
