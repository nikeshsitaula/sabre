@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <div id="message"></div>
        <a href="#" id="printDoc"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2 mr-2"><b><i
                    class="icon-printer2"></i></b> Export Product Cost Entry</a>
        <div class="panel-heading mdl-color-text--red">ProductCostEntry</div>

        <div class="row">
            {!!Form::label('agreementnumber','Agreement Number',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">
                {!! Form::select('agreementnumber',$agreementnumber,$value=null,['id'=>'agreementnumber','class'=>"form-control select2 ta",'placeholder'=>'']) !!}
            </div>
            {!!Form::label('ta_id','Travel ID',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">
                {!! Form::select('ta_id',['null'=>'null'],$value=null,['id'=>'ta_id','class'=>"form-control select2 ",'placeholder'=>'']) !!}
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
        <div class="row">
        </div>
        <div class="float-right mt-2">
            <button class="search btn btn-primary" style="padding-top: 5px;">Search</button>
        </div>
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="table-responsive">
                    <table id="productcostentry-table" class="table table-striped table-bordered mdl-data-table mt-2">
                        <thead>
                        <tr>
                            {{--<th>Agreement Number</th>--}}
                            <th>Travel ID</th>
                            <th>Cost</th>
                            <th>Payment</th>
                            <th>Date(YYYY-MM-DD)</th>
                            <th>Balance</th>
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
                        <h5 class="modal-title" id="myModalTitle">Product Cost Entry</h5>
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
            $('#productcostentry-table').hide();
            // used to store the selected travelagency id from dropdown (its set as a global variable)
            var agreementnumber = null;
            var ta_id = null;
            var from = null;
            var to = null;
            var current_page = null;
            $(".select2").select2({
                placeholder: "Select anyone",
                theme: 'modern',
                allowClear: true,
                minimumInputLength: 2
            });

            $("#ta_id").select2({
                placeholder: "Select anyone",
                theme: 'modern',
                allowClear: true,
                ajax: {
                    url: 'productscostentry/filterTravelDropdown',
                    dataType: 'json',
                    type: "GET",
                    quietMillis: 50,
                    data: function (name) {
                        return {
                            value: name.term,
                            agreementnumber: $('#agreementnumber').val(),
                            page: name.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    text: 'Travel ID:' + item.ta_id+'~'+' Travel Agency:'+item.travelname,
                                    id: item.ta_id,
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

            $('#agreementnumber').change(function (e) {
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

            $(".search").click(function (e) {
                e.preventDefault();
                //     $('#productcostentry-table').show();
                //     //removing pagination and re adding it inside paginateBox div
                //     reloadPagination();
                $('#productcostentry-table').show();
                agreementnumber = $('#agreementnumber').val();
                ta_id = $('#ta_id').val();
                from = $('#dateFrom').val();
                to = $('#dateTo').val();
                if (agreementnumber !== '' && ta_id !== '' && from === '' && to === '') {
                    //removing pagination and re adding it inside paginateBox div
                    reloadPagination();
                    //checks if selected value length is greater then 0. if not 0 then table won't show / load
                    if (agreementnumber.length > 0) {
                        // param is sent as fetch_data(default page id , travelagency id, ta_id, )
                        fetch_data(1, agreementnumber, ta_id, from, to);
                    }
                } else if (agreementnumber !== '' && ta_id === '' && from === '' && to === '') {
                    //removing pagination and re adding it inside paginateBox div
                    reloadPagination();
                    //get the value of selected item from dropdown and store it

                    //checks if selected value length is greater then 0. if not 0 then table won't show / load
                    if (agreementnumber.length > 0) {
                        // param is sent as fetch_data(default page id , travelagency id, ta_id, )
                        fetch_data(1, agreementnumber, ta_id, from, to);
                    }
                } else if (agreementnumber === '' && ta_id === '' && from !== '' && to !== '') {
                    //removing pagination and re adding it inside paginateBox div
                    reloadPagination();
                    //get the value of selected item from dropdown and store it

                    //checks if selected value length is greater then 0. if not 0 then table won't show / load
                    if (from.length > 0 && to.length>0) {
                        // param is sent as fetch_data(default page id , travelagency id, ta_id, )
                        fetch_data(1, agreementnumber, ta_id, from, to);
                    }
                } else if (agreementnumber !== '' && ta_id === '' && from !== '' && to !== '') {
                    //removing pagination and re adding it inside paginateBox div
                    reloadPagination();
                    //get the value of selected item from dropdown and store it

                    //checks if selected value length is greater then 0. if not 0 then table won't show / load
                    if (agreementnumber.length > 0) {
                        // param is sent as fetch_data(default page id , travelagency id, ta_id, )
                        fetch_data(1, agreementnumber, ta_id, from, to);
                    }
                } else if (agreementnumber !== '' && ta_id !== '' && from !== '' && to !== '') {
                    //removing pagination and re adding it inside paginateBox div
                    reloadPagination();
                    //get the value of selected item from dropdown and store it

                    //checks if selected value length is greater then 0. if not 0 then table won't show / load
                    if (agreementnumber.length > 0) {
                        // param is sent as fetch_data(default page id , travelagency id, ta_id, )
                        fetch_data(1, agreementnumber, ta_id, from, to);
                    }
                }
                else if (agreementnumber === '' && ta_id === '' && from === '' && to === '') {
                    reloadPagination();
                    // if (from.length === 0 && to.length===0) {
                    fetch_data(1, agreementnumber, ta_id, from, to);
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

            function fetch_data(pageid, agreementnumber, ta_id, from, to) {
                // console.log('inside fetch data====agreement number:' + agreementnumber + ' ta_id:' + ta_id )

                $.ajax({
                    url: "productscostentry/fetch_data/?page=" + pageid,
                    method: "GET",
                    data: {
                        'agreementnumber': agreementnumber,
                        'ta_id': ta_id,
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
                            // html += '<td contenteditable class="column_name" data-column_name="agreementnumber" data-id="' + data[count].id + '">' + data[count].agreementnumber + '</td>';
                            html += '<td class="column_name" data-column_name="ta_id" data-id="' + data[count].id + '">' + data[count].ta_id + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="cost" data-id="' + data[count].id + '">' + data[count].cost + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="payment" data-id="' + data[count].id + '">' + data[count].payment + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="date" data-id="' + data[count].id + '">' + data[count].date + '</td>';
                            html += '<td contenteditable class="column_name" data-column_name="balance" data-id="' + data[count].id + '">' + data[count].balance + '</td>';
                            html += '<td><a data-id="' + data[count].id + '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> <button type="button" class="btn btn-danger btn-xs delete" id="' + data[count].id + '"><i class="fas fa-trash-alt"></i></button></td></tr>';
                        }
                        if (agreementnumber !== '' && ta_id !== '') {
                            html += '<tr>';
                            // html += '<td id="agreementnumber"></td>';
                            html += '<td id="ta_id" class="ta_id"></td>';
                            html += '<td contenteditable id="cost"></td>';
                            html += '<td contenteditable id="payment"></td>';
                            html += '<td contenteditable id="date"></td>';
                            html += '<td contenteditable id="balance"></td>';
                            html += '<td><button type="button" class="btn btn-success btn-xs" id="add">Add</button></td></tr>';
                        }
                        $('tbody').html(html);
                        if (ta_id !== '') {
                            $('.ta_id').text(ta_id);
                            $('.ta_id').attr('contenteditable', 'false');
                        }
                        // $('#agreementnumber').text(agreementnumber);
                        // console.log('last page:' + last_page);

                        //using twitter bootstrap plugin

                        $('#pagination').twbsPagination({
                            totalPages: last_page,
                            visiblePages: 7,
                            initiateStartPageClick: false,
                            onPageClick: function (event, page) {
                                agreementnumber = $('.select2').val();
                                fetch_data(page, agreementnumber, ta_id, from, to);
                            }
                        });
                    }
                });
            }

            var _token = $('input[name="_token"]').val();

            $(document).on('click', '#add', function () {
                var agreementnumber = $('.select2').val();
                var ta_id = $('#ta_id').val();
                var cost = $('#cost').text();
                var payment = $('#payment').text();
                var date = $('#date').text();
                var balance = $('#balance').text();
                if (agreementnumber != '' && ta_id != '' && cost != '' && payment != '' && date != '') {
                    $.ajax({
                        url: "{{ route('productscostentry.store') }}",
                        method: "POST",
                        data: {
                            agreementnumber: agreementnumber,
                            ta_id: ta_id,
                            cost: cost,
                            payment: payment,
                            date: date,
                            // balance: balance,
                            _token: _token
                        },
                        success: function (data) {
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
                            else
                                $('#message').html(data);
                            reloadPagination();
                            fetch_data(1, agreementnumber, ta_id);
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
                        url: "{{ route('productscostentry.update') }}",
                        method: "POST",
                        data: {column_name: column_name, column_value: column_value, id: id, _token: _token},
                        success: function (data) {
                            hideErrorMessage();
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
                            else
                                $('#message').html(data);
                            hideErrorMessage();
                            reloadPagination();
                            fetch_data(1, agreementnumber, ta_id);
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
                        url: "{{ route('productscostentry.delete_data') }}",
                        method: "POST",
                        data: {id: id, _token: _token},
                        success: function (data) {
                            if (data.indexOf("You do not have access to do that.") >= 0)
                                alert('You do not have access to do that.');
                            else
                                $('#message').html(data);
                            hideErrorMessage();
                            reloadPagination();
                            fetch_data(1, agreementnumber, ta_id);
                        }
                    });
                }
            });


        });

        $('#productcostentry-table').on('click', 'a#openShow', function (e) {
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
                url: 'productscostentry/showed/' + id,
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
            var agreementnumber = $('#agreementnumber').val();
            var ta_id = $('#ta_id').val();
            var from = $('#dateFrom').val();
            var to = $('#dateTo').val();
            if (agreementnumber !== '' && ta_id !== '' && from === '' && to === '') {
                $.ajax({
                    url: 'productscostentry/printproductscostentry/' + agreementnumber,
                    method: 'GET',
                    data: {
                        'ta_id': ta_id
                    },
                    success: function (data) {
                        printPages(data);
                    }
                });
            } else if (agreementnumber !== '' && ta_id === '' && from === '' && to === '') {
                $.ajax({
                    url: 'productscostentry/printproductscostentry/' + agreementnumber,
                    method: 'GET',
                    data: {
                        'ta_id': ta_id
                    },
                    success: function (data) {
                        printPages(data);
                    }
                });
            } else if (agreementnumber === '' && ta_id === '' && from !== '' && to !== '') {
                agreementnumber=0;
                $.ajax({
                    url: 'productscostentry/printproductscostentry/' + agreementnumber,
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
            else if (!agreementnumber !== '' && ta_id === '' && from !== '' && to !== '') {
                $.ajax({
                    url: 'productscostentry/printproductscostentry/' + agreementnumber,
                    method: 'GET',
                    data: {
                        'agreementnumber':agreementnumber,
                        'from': from,
                        'to':to
                    },
                    success: function (data) {
                        printPages(data);
                    }
                });
            }
            else if (!agreementnumber !== '' && ta_id !== '' && from !== '' && to !== '') {
                $.ajax({
                    url: 'productscostentry/printproductscostentry/' + agreementnumber,
                    method: 'GET',
                    data: {
                        'agreementnumber':agreementnumber,
                        'ta_id':ta_id,
                        'from': from,
                        'to':to
                    },
                    success: function (data) {
                        printPages(data);
                    }
                });
            }
            else if (agreementnumber === '' && ta_id === '' && from === '' && to === '') {
                agreementnumber=0;
                $.ajax({
                    url: 'productscostentry/printproductscostentry/' + agreementnumber,
                    method: 'GET',
                    data: {
                    },
                    success: function (data) {
                        printPages(data);
                    }
                });
            }
            else {
                alert('please select a agreement number first');
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
