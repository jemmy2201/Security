@extends('layouts.app')
<style>
    .disabled{
        font-weight: normal;
    }
    @media (min-width :768px) {
        .modal-dialog {
            width: 968px !important;
        }
        #view_terms {
            width: 900px;
        }
    }
    @media (min-width :576px) {
        .modal-dialog {
            max-width: 930px !important;
        }
        #view_terms {
            width: 900px;
        }
    }

    @media only screen and (max-width: 600px) {
        #view_terms {
            width: 300px;
        }
    }
</style>
@section('content')
    <div class="container" id="form_check_file">
        <div class="modal-dialog">
            <div class="modal-content" style="font-family: sans-serif">
                <div class="modal-header" style="justify-content: center !important;border-bottom:0px">
                        <h3 class="modal-title"><b>Check File</b></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form style="color:#595959" id="FormUploadFile" enctype="multipart/form-data" >
                        @csrf
                        <div class="mb-3">
                            <label for="title" class="col-form-label">Upgrade grade</label>
                            <input type="file" name="check_file" id="check_file" class="form-control form-control-lg"  accept=".txt">
                        </div>
                        <div class="mb-3">
                            <button type="submit" id="save" style="background-color: #E01E37;font-size:16px" class="btn btn-secondary btn-lg ">
                                    <b>Upload</b>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="container" id="line1" style="display: none">
        <h4 style="font-weight: bold;">
            You must agree to the <span style="color: blue; cursor: pointer;" id="open_terms" data-toggle="modal" data-target="#exampleModalCenter">terms of use</span>  for accessing this ervice.
        </h4>
    </div>
    <br>
    <div class="container" id="line2" style="display: none">
        <div class="row">
            <div class="col-12">
                <h4>
                <input class="form-check-input" name="agree_pdf" type="checkbox" id="agree_pdf" width="120%">
                <span style="margin-left: 20px;font-weight: bold;">I have read and agree to the website's terms of use.</span>
                </h4>
            </div>
        </div>
    </div>
    <br><br><br>

    <div class="container">
        <div class="row">
            <div class="col-2 hidden-xs">
                <button class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: black; color: #E31D1A" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"  >
                    <a href="" style="text-decoration:none; color: white;">
                        Back
                    </a>
                </button>
            </div>
            <div class="col-2 hidden-xs" id="line3" style="display: none">
                <button class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: black; color: #E31D1A" id="next">
                    <a href="#" style="text-decoration:none; color: white;">
                        Next
                    </a>
                </button>
            </div>

            {{--   Phone   --}}
            <div class="col-4 visible-xs hidden-md">
                <button class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: black; color: #E31D1A" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"  >
                    <a href="" style="text-decoration:none; color: white;">
                        Back
                    </a>
                </button>
            </div>
            <div class="col-4 visible-xs hidden-md" id="line4" style="display: none">
                <button class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: black; color: #E31D1A" id="next_phone">
                    <a href="#" style="text-decoration:none; color: white;">
                        Next
                    </a>
                </button>
            </div>
            {{--   End Phone   --}}
        </div>
        @php
            $cutnric = substr(secret_decode(Auth::user()->nric), -4);
            $nric = "XXXXX$cutnric";
        @endphp
        <br>
{{--        <h4>Nric : {{ $nric }}</h4>--}}
    </div>

    <!-- Modal USE ID Card Portal Terms Of Use-->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
        <div class="modal-dialog modal-dialog-centered" role="document" >
            <div class="modal-content" >
                <div class="modal-header">
{{--                    <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>--}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                          <iframe src ="{{ asset('/USE ID Card Portal Terms Of Use.pdf') }}#toolbar=0"   height="500px;" style="display: block;" id="view_terms"></iframe>
                </div>
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>--}}
{{--                    <button type="button" class="btn btn-primary">Save changes</button>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
    <!-- End Modal USE ID Card Portal Terms Of Use-->


<script type="application/javascript">

    $( document ).ready(function() {
        //check File
        $("#FormUploadFile").submit(function(e) {
            var form_data = new FormData(document.getElementById("FormUploadFile"));
            form_data.append("_token", "{{ csrf_token() }}");
            e.preventDefault(); // avoid to execute the actual submit of the form.
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                data: form_data, // serializes the form's elements.
                url: "{{route('check_file_home')}}",
                success: function(data,textStatus, xhr)
                {
                    if(data['massages'] == {!!  json_encode(success_check) !!}){
                        $("#line1").css("display", "block");
                        $("#line2").css("display", "block");
                        $("#line3").css("display", "block");
                        $("#line4").css("display", "block");
                        $("#form_check_file").css("display", "none");
                    }
                }, error: function(data,textStatus, xhr){
                    // Error...
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function(index, value) {
                        swal("Attention!", value, "error")
                    });

                }
            });
        });
        //End check File

        // 15 minutes not action
        setTimeout(RefreshPage, 900000);
        function RefreshPage() {
            window.location.href = "{{URL::to('relogin')}}"
        }
        // End 15 minutes not action
        $('#open_terms').on('click', function () {
            // $("#view_terms").css("display", "block");
            // $('#view_terms').modal('show');
        });

        $('#next').on('click', function () {
            if ($("input[name='agree_pdf']:checked").val()) {
                console.log('ss')
                    window.location.href = "/landing_page";
            }else{
                swal("Error!", "Tick the check box to proceed.", "error")
            }
        });
        $('#next_phone').on('click', function () {
            if ($("input[name='agree_pdf']:checked").val()) {
                console.log('ss')
                window.location.href = "/landing_page";
            }else{
                swal("Error!", "Tick the check box to proceed.", "error")
            }
        });
    });
</script>
@endsection
