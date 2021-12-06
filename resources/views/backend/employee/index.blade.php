@extends('backend.layouts.app')
@section('content')
    <div class="content">

        <a href="{{route('employee.create')}}"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right "><b><i
                    class="icon-people"></i></b> Add Employee</a>
        {{--<a href="{{route('employee.downloadExcel')}}"--}}
           {{--class="btn btn-success btn-labeled btn-labeled-left btn-lg legitRipple float-right mr-1 "><b><i--}}
                    {{--class="icon-download "></i></b> Export as Excel</a>--}}
        {{--<div>--}}
        {{--<button type="button" id="add" class="btn btn-primary">Add</button>--}}
        {{--</div>--}}
        <table class="mdl-data-table table-responsive table-striped table-hover employee-table" id="employee-table" >
            <thead>
            <tr>
                <th>Emp No</th>
                <th>Name</th>
                <th>Position</th>
                <th>Level</th>
                <th>Address</th>
                <th>Mobile</th>
                <th>Res Phone </th>
                <th>DOB</th>
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
                    <h5 class="modal-title" id="myModalTitle">Employee</h5>
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
            var t = $('.employee-table').DataTable({
                dom: 'Bfrtip',
                processing: true,
                serverSide: true,
                ajax: '{!! route('list.employee') !!}',
                columns: [
                    {data: 'emp_no', name: 'emp_no'},
                    {data: 'name', name: 'name'},
                    {data: 'position', name: 'position'},
                    {data: 'level', name: 'level'},
                    {data: 'address', name: 'address'},
                    {data: 'mobile', name: 'mobile'},
                    {data: 'res_phone', name: 'res_phone'},
                    {data: 'dob', name: 'dob'},
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
                            columns: [1, 2, 3, 4, 5, 6, 7 ] //Your Colume value those you want
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: [ 1, 2, 3, 4, 5, 6, 7 ] //Your Colume value those you want
                        }
                    },
                ],
                "lengthMenu": [10]  //total rows to show in a table

                // "searching": false

            });

            $('#employee-table').on('click', 'a#openShow', function (e) {
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
                    url: 'employee/show/' + id,
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
