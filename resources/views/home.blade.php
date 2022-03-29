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
    <div class="container">
        <h4 style="font-weight: bold;">
            You must agree to the <span style="color: blue; cursor: pointer;" id="open_terms" data-toggle="modal" data-target="#exampleModalCenter">terms of use</span>  for accessing this web portal.
        </h4>
{{--        <h4 style="font-weight: bold;">--}}
{{--            Read <a href="#"> <span style="color: blue;" id="open_terms">TERMS OF USE </span></a>document.--}}
{{--        </h4>--}}
    </div>
{{--    <div class="container">--}}
{{--        <iframe src ="{{ asset('/USE ID Card Portal Terms Of Use.pdf') }}" width="100%" height="100%" style="display: none;" id="view_terms"></iframe>--}}
{{--    </div>--}}
    <br>
    <div class="container">
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
            <div class="col-2 hidden-xs">
                <button class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: black; color: #E31D1A" id="next">
                    <a href="#" style="text-decoration:none; color: white;">
                        Next
                    </a>
                </button>
            </div>
            <div class="col-4 visible-xs hidden-md">
                <button class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: black; color: #E31D1A" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"  >
                    <a href="" style="text-decoration:none; color: white;">
                        Back
                    </a>
                </button>
            </div>
            <div class="col-4 visible-xs hidden-md">
                <button class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: black; color: #E31D1A" id="next_phone">
                    <a href="#" style="text-decoration:none; color: white;">
                        Next
                    </a>
                </button>
            </div>
        </div>
        @php
            $cutnric = substr(secret_decode(Auth::user()->nric), -4);
            $nric = "XXXXX$cutnric";
        @endphp
        <br>
{{--        <h4>Nric : {{ $nric }}</h4>--}}
    </div>

    <!-- Modal -->
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


<script type="application/javascript">
    $( document ).ready(function() {
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
