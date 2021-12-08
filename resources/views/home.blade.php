@extends('layouts.app')
<style>
    .disabled{
        font-weight: normal;
    }
</style
@section('content')
    <div class="container">
        <h4 style="font-weight: bold;">
            To continue further, you must agree to the terms of use for accessing this web portal.
        </h4>
        <h4 style="font-weight: bold;">
            Read <a href="#"> <span style="color: blue;" id="open_terms">TERMS OF USE </span></a>document.
        </h4>
    </div>
    <div class="container">
        <iframe src ="{{ asset('/USE ID Card Portal Terms Of Use.pdf') }}" width="100%" height="100%" style="display: none;" id="view_terms"></iframe>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h4>
                <input class="form-check-input" name="agree_pdf" type="checkbox" id="agree_pdf" width="120%">
                <span style="margin-left: 20px;font-weight: bold;">Accept Terms Of Use and proceed</span>
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
    </div>
<script type="application/javascript">
    $( document ).ready(function() {
        $('#open_terms').on('click', function () {
            $("#view_terms").css("display", "block");
        });

        $('#next').on('click', function () {
            if ($("input[name='agree_pdf']:checked").val()) {
                console.log('ss')
                    window.location.href = "/landing_page";
            }else{
                swal("Error!", "Tick Accept the Terms of Use.", "error")
            }
        });
        $('#next_phone').on('click', function () {
            if ($("input[name='agree_pdf']:checked").val()) {
                console.log('ss')
                window.location.href = "/landing_page";
            }else{
                swal("Error!", "Tick Accept the Terms of Use.", "error")
            }
        });
    });
</script>
@endsection
