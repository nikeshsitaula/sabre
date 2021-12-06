@extends('backend.layouts.app')
@section('content')
    <div class="content">

        <a href="{{route('airlines.create')}}"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right "><b><i
                    class="icon-people"></i></b> Add Airlines</a>

        <table class="mdl-data-table table-responsive table-striped table-hover airlines-table" id="airlines-table" >
            <thead>
            <tr>
                <th>Airlines ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Numeric IATA</th>
                <th>Alphanumeric IATA</th>
                <th>Phone No</th>
                <th>FAX No</th>
                <th>Email</th>
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
                    <h5 class="modal-title" id="myModalTitle">Airlines</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-lg" id="showRemoteData" style="height:100%">

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
            var t = $('.airlines-table').DataTable({
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                ajax: '{!! route('list.airlines') !!}',
                columns: [
                    {data: 'ai_id', name: 'ai_id'},
                    {data: 'name', name: 'ta_name'},
                    {data: 'address', name: 'ta_address'},
                    {data: 'numericiata', name: 'numericiata'},
                    {data: 'alphanumericiata', name: 'alphanumericiata'},
                    {data: 'phone', name: 'ta_phone'},
                    {data: 'fax', name: 'fax'},
                    {data: 'email', name: 'email'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'action', name: 'action'},
                ],
                "columnDefs": [
                    {
                        "targets": [ 8 ],
                        "visible": false,
                        "searchable": false
                    }],
                "order": [[ 8, "desc" ]],
                buttons: [
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4, 5, 6,7 ] //Your Colume value those you want
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ] //Your Colume value those you want
                        }
                    },
                ],
                "lengthMenu": [10]  //total rows to show in a table

                // "searching": false

            });

            $('#airlines-table').on('click', 'a#openShow', function (e) {
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
                    url: 'airlines/show/' + id,
                    method: 'GET',
                    success: function (data) {

                        console.log(data);

                        $('#showRemoteData').html(data);

                        $("#showRemoteData").waitMe("hide");

                    }
                });
            })

        });


    </script>


@endpush
