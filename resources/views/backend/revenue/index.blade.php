@extends('backend.layouts.app')
@section('content')
    <div class="card-body">
        <div class="panel-heading mdl-color-text--red">Revenue</div>
        <a href="#" id="printDoc"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2 mr-2"><b><i
                    class="icon-printer2"></i></b> Print Revenue</a>
        <a href="#" id="excelExport"
           class="btn btn-success btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2 mr-2"><b><i
                    class="icon-download "></i></b> Export as Excel</a>
        {!! Form::open(['method'=>'POST','route'=>['revenue.uploadExcel'],'class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data']) !!}
        <div class="row ">
            {!!Form::label('revenue','Upload Revenue Excel',['class'=>'col-form-label col-lg-2 require']) !!}

            <div class="form-group row col-lg-5 ">
                {{Form::file('revenue', ['class' =>' form-control','required'=>'required'])}}
                {{ Form::button('Upload <i class="icon-paperplane ml-2"></i>', ['type' => 'submit', 'class' => 'btn btn-primary legitRipple'] )  }}
            </div>

        </div>
        <div class="row">
            {!!Form::label('ta_id','Travel Agency ID',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-10">
                {!! Form::select('ta_id',$ta_id,$value=null,['id'=>'ta_id','class'=>"form-control select2",'placeholder'=>'']) !!}
            </div>
            {!!Form::label('date','Enter Date Range',['class'=>'col-form-label col-lg-2 require']) !!}
            <div class="col-lg-5">
                {!! Form::text('date',$value=null,['class'=>"form-control datepicker-here date",'data-min-view'=>'months','data-view'=>'months','data-date-format'=>'yyyy-mm','data-range'=>'true','data-multiple-dates-separator'=>' - ','data-language'=>'en','placeholder'=>'']) !!}
            </div>
            {{ Form::button('Search <i class="icon-search4 ml-2"></i>', ['id'=>'search', 'class' => 'btn btn-primary legitRipple'] )  }}

        </div>
        {!! Form::close() !!}
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="message"></div>
                <div class="table-responsive">
                    <table id="revenue-table" class="table table-striped table-bordered mdl-data-table mt-2">
                        <thead>
                        <tr>
                            {{--<th>TravelAgency ID</th>--}}
                            <th>Month</th>
                            <th>Year</th>
                            <th>PCC</th>
                            <th>Travel ID</th>
                            {{--<th>FIT</th>--}}
                            {{--<th>GIT</th>--}}
                            <th>FIT calculation</th>
                            <th>GIT Calculation</th>
                            <th>Incentives</th>
                            <th>VolumeShare</th>
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
                        <h5 class="modal-title" id="myModalTitle">Revenue</h5>
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

            //used to store the selected travelagency id from dropdown (its set as a global variable)
            var current_page = null;
            //show data on page load
            fetch_data(1);

            $(".select2").select2({
                placeholder: "Select anyone",
                theme: 'modern',
                allowClear: true,
                minimumInputLength: 2
            });

            //search button event listener
            $('#search').click(function () {
                console.log('from: '+$('.date').val().split(' - ')[0]+' to: '+$('.date').val().split(' - ')[1])
                reloadPagination()
                search();
            })

            function search(page){
                ta_id = $('#ta_id').val();
                let from = $('.date').val().split(' - ')[0];
                let to = $('.date').val().split(' - ')[1]

                $.ajax({
                    url: "revenue/search/?page="+page,
                    method: "get",
                    data: {
                        ta_id: ta_id,
                        from: from,
                        to: to,
                        _token: _token
                    },
                    success: function (data) {
                        // reloadPagination();
                        console.log(data.data);
                        let last_page = data.data['last_page'];

                        data = data.data.data;
                        drawTable(data);
                        $('#pagination').twbsPagination({
                            totalPages: last_page,
                            visiblePages: 7,
                            initiateStartPageClick: false,
                            onPageClick: function (event, page) {
                                search(page);
                            }
                        });
                    }
                });
            }

            function reloadPagination() {
                $('#pagination').remove();
                $('#paginateBox').html("<div id='pagination' class='mt-2'></div>");
            }

            function fetch_data(pageid) {
                $.ajax({
                    url: "revenue/fetch_data/?page=" + pageid,
                    method: "GET",
                    dataType: "json",
                    success: function (data) {
                        //data includes last_page which has total pages
                        var last_page = data['last_page'];
                        // console.log('current_page=' + data['current_page'] + ' from=' + data['from'] + ' last_page=' + data['last_page']);
                        data = data.data;
                        //draws table
                        drawTable(data);
                        // $('#ta_id').text(ta_id);
                        // console.log('last page:' + last_page);

                        //using twitter bootstrap plugin

                        $('#pagination').twbsPagination({
                            totalPages: last_page,
                            visiblePages: 7,
                            initiateStartPageClick: false,
                            onPageClick: function (event, page) {
                                fetch_data(page);
                            }
                        });
                    }
                });
            }

            function drawTable(data){
                var html = '';
                for (var count = data.length - 1; count >= 0; count--) {
                    html += '<tr>';
                    // html += '<td contenteditable class="column_name" data-column_name="ta_id" data-id="' + data[count].id + '">' + data[count].ta_id + '</td>';
                    html += '<td contenteditable class="column_name" data-column_name="month" data-id="' + data[count].id + '">' + data[count].month + '</td>';
                    html += '<td contenteditable class="column_name" data-column_name="year" data-id="' + data[count].id + '">' + data[count].year + '</td>';
                    html += '<td contenteditable class="column_name" data-column_name="pcc" data-id="' + data[count].id + '">' + data[count].pcc + '</td>';
                    html += '<td contenteditable class="column_name" data-column_name="ta_id" data-id="' + data[count].id + '">' + data[count].ta_id + '</td>';
                    // html += '<td contenteditable class="column_name" data-column_name="fit" data-id="' + data[count].id + '">' + data[count].fit + '</td>';
                    // html += '<td contenteditable class="column_name" data-column_name="git" data-id="' + data[count].id + '">' + data[count].git + '</td>';
                    html += '<td contenteditable class="column_name" data-column_name="fit_calc" data-id="' + data[count].id + '">' + data[count].fit_calc + '</td>';
                    html += '<td contenteditable class="column_name" data-column_name="git_calc" data-id="' + data[count].id + '">' + data[count].git_calc + '</td>';
                    html += '<td contenteditable class="column_name" data-column_name="incentives" data-id="' + data[count].id + '">' + data[count].incentives + '</td>';
                    html += '<td contenteditable class="column_name" data-column_name="marketsharecommitment" data-id="' + data[count].id + '">' + data[count].marketsharecommitment + '</td>';
                    html += '<td contenteditable class="column_name" data-column_name="accountmanager" data-id="' + data[count].id + '">' + data[count].accountmanager + '</td>';
                    html += '<td><a data-id="'+data[count].id+'" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> <button type="button" class="btn btn-danger btn-xs delete" id="' + data[count].id + '"><i class="fas fa-trash-alt"></i></button></td></tr>';
                }
                html += '<tr>';
                // html += '<td id="ta_id"></td>';
                html += '<td contenteditable id="month"></td>';
                html += '<td contenteditable id="year"></td>';
                html += '<td contenteditable id="pcc"></td>';
                html += '<td contenteditable id="tid"></td>';
                // html += '<td contenteditable id="fit"></td>';
                // html += '<td contenteditable id="git"></td>';
                html += '<td contenteditable id="fit_calc"></td>';
                html += '<td contenteditable id="git_calc"></td>';
                html += '<td contenteditable id="incentives"></td>';
                html += '<td contenteditable id="marketsharecommitment"></td>';
                html += '<td contenteditable id="accountmanager"></td>';
                html += '<td><button type="button" class="btn btn-success btn-xs" id="add">Add</button></td></tr>';
                $('tbody').html(html);
            }

            var _token = $('input[name="_token"]').val();

            $(document).on('click', '#add', function () {
                var month = $('#month').text();
                var year = $('#year').text();
                var pcc = $('#pcc').text();
                var ta_id = $('#tid').text();
                // var fit = $('#fit').text();
                // var git = $('#git').text();
                var fit_calc = $('#fit_calc').text();
                var git_calc = $('#git_calc').text();
                var incentives = $('#incentives').text();
                var marketsharecommitment = $('#marketsharecommitment').text();
                var accountmanager = $('#accountmanager').text();
                if (ta_id != '' && month != '' && pcc != '' && ta_id != '' && fit_calc != '' && git_calc != '' && incentives != '' && marketsharecommitment != '' && accountmanager != '' ) {
                    $.ajax({
                        url: "{{ route('revenue.store') }}",
                        method: "POST",
                        data: {
                            month: month,
                            year: year,
                            pcc: pcc,
                            ta_id: ta_id,
                            // fit: fit,
                            // git: git,
                            fit_calc: fit_calc,
                            git_calc: git_calc,
                            incentives: incentives,
                            marketsharecommitment: marketsharecommitment,
                            accountmanager: accountmanager,
                            _token: _token
                        },
                        success: function (data) {
                            if (data.indexOf("You do not have permission to do that.") >= 0)
                                alert('You do not have permission to do that.');
                            else
                                $('#message').html(data);
                            reloadPagination();
                            fetch_data(1);
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
                        url: "{{ route('revenue.update') }}",
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
                        url: "{{ route('revenue.delete_data') }}",
                        method: "POST",
                        data: {id: id, _token: _token},
                        success: function (data) {
                            if (data.indexOf("You do not have permission to do that.") >= 0)
                                alert('You do not have permission to do that.');
                            else
                                $('#message').html(data);
                            hideErrorMessage();
                            reloadPagination();
                            fetch_data(1);
                        }
                    });
                }
            });
        });
        $('#revenue-table').on('click', 'a#openShow', function (e) {
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
                url: 'revenue/show/' + id,
                method: 'GET',
                success: function (data) {
                    $('#showRemoteData').html(data);

                    $("#showRemoteData").waitMe("hide");

                }
            });
        })

        //Print Document
        $('#printDoc').on('click', function () {
            ta_id = $('#ta_id').val();
            let from = $('.date').val().split(' - ')[0];
            let to = $('.date').val().split(' - ')[1]
            console.log('from:'+from+' to:'+to);
            $.ajax({
                url: '{{route('revenue.print')}}',
                method: 'GET',
                data:{
                    ta_id:ta_id,
                    from:from,
                    to:to,
                },
                success: function (data) {
                    printPages(data);
                }
            });
        });

        $('#excelExport').on('click', function () {
            ta_id = $('#ta_id').val();
            let from = $('.date').val().split(' - ')[0];
            let to = $('.date').val().split(' - ')[1]
            console.log('from:'+from+' to:'+to);
            var query = {
                ta_id:ta_id,
                from:from,
                to:to,
            }
            var url = "{{route('revenue.exportexcel')}}?" + $.param(query)
            window.location = url;
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
