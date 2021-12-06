@extends('backend.layouts.app')
@section('content')
    <div class="content">

        <a href="{{route('career.create')}}" class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right "><b><i class="icon-user-tie"></i></b> Add Career</a>
        <table class="mdl-data-table mt-2" id="career-table" style="width: 1000px;">
            <thead>
            <tr>
                <th>Emp No</th>
                <th>Position</th>
                <th>Date</th>
                <th>Created By</th>
                <th>Action</th>
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
                <div class="modal-body modal-lg" id="showRemoteData" style="height:350px;">

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
        $('#career-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{!! route('list.career') !!}',
            columns: [
                { data: 'emp_no', name: 'emp_no' },
                { data: 'position', name: 'position' },
                { data: 'date', name: 'date' },
                { data: 'created_by', name: 'created_by' },
                { data: 'action', name: 'action' },
            ],

        });
    </script>


    <script>
        $('#career-table').on('click','a#openShow', function (e) {
            e.preventDefault();
            $('#showData').modal('show');

            $('#showRemoteData').waitMe({
                effect : 'bounce',
                text : 'Loading...',
                bg : "rgba(255,255,255,0.7)",
                color : "#000",
                maxSize : '',
                waitTime : -1,
                textPos : 'vertical',
                fontSize : '',
                source : '',
            });

            var id = $(this).data('id');
            $.ajax({
                url: 'career/showed/' + id,
                method: 'GET',
                success: function(data){

                    console.log(data);

                    $('#showRemoteData').html(data);

                    $("#showRemoteData").waitMe("hide");

                }
            });
        })
    </script>


@endpush
