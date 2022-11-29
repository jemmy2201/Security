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
        #ViewFormUploadFile{
            margin-top: 225px;
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
{{--    <div class="container" id="form_header_welcome" >--}}
{{--        <div class="row">--}}
{{--            <div class="col-4">--}}
{{--            </div>--}}
{{--            <div class="col-4 hidden-xs" style="background-color: #C3C3C3;">--}}
            <h3 align="center" style=" color: white;" id="line7" class="visible-xs hidden-md">Hello,</h3>
            <h3 align="center" style=" color: white;" id="line8" class="visible-xs hidden-md">USE Web Portal will be officially</h3>
            <h3 align="center" style=" color: white;" id="line9" class="visible-xs hidden-md">launched on 02 May 2022</h3>
{{--            </div>--}}
{{--            <div class="col-12 visible-xs hidden-md" style="background-color: #C3C3C3;">--}}
{{--                <h3 align="center">Hello,</h3>--}}
{{--                <h3 align="center">USE Web Portal will be officially</h3>--}}
{{--                <h3 align="center">launched on 02 May 2022</h3>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div><br>--}}
<br class="hidden-xs">
<br class="hidden-xs">
<br class="hidden-xs">
        <div class="container" id="form_check_file">
        <div class="row">
            <div class="col-8  hidden-xs">
            </div>
            <div class="col-4  visible-xs hidden-md">
            </div>
            <div class="col-4 " id="ViewFormUploadFile" >
                <form style="color:#595959" id="FormUploadFile" enctype="multipart/form-data" >
                    @csrf
                    <br>

                    <div class="mb-3 float-right">
                        <p style=" font-size:8px;color: white;">For Official Use Only</p>
{{--                        <button id="tigger_check_file" style="display:none;background-image: url('/img/BackgroundHome.png');font-size:8px" class="btn btn-secondary btn-lg">Choose file.</button>&nbsp;--}}
                        <button id="tigger_check_file" style="display:none;background-image: url('/img/BackgroundHome.png');font-size:8px" class="btn btn-secondary btn-lg"></button>&nbsp;
                        <input type="file" name="check_file" id="check_file" class="form-control form-control-lg" placeholder="text" style="display: none"  accept=".txt">
{{--                        <b id="text_name_file" style="font-size:8px;display: none; color: white;">No file chosen</b>--}}
{{--                    </div>--}}

{{--                    <div class="mb-3 float-right">--}}
                        <button type="submit" id="save" style="display:none;background-image: url('/img/BackgroundHome.png');background-color: #E01E37;font-size:8px" class="btn btn-secondary btn-lg ">
                            <b>Proceed</b>
                        </button>
                    </div>
                </form>
            </div>
        </div>
{{--        <div class="modal-dialog">--}}
{{--            <div class="modal-content" style="font-family: sans-serif">--}}
{{--                <div class="modal-header" style="justify-content: center !important;border-bottom:0px">--}}
{{--                    <h3 class="modal-title"><b>Choose File</b></h3>--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <form style="color:#595959" id="FormUploadFile" enctype="multipart/form-data" >--}}
{{--                        @csrf--}}
{{--                        <div class="mb-3">--}}
{{--                            <label for="title" class="col-form-label">Upgrade grade</label>--}}
{{--                            <input type="file" name="check_file" id="check_file" class="form-control form-control-lg" placeholder="text"  accept=".txt">--}}
{{--                        </div>--}}
{{--                        <div class="mb-3">--}}
{{--                            <button type="submit" id="save" style="background-color: #E01E37;font-size:16px" class="btn btn-secondary btn-lg ">--}}
{{--                                <b>Proceed</b>--}}
{{--                            </button>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>

    <div class="container" id="line1" style="display: none">
        <h4 style="font-weight: bold;">
            You must agree to the <span style="color: blue; cursor: pointer;" id="open_terms" data-toggle="modal" data-target="#exampleModalCenter">terms of use</span>  for accessing this service.
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
                <button class=" btn btn-light btn-lg btn-block" id="line3" style="display: none;border-style: groove; background: black; color: #E31D1A" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"  >
                    <a href="" style="text-decoration:none; color: white;">
                        Back
                    </a>
                </button>
            </div>
            <div class="col-2 hidden-xs" id="line4" style="display: none;">
                <button class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: black; color: #E31D1A" id="next">
                    <a href="#" style="text-decoration:none; color: white;">
                        Next
                    </a>
                </button>
            </div>

            {{--   Phone   --}}
            <div class="col-4 visible-xs hidden-md">
                <button class=" btn btn-light btn-lg btn-block" id="line5" style="display: none;border-style: groove; background: black; color: #E31D1A" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"  >
                    <a href="" style="text-decoration:none; color: white;">
                        Back
                    </a>
                </button>
            </div>
            <div class="col-4 visible-xs hidden-md" id="line6" style="display: none !important;">
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


<script>

    $( document ).ready(function() {
        @php
            $dateA = date("d M, Y g:i a");
            $dateB = time_off_temp_page_home;

            $dateA = str_replace(',', '', $dateA);
            $dateB = str_replace(',', '', $dateB);
        @endphp
        window.addEventListener('load', (event) => {
            if ({!!  json_encode(strtotime($dateA)) !!} > {!!  json_encode(strtotime($dateB)) !!})
            {
                $("#BodyAll").css('background-image', 'none');
                $("#line1").css("display", "block");
                $("#line2").css("display", "block");
                $("#line3").css("display", "block");
                $("#line4").css("display", "block");
                $("#line5").css("display", "block");
                $("#line6").css("display", "block");
                $("#line7").css("display", "block");
                $("#line8").css("display", "block");
                $("#line9").css("display", "block");
                $("#form_check_file").css("display", "none");
                $("#form_header_welcome").css("display", "none");
            }
            $("#tigger_check_file").css("display", "block");
            $("#save").css("display", "block");
            $("#text_name_file").css("display", "block");
        });

        $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            $('#text_name_file').text(fileName);
        });
        $( "#tigger_check_file" ).on( "click", function() {
            $( "#check_file" ).trigger( "click" );
        });
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
                        $("#BodyAll").css('background-image', 'none');
                        $("#line1").css("display", "block");
                        $("#line2").css("display", "block");
                        $("#line3").css("display", "block");
                        $("#line4").css("display", "block");
                        $("#line5").css("display", "block");
                        $("#line6").css("display", "block");
                        $("#line7").css("display", "block");
                        $("#line8").css("display", "block");
                        $("#line9").css("display", "block");
                        $("#form_check_file").css("display", "none");
                        $("#form_header_welcome").css("display", "none");
                    }
                }, error: function(data,textStatus, xhr){
                    // Error...
                    var errors = $.parseJSON(data.responseText);
                    $.each(errors, function(index, value) {
                        if (value == {!!  json_encode(file_wrong) !!} || value == {!!  json_encode(file_contents) !!} || value == {!!  json_encode(wrong_file_contents) !!})
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
