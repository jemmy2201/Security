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
{{--        <div class="modal fade" id="FormUpload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >--}}
            <div class="modal-dialog">
                <div class="modal-content" style="font-family: sans-serif">
                    <div class="modal-header" style="justify-content: center !important;border-bottom:0px">
                            <h5 class="modal-title"><b>Upload Payment</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form style="font-weight:600;margin-left:31px;margin-right:31px;color:#595959" id="FormUploadExcelGrade" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
{{--                                    <label for="title" class="col-form-label">Upload Payment</label>--}}
                                <input type="file" name="upload_payment" id="upload_payment" class="form-control form-control-lg" >
                            </div>
                            <div class="mb-3">
                                <button type="submit" id="save" style="background-color: #E01E37;font-size:16px" class="btn btn-secondary btn-lg btn-block">
                                        <b id="btn_action_upload">Proceed</b>
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
        $("#upload_payment").change(function() {
            document.getElementById("btn_action_upload").innerHTML = "Proceed";
            document.getElementById("import_completed").innerHTML = "";
            document.getElementById("save").disabled = false;

            // var control = document.getElementById("upload_payment");
            // var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.csv)$/;
            // if (regex.test(control.value.toLowerCase())) {
            // }else{
            //     swal("Error!", "upload files with the extension csv ", "error")
            // }
            // var files = control.files;
            // for (var i = 0; i < files.length; i++) {
            //     console.log('s',files[i].type)
            //     if(files[i].type != "text/csv"){
            //         control.value = '';
            //         swal("Error!", "upload files with the extension csv ", "error")
            //     }
            // }
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
            var router = "{{route('admin.upload.payment')}}";
            var file = document.getElementById("upload_payment").files[0];
            var formdata = new FormData();
            formdata.append("_token", "{{ csrf_token() }}");
            formdata.append("upload_payment", file);

            // proses upload via AJAX disubmit ke 'upload.php'
            // selama proses upload, akan menjalankan progressHandler()
            var ajax = new XMLHttpRequest();
            ajax.timeout = 20000000000000000000000000000000000000000000000000; // time in milliseconds
            document.getElementById("btn_action_upload").innerHTML = "Waiting";
            document.getElementById("save").disabled = true;
            ajax.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var json = JSON.parse(ajax.responseText);
                    if(json == true) {
                        // document.getElementById("import_completed").innerHTML = "Import Records Completed";
                        document.getElementById("btn_action_upload").innerHTML = "Upload Completed";
                        var str="Data Uploaded successfully";
                        swal("Attention!", str, "success")
                            .then((value) => {
                                if (value){

                                }
                            });
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
