@extends('backend.layouts.app')
@section('content')
    <div class="content">

        <a href="{{route('sales.create')}}"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right "><b><i
                    class="icon-people"></i></b> Add SMA</a>

        <br/>
        <div class="row input-daterange">
            <div class="col-md-4">
                <label for="from_date"></label><input type="text" name="from_date" id="from_date" class="form-control"
                                                      placeholder="From Date"/>
            </div>
            <div class="col-md-4">
                <label for="to_date"></label><input type="text" name="to_date" id="to_date" class="form-control"
                                                    placeholder="To Date"/>
            </div>
            <div class="col-md-4">
                <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
            </div>
        </div>
        <br/>

        <table class="mdl-data-table table-responsive table-striped table-hover sales-table" id="sales-table">
            <thead>
            <tr>
                <th>SMA ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Estimated Cost</th>
                <th>Actual Cost</th>
                <th>From</th>
                <th>To</th>
                <th>Created At</th>
                <th id="notexport">Action</th>
            </tr>
            </thead>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="showData" tabindex="-1" role="dialog" aria-labelledby="showData" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalTitle">SMA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-lg" id="showRemoteData" style="height:500px">

                </div>
                <div class="modal-footer mt-3">
                    <button type="button" class="btn btn-secondary mt-5" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function () {

            $(document).ready(function () {
                // $('.input-daterange').datepicker({
                //     todayBtn:'linked',
                //     format:'yyyy-mm-dd',
                //     autoclose:true
                // });

                load_data();

                function load_data(from_date = '', to_date = '') {
                    var t = $('.sales-table').DataTable({
                        dom: 'Bfrtip',
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ route("sales.daterange") }}',
                            data: {from_date: from_date, to_date: to_date}
                        },
                        columns: [
                            {data: 'sma_id', name: 'sma_id'},
                            {data: 'name', name: 'name'},
                            {data: 'description', name: 'description'},
                            {data: 'estimatedcost', name: 'estimatedcost'},
                            {data: 'actualcost', name: 'actualcost'},
                            {data: 'from', name: 'from'},
                            {data: 'to', name: 'to'},
                            {data: 'created_at', name: 'created_at'},
                            {data: 'action', name: 'action'},
                        ],
                        "columnDefs": [
                            {
                                "targets": [7],
                                "visible": false,
                                "searchable": false
                            }],
                        "order": [[7, "desc"]],
                        buttons: [
                            {
                                extend: 'print',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6] //Your Colume value those you want
                                }
                            },
                            {
                                extend: 'excel',
                                exportOptions: {
                                    columns: [0, 1, 2, 3, 4, 5, 6] //Your Colume value those you want
                                }
                            },
                        ],
                        "lengthMenu": [10]  //total rows to show in a table

                        // "searching": false

                    });
                }

                $('#filter').click(function () {
                    var from_date = $('#from_date').val();
                    var to_date = $('#to_date').val();
                    if (from_date != '' && to_date != '') {
                        $('.sales-table').DataTable().destroy();
                        load_data(from_date, to_date);
                    } else {
                        alert('Both Date is required');
                    }
                });

                $('#refresh').click(function () {
                    $('#from_date').val('');
                    $('#to_date').val('');
                    $('.sales-table').DataTable().destroy();
                    load_data();
                });

            });

        });

        $('#sales-table').on('click', 'a#openShow', function (e) {
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
                url: 'sales/show/' + id,
                method: 'GET',
                success: function (data) {

                    console.log(data);

                    $('#showRemoteData').html(data);

                    $("#showRemoteData").waitMe("hide");

                }
            });
        })


    </script>


@endpush
