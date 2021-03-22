@extends('layouts.app')

@section('content')
<div class="container">
<h3 style="color: #E31E1A;">ID Card Portal</h3>
<p style="color: #808080;">My Application Type</p>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-secondary btn-lg btn-block" id="news" value="@php echo news @endphp">New</button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-secondary btn-lg btn-block" id="replacement" value="@php echo replacement @endphp">Replacement</button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-secondary btn-lg btn-block" id="renewal" value="@php echo renewal @endphp">Renewal</button>
            </div>
            <input type="hidden" id="value_application" name="value_application">
        </div>
    </div>
<br>
<p style="color: #808080;">My Request</p>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <button type="button" id="so_app" class="btn btn-secondary btn-lg btn-block" value="@php echo so_app @endphp" disabled>SO Application</button>
            </div>
            <div class="col-sm">
                <button type="button" id="avso_app" class="btn btn-secondary btn-lg btn-block" value="@php echo avso_app @endphp" disabled>AVSO Aplication</button>
            </div>
            <div class="col-sm">
                <button type="button" id="pi_app" class="btn btn-secondary btn-lg btn-block" value="@php echo pi_app @endphp" disabled>PI Aplication</button>
            </div>
            <input type="hidden" id="value_request" name="value_request">

        </div>
    </div>
<br>
<p style="color: #808080;">History Applications</p>
    <div style="border-style: groove;padding: 10px;">
        <center>
        This portion will display the member’s applications details and their status
        </center>
    </div>
</div>
<script type="application/javascript">
    $(document).ready(function() {
        // Application type
        $("#news").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#replacement").addClass('btn-secondary').removeClass('btn-danger ');
            $("#renewal").addClass('btn-secondary').removeClass('btn-danger ');
            RemoveDissableRequest();
            $("#value_application").val(document.getElementById("news").value);
        });
        $("#replacement").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#news").addClass('btn-secondary').removeClass('btn-danger ');
            $("#renewal").addClass('btn-secondary').removeClass('btn-danger ');
            RemoveDissableRequest();
            $("#value_application").val(document.getElementById("replacement").value);
        });
        $("#renewal").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#news").addClass('btn-secondary').removeClass('btn-danger ');
            $("#replacement").addClass('btn-secondary').removeClass('btn-danger ');
            RemoveDissableRequest();
            $("#value_application").val(document.getElementById("renewal").value);
        });
        // End Application type

        // Request
        $("#so_app").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#avso_app").addClass('btn-secondary').removeClass('btn-danger ');
            $("#pi_app").addClass('btn-secondary').removeClass('btn-danger ');
            $("#value_request").val(document.getElementById("so_app").value);
            {{--var url = "{{route('personal.particular')}}"+"/"+$("#value_application").val()+"/"+$("#value_request").val();--}}
            // window.location.href = url;
        });
        $("#avso_app").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#so_app").addClass('btn-secondary').removeClass('btn-danger ');
            $("#pi_app").addClass('btn-secondary').removeClass('btn-danger ');

            $("#value_request").val(document.getElementById("avso_app").value);
        });
        $("#pi_app").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#so_app").addClass('btn-secondary').removeClass('btn-danger ');
            $("#avso_app").addClass('btn-secondary').removeClass('btn-danger ');
            $("#value_request").val(document.getElementById("pi_app").value);
        });
        // End Request
    });

    function RemoveDissableRequest() {
        //remove disable request
        $("#avso_app").prop("disabled", false);
        $("#pi_app").prop("disabled", false);
        $("#so_app").prop("disabled", false);
        //end remove disable request
    }
</script>
@endsection
