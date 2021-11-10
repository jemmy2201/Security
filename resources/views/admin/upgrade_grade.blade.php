@extends('layouts.app_admin')
<style>
    .datatableCeate{
        margin: 10px 0px 0px 10px;
    }
</style>
@section('content')
<div class="container">
    <div class=" navbar-light navbar-white">
        <table id="table_grade" class="table table-striped table-bordered dt-responsive nowrap">
            <thead>
            <tr>
                <th scope="col">NRIC</th>
                <th scope="col">Name</th>
                <th scope="col">Application Type</th>
                <th scope="col">Card Type</th>
                <th scope="col">Grade Type</th>
                <th scope="col">Status</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        {{-- Modal --}}
        <div class="modal fade" id="FormUpload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content" style="font-family: sans-serif">
                    <div class="modal-header" style="justify-content: center !important;border-bottom:0px">
                        <h5 class="modal-title" style="font-size: 25px;font-weight:600" id="ExerciseModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form style="font-weight:600;margin-left:31px;margin-right:31px;color:#595959" id="FormUploadExcelGrade" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="col-form-label">Upgrade grade</label>
                               <input type="file" name="upgrade_grade" id="upgrade_grade" class="form-control form-control-lg">
                            </div>
                            <div class="mb-3">
                                <button type="submit" id="save" style="background-color: #E01E37;font-size:16px" class="btn btn-secondary btn-lg btn-block"><b>Save</b></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Modal --}}
    </div>

<div id="restoring_data" style="display: block;"></div>

</div>

@endsection
@section('js')
    <!-- DataTables -->
    <script type="application/javascript">

        // $(window).bind('resize', function(e)
        // {
        //     this.location.reload(false); /* false to get page from cache */
        //     /* true to fetch page from server */
        // });
        $("#upgrade_grade").change(function() {
            var control = document.getElementById("upgrade_grade");
            var files = control.files;
            for (var i = 0; i < files.length; i++) {
                console.log('s',files[i].type)
                if(files[i].type != "text/csv"){
                    control.value = '';
                    swal("Please!", "upload files with the extension csv ", "error")
                }
            }
        });

        $(document).ready(function(){
            $.fn.dataTable.ext.errMode = 'none';
            table_grade = $('#table_grade').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            text: 'Upload Excel',
                            className: 'buttontable btn btn-light datatableCeate',
                            action: function ( e, dt, node, config ) {
                                $('#FormUpload').modal('show');
                            }
                        },
                        {
                            text: 'Download Template',
                            className: 'buttontable btn btn-light datatableCeate',
                            action: function ( e, dt, node, config ) {
                                window.location.href = '{{ url('ajax/download/excel/template/grade') }}';
                            }
                        },
                        {
                            text: 'Restoring Data',
                            className: 'buttontable btn btn-light datatableCeate',
                            action: function ( e, dt, node, config ) {
                                {{--window.location.href = '{{ url('ajax/restoring/table') }}';--}}
                                $( "#restoring_data" ).trigger( "click" );
                            }
                        }
                    ],
                    "ajax": {
                        "url": "{{route('admin.data.upgrade')}}",
                        "global": false,
                        "type": "POST",
                        "headers": {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    },
                    columns: [
                        {data: 'nric', name: 'nric'},
                        {data: 'name', name: 'name'},
                        {
                            data: 'app_type', name: 'app_type',
                            render: function (data, type, row) {
                                if(data == @php echo news @endphp){
                                    var data = 'New';
                                return data;
                            }else if(data ==@php echo replacement @endphp){
                                    var data = 'Replacement';
                                return data;
                            }else if(data ==@php echo renewal @endphp){
                                    var data = 'Renewal';
                                return data;
                            }
                            }
                        },
                        {data: 'card_id', name: 'card_id',
                            render: function (data, type, row) {
                                if(data == @php echo so_app @endphp){
                                    var data = 'SO Application';
                                    return data;
                                }else if(data ==@php echo avso_app @endphp){
                                        var data = 'AVSO Application';
                                    return data;
                                }else if(data ==@php echo pi_app @endphp){
                                        var data = 'PI Application';
                                    return data;
                                }
                            }
                        },
                        {data: 'grade_id', name: 'grade_id',
                            render: function (data, type, row) {
                                if(data == @php echo so @endphp){
                                    return 'SO';
                                }else if(data == @php echo sso @endphp){
                                    return 'SSO';
                                }else if(data == @php echo ss @endphp){
                                    return 'SS';
                                }else if(data == @php echo sss @endphp){
                                    return 'SSS';
                                }else if(data == @php echo cso @endphp){
                                        return 'CSO';
                                }else{
                                        return  '-';
                                }
                            }
                        },
                        {data: 'Status_app', name: 'Status_app',
                            render: function (data, type, row) {
                                if(data == @php echo draft @endphp){
                                    return "@php echo txt_draft @endphp";
                                }else if(data == @php echo submitted @endphp){
                                    return "@php echo txt_submitted @endphp";
                                }else if (data == @php echo processing @endphp){
                                    return "@php echo txt_processing @endphp";
                                }else if(data == @php echo id_card_ready_for_collection @endphp){
                                    return "@php echo txt_id_card_ready_for_collection @endphp";
                                }else if(data == @php echo resubmission @endphp){
                                    return "@php echo txt_resubmission @endphp";
                                }else if(data == @php echo Resubmitted @endphp){
                                    return "@php echo txt_Resubmitted @endphp";
                                }else if(data == "@php echo completed @endphp"){
                                    return "@php echo txt_completed @endphp";
                                }else{
                                    return "";
                                }
                            }
                        },
                    ]
                });
        });

        $(document).on('click', '#restoring_data', function (e) {
            e.preventDefault();
            swal({
                title: 'Are you sure?',
                text: 'Restoring Data!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        dataType: 'JSON',
                        contentType: false,
                        cache: false,
                        processData: false,
                        url: "{{route('admin.restoring.table')}}",
                        success: function(data,textStatus, xhr)
                        {
                            table_grade.ajax.reload();
                        }
                    });
                }
                });
        });

        $("#FormUploadExcelGrade").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var form_data = new FormData(document.getElementById("FormUploadExcelGrade"));
            form_data.append("_token", "{{ csrf_token() }}");

            $.ajax({
                type: "POST",
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                url: "{{route('admin.upload.grade')}}",
                data: form_data, // serializes the form's elements.
                success: function(data,textStatus, xhr)
                {
                    if(xhr.status == "201" || xhr.status == "200"){
                        // table_grade.ajax.reload();
                        location.reload();
                        $('#FormUpload').modal('hide');
                    }
                }, error: function(data,textStatus, xhr){
                    // Error...
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function(index, value) {
                        if(value == "The given data was invalid."){
                            swal("Error!", "Just only excel", "error");
                        }else if(index == "message" && value.search("1062") ){
                            swal("Error!", "Duplicate entry passid", "error");
                        }
                    });

                }
            });

        });


    </script>
@endsection
