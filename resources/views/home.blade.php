@extends('layouts.app')
<style>
    .disabled{
        font-weight: normal;
    }
</style
@section('content')
    <div class="container">
        <iframe src ="{{ asset('/USE ID Card Portal Terms Of Use.pdf') }}" width="100%" height="100%"></iframe>
    </div>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-6">
                <input class="form-check-input" type="checkbox" id="agree_pdf" width="120%">
                <span style="margin-left: 20px;font-weight: bold;font-size: 15px;">Agree</span>
            </div>
        </div>
    </div>
<script type="application/javascript">
    $( document ).ready(function() {
        $('#agree_pdf').on('click', function () {
            window.location.href = "/landing_page";
        });
    });
</script>
@endsection
