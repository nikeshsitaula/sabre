@extends('backend.layouts.app')
@section('content')
    <div class="content">
        {!! Form::open() !!}
        {!!Form::label('emp_no','Employee Number',['class'=>'col-form-label col-lg-2 require']) !!}
        <div class="col-lg-10">
            {!! Form::select('emp_no',$emp_no,$value=null,['class'=>"form-control select2",'placeholder'=>'']) !!}
        </div>
        {!! Form::close() !!}

        <a href="{{route('document.create')}}"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2"><b><i
                    class="icon-file-text3"></i></b> Add Document</a>
        <a href="#" id="printDoc"
           class="btn btn-primary btn-labeled btn-labeled-left btn-lg legitRipple float-right mt-2 mr-2"><b><i
                    class="icon-printer2"></i></b> Export Document</a>

        <div class="table">
            <table class="mdl-data-table mt-2" id="document-table" style="width: 1000px;">
                <thead>
                <tr>
                    <th>Emp No</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                </thead>
            </table>
        </div>


    </div>

    <!-- Modal -->
    <div class="modal fade" id="showData" tabindex="-1" role="dialog" aria-labelledby="showData" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalTitle">Document</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="print">
                    <div class="modal-body modal-lg" id="showRemoteData" style="height:350px;">

                    </div>
                </div>
                <a href="#" class="btn btn-success" onclick="printPage()"><i class="icon-printer2"></i> Print</a>
                <div class="modal-footer mt-3">
                    <button type="button" class="btn btn-secondary mt-5" data-dismiss="modal">Close</button>
                </div>
                <script>
                    function printPage(){
                        var prtContent = $("#print")[0];
                        var WinPrint = window.open('', '', 'left=0,top=0,width=1024,height=768,toolbar=0,scrollbars=0,status=0');
                        WinPrint.document.open()
                        WinPrint.document.write('<html><head>')
                        WinPrint.document.write('</head><body>');
                        WinPrint.document.write('<link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">');
                        WinPrint.document.write(prtContent.innerHTML);
                        WinPrint.document.write('</body></html>');
                        WinPrint.document.close();
                        WinPrint.print();
                    }
                </script>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#document-table').hide();
            $(".select2").select2({
                placeholder: "Select anyone",
                theme: 'modern',
                allowClear: true,
            });

            $('.select2').on('change', function () {
                $('.table').html('<table class="mdl-data-table mt-2" id="document-table" style="width: 1000px;">\n' +
                    '                <thead>\n' +
                    '                <tr>\n' +
                    '                    <th>Emp No</th>\n' +
                    '                    <th>Name</th>\n' +
                    '                    <th>Action</th>\n' +
                    '                </tr>\n' +
                    '                </thead>\n' +
                    '            </table>');

                //destroys datatable
                $('#document-table').DataTable().destroy();
                //load datatable data
                $('#document-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{!! route('list.document') !!}',
                    columns: [
                        {data: 'emp_no', name: 'emp_no'},
                        {data: 'name', name: 'name'},
                        {data: 'action', name: 'action'},
                    ],
                });
                ajaxShow();
                //searches datatable for emp_no
                search($(this).val());

            });

            function ajaxShow() {
                $('#document-table').on('click', 'a#openShow', function (e) {
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
                        url: 'document/showed/' + id,
                        method: 'GET',
                        success: function (data) {

                            // console.log(data);

                            $('#showRemoteData').html(data);

                            $("#showRemoteData").waitMe("hide");

                        }
                    });
                });
            }

            function search(emp_no) {
                $('input[type="search"]').val(emp_no).keyup();
            }

        });

        //Print Document
        $('#printDoc').on('click', function () {
            var emp = $('.select2').val();
            if(emp !==''){
                var id = $('.select2').val()
                $.ajax({
                    url: 'document/printDocument/' + id,
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
