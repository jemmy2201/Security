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
    @php
        Session::forget('passID')
    @endphp
    <div class="container" >
        <div class="row">
            <div class="col-12">
                <img  src="{{URL::asset('/img/information.png')}}" style="width: 100%;">
            </div>
        </div><br>
        <div class="row">
            <div class="col-5"></div>
            <div class="col-5"></div>
            <div class="col-2" align="left">
                <button class=" btn btn-light" style="border-style: groove; background: black; color: #E31D1A" id="next">
                    <a href="#" style="text-decoration:none; color: white;">
                        Continue
                    </a>
                </button>
            </div>
        </div>
    </div><br>


<script>

    $( document ).ready(function() {
        // 15 minutes not action
        setTimeout(RefreshPage, 900000);
        function RefreshPage() {
            window.location.href = "{{URL::to('relogin')}}"
        }
        // End 15 minutes not action

        $('#next').on('click', function () {
            window.location.href = "/login/qrcode";
        });
    });
</script>
@endsection
