@extends('layouts.app_admin')
<style>
    .datatableCeate{
        margin: 10px 0px 0px 10px;
    }
    #table_grade_filter{
        margin-top: 15px;
    }
</style>
@section('content')
<div class="container">
{{--    <div class=" navbar-light navbar-white">--}}
{{--        <table id="table_grade" class="table table-striped table-bordered dt-responsive nowrap">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th scope="col">NRIC</th>--}}
{{--                <th scope="col">Name</th>--}}
{{--                <th scope="col">Application Type</th>--}}
{{--                <th scope="col">Card Type</th>--}}
{{--                <th scope="col">Grade Type</th>--}}
{{--                <th scope="col">Status</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            </tbody>--}}
{{--        </table>--}}

        {{-- Modal --}}
{{--        <div class="modal fade" id="FormUpload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >--}}
{{--            <div class="modal-dialog">--}}
{{--                <div class="modal-content" style="font-family: sans-serif">--}}
{{--                    <div class="modal-header" style="justify-content: center !important;border-bottom:0px">--}}
{{--                        @if(Auth::user()->role == office)--}}
{{--                        <h5 class="modal-title"><b>Import New Records To USE Web Portal</b></h5>--}}
{{--                        @endif--}}
{{--                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>--}}
{{--                    </div>--}}
{{--                    <div class="modal-body">--}}
{{--                        <form style="font-weight:600;margin-left:31px;margin-right:31px;color:#595959" id="FormUploadExcelGrade" enctype="multipart/form-data">--}}
{{--                            @csrf--}}
{{--                            <div class="mb-3">--}}
{{--                                @if(Auth::user()->role == admin)--}}
{{--                                <label for="title" class="col-form-label">Upgrade grade</label>--}}
{{--                                @endif--}}
{{--                               <input type="file" name="upgrade_grade" id="upgrade_grade" class="form-control form-control-lg">--}}
{{--                            </div>--}}
{{--                            <div class="mb-3">--}}
{{--                                <button type="submit" id="save" style="background-color: #E01E37;font-size:16px" class="btn btn-secondary btn-lg btn-block">--}}
{{--                                 @if(Auth::user()->role == admin)--}}
{{--                                    <b>Save</b>--}}
{{--                                 @elseif(Auth::user()->role == office)--}}
{{--                                        <b>Proceed</b>--}}
{{--                                 @endif--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        {{-- End Modal --}}

{{--        <div class="modal fade" id="FormUpload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >--}}
            <div class="modal-dialog">
                <div class="modal-content" style="font-family: sans-serif">
                    <div class="modal-header" style="justify-content: center !important;border-bottom:0px">
                        @if(Auth::user()->role == office)
                            <h5 class="modal-title"><b>Import New Records To USE Web Portal</b></h5>
                        @endif
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form style="font-weight:600;margin-left:31px;margin-right:31px;color:#595959" id="FormUploadExcelGrade" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                @if(Auth::user()->role == admin)
                                    <label for="title" class="col-form-label">Upgrade grade</label>
                                @endif
                                <input type="file" name="upgrade_grade" id="upgrade_grade" class="form-control form-control-lg">
                            </div>
                            <div class="mb-3">
                                <button type="submit" id="save" style="background-color: #E01E37;font-size:16px" class="btn btn-secondary btn-lg btn-block">
                                    @if(Auth::user()->role == admin)
                                        <b>Save</b>
                                    @elseif(Auth::user()->role == office)
                                        <b id="btn_action_upload">Proceed</b>
                                    @endif
                                </button>
                            </div>
                        </form>
{{--                        <progress id="progressBar" value="0" max="100" style="width:300px;margin-left:85; display: none"></progress>--}}
                        <center>
{{--                        <h5 id="status" ></h5>--}}
                        <p id="read_record"></p>
                        <p id="total" ></p>
                        <p id="import_completed" ></p>
                        <p id="already_nric"></p>
                        </center>
                    </div>
                </div>
            </div>
{{--        </div>--}}

{{--    </div>--}}

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
                    swal("Error!", "upload files with the extension csv ", "error")
                }
            }
        });

        $(document).ready(function(){
            $.fn.dataTable.ext.errMode = 'none';
            if({!!  json_encode(Auth::user()->role) !!} == {!!  json_encode(admin) !!}) {
                var acces_button = [
                    {
                        text: 'Upload Excel',
                        className: 'buttontable btn btn-light datatableCeate',
                        action: function (e, dt, node, config) {
                            $('#FormUpload').modal('show');
                        }
                    },
                    {
                        text: 'Download Template',
                        className: 'buttontable btn btn-light datatableCeate',
                        action: function (e, dt, node, config) {
                            window.location.href = '{{ url('ajax/download/excel/template/grade') }}';
                        }
                    },
                    {
                        text: 'Restoring Data',
                        className: 'buttontable btn btn-light datatableCeate',
                        action: function (e, dt, node, config) {
                            {{--window.location.href = '{{ url('ajax/restoring/table') }}';--}}
                            $("#restoring_data").trigger("click");
                        }
                    }
                ];
            }else if ({!!  json_encode(Auth::user()->role) !!} == {!!  json_encode(office) !!}){
                var acces_button = [
                    {
                        text: 'Upload Excel',
                        className: 'buttontable btn btn-light datatableCeate',
                        action: function (e, dt, node, config) {
                            $('#FormUpload').modal('show');
                        }
                    }
                ];
            }
            table_grade = $('#table_grade').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: true,
                    dom: 'Bfrtip',
                    buttons: acces_button,
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
                                {{--if(data == @php echo draft @endphp){--}}
                                {{--    return "@php echo txt_draft @endphp";--}}
                                {{--}else if(data == @php echo processing @endphp){--}}
                                {{--    return "@php echo txt_submitted @endphp";--}}
                                {{--}else if (data == @php echo processing @endphp){--}}
                                {{--    return "@php echo txt_processing @endphp";--}}
                                {{--}else if(data == @php echo id_card_ready_for_collection @endphp){--}}
                                {{--    return "@php echo txt_id_card_ready_for_collection @endphp";--}}
                                {{--}else if(data == @php echo resubmission @endphp){--}}
                                {{--    return "@php echo txt_resubmission @endphp";--}}
                                {{--}else if(data == @php echo Resubmitted @endphp){--}}
                                {{--    return "@php echo txt_Resubmitted @endphp";--}}
                                {{--}else if(data == "@php echo completed @endphp"){--}}
                                {{--    return "@php echo txt_completed @endphp";--}}
                                {{--}else{--}}
                                {{--    return "";--}}
                                {{--}--}}
                                if(data == @php echo draft @endphp){
                                    return "@php echo txt_draft @endphp";
                                }else if(data == @php echo processing @endphp){
                                    return "@php echo txt_processing @endphp";
                                }else if (data == @php echo ready_for_id_card_printing @endphp){
                                    return "@php echo txt_ready_for_id_card_printing @endphp";
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
        function progressHandler(event){
            document.getElementById("progressBar").style.display = "block";
            // hitung prosentase
            var percent = (event.loaded / event.total) * 100;
            // menampilkan prosentase ke komponen id 'progressBar'
            // document.getElementById("progressBar").value = Math.round(percent);
            // document.getElementById("progressBar").value = Math.round("0");
            // menampilkan prosentase ke komponen id 'status'
            // document.getElementById("status").innerHTML = Math.round(percent)+"% Complete";
            // document.getElementById("status").innerHTML = Math.round("0")+"% Complete";
            // menampilkan file size yg tlh terupload dan totalnya ke komponen id 'total'
        }
        $("#FormUploadExcelGrade").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var form_data = new FormData(document.getElementById("FormUploadExcelGrade"));
            form_data.append("_token", "{{ csrf_token() }}");
            if({!!  json_encode(Auth::user()->role) !!} == {!!  json_encode(admin) !!}) {
                var router = "{{route('admin.upload.grade')}}";
            }else if ({!!  json_encode(Auth::user()->role) !!} == {!!  json_encode(office) !!}){
                var router = "{{route('admin.upload.import.grade')}}";
            }
            {{--$.ajax({--}}
            {{--    type: "POST",--}}
            {{--    dataType: 'JSON',--}}
            {{--    contentType: false,--}}
            {{--    cache: false,--}}
            {{--    processData: false,--}}
            {{--    url: router,--}}
            {{--    data: form_data, // serializes the form's elements.--}}
            {{--    success: function(data,textStatus, xhr)--}}
            {{--    {--}}
            {{--        if (data.error == @php echo data_already_exists @endphp) {--}}
            {{--            swal("Error!", " The data already exists", "error");--}}
            {{--        }else if(xhr.status == "201" || xhr.status == "200"){--}}
            {{--            swal("Success!", "Import", "success");--}}
            {{--            location.reload();--}}
            {{--            $('#FormUpload').modal('hide');--}}
            {{--        }--}}
            {{--    }, error: function(data,textStatus, xhr){--}}
            {{--        // Error...--}}
            {{--        var errors = $.parseJSON(data.responseText);--}}
            {{--        $.each(errors, function(index, value) {--}}
            {{--            if(value == "The given data was invalid."){--}}
            {{--                swal("Error!", "Just only excel", "error");--}}
            {{--            }else if(index == "message" && value.search("1062") ){--}}
            {{--                swal("Error!", "Duplicate entry passid", "error");--}}
            {{--            }--}}
            {{--        });--}}

            {{--    }--}}
            {{--});--}}
            var file = document.getElementById("upgrade_grade").files[0];
            var formdata = new FormData();
            formdata.append("_token", "{{ csrf_token() }}");
            formdata.append("upgrade_grade", file);

            // proses upload via AJAX disubmit ke 'upload.php'
            // selama proses upload, akan menjalankan progressHandler()
            var ajax = new XMLHttpRequest();
            ajax.timeout = 200000000000000000000000000000000000000000000; // time in milliseconds

            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("import_completed").innerHTML = "Import Records Completed";

                    document.getElementById("btn_action_upload").innerHTML = "Importing Completed";

                    var DataArr = JSON.parse(this.responseText);
                    var Count_alread_nric = Object.keys(DataArr[DataArr.length - 1]['Already_nric']).length;

                    var percent = (Count_alread_nric / DataArr[0]['count_real_excel']) * 100;

                    // console.log('DataArrReal',DataArr);
                    // console.log('Records Added',DataArr[1].length);
                    // console.log('percent',percent)
                    // console.log('Count_alread_nric',Count_alread_nric)
                    // console.log('count_real_excel',DataArr[0]['count_real_excel'])
                    // console.log('read_record',DataArr[DataArr.length - 2]['data_read'] )
                    // console.log('already_data',DataArr[1]['data_error'])

                    var read_records = parseInt(DataArr[DataArr.length - 2]['data_read']) - parseInt('1');
                    var add_records = parseInt(DataArr[0]['count_real_excel']) - parseInt(Count_alread_nric);
                    if (read_records == DataArr[0]['count_real_excel']){
                        var Dpercent = '100';
                    }else{
                        var Dpercent = percent;
                    }
                    if(percent == {!!  json_encode(zero) !!}){

                        // document.getElementById("progressBar").value = Math.round(Dpercent);

                        // document.getElementById("status").innerHTML = Math.round(Dpercent)+"% Complete";

                        document.getElementById("read_record").innerHTML = "Total Records Read = "+ read_records +","+ parseInt(DataArr[0]['count_real_excel']);

                        document.getElementById("total").innerHTML = "Total New Records Added = "+ add_records +","+ parseInt(DataArr[0]['count_real_excel']);

                    }else{
                        // document.getElementById("progressBar").value = Math.round(Dpercent);

                        // document.getElementById("status").innerHTML = Math.round(Dpercent)+"% Complete";

                        if (DataArr[1].length == 'undefined'){
                            var Records_Added = 0;
                        }else{
                            var Records_Added = DataArr[1].length;
                        }

                        document.getElementById("read_record").innerHTML = "Total Records Read = "+ read_records +","+ parseInt(DataArr[0]['count_real_excel']);

                        document.getElementById("total").innerHTML = "Total New Records Added = "+ add_records +","+ parseInt(DataArr[0]['count_real_excel']);

                    }



                    if (DataArr[1]['data_error'] == {!!  json_encode(data_already_exists) !!}){
                        document.getElementById("already_nric").innerHTML = "Errors Found - Please Review Log Files";
                    }

                }else if(this.status == 500){
                    swal("Error!", "Please Import Again", "error")
                }
            };
            ajax.upload.addEventListener("progress", progressHandler, true);
            ajax.open("POST", router, true);
            ajax.send(formdata);
        });

    </script>
@endsection
