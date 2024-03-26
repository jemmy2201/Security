@extends('layouts.app')
<style>
    table {
        width: 100%;
    }

    th {
        height: 50px;
    }

    #loading {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        position: absolute;
        top: 50%;
        left: 40%;
        height: 120px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }
    .loading {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        position: absolute;
        margin-top: 70px;
        left: 5%;
        height: 80px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }
    .loadingPhone {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        position: absolute;
        margin-top: 60px;
        left: 5%;
        height: 80px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }



    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    .HeaderdataPersonal{
        color:#808080;
        font-size: 20px;
    }
    .ColoumndataPersonal{
        font-weight: bold;
        font-size: 20px;
    }
    .loadingPaynow {
        /*border: 16px solid #f3f3f3;*/
        /*border-radius: 50%;*/
        /*border-top: 16px solid #3498db;*/
        width: 60%;
        position: absolute;

        /*margin-top: 60px;*/
        left: 40%;
        height: 60%;
        background: url({{asset('img/loading.gif')}}) no-repeat;
        /*-webkit-animation: spin 2s linear infinite; !* Safari *!*/
        /*animation: spin 2s linear infinite;*/
    }

    @media (min-width: 576px) {

        .modal-dialog {
            max-width: 700px !important;
        }
        .check_payment {
            width: 600px !important;
            margin: 30px auto !important;
        }
    }
    @media (min-width: 768px) {

        .modal-dialog {
            width: 692px !important;
        }
        .check_payment {
            width: 600px !important;
            margin: 30px auto !important;
        }
    }
    .footer-check-payment {
     display: block !important;
    }

</style>
@section('content')
<div class="container">
{{--    <div id="loading"></div>--}}
    <img  src="{{URL::asset('/img/use_ntuc.png')}}" style="width: 100%;margin-bottom: 20px;">
    <button type="button" id="member" class="btn btn-danger">Be a member</button>
</div>
{{--Can't back page --}}
<script>
    $( document ).ready(function() {
        $('#member').on('click', function () {
            window.location.href ='/landing_page';
        });
    });
</script>
<script type="text/javascript">
    function disableBack() { window.history.forward(); }
    setTimeout("disableBack()", 0);
    window.onunload = function () { null };
</script>
{{--End Can't back page --}}

<script src="https://unpkg.com/paynowqr@latest/dist/paynowqr.min.js"></script>
@endsection
