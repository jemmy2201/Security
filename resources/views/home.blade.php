@extends('layouts.app')

@section('content')
<div class="container">
    <img class="hidden-xs" src="{{URL::asset('/img/img_step_proses/1.png')}}" style="width: 100%;">
    <center class="visible-xs hidden-md">
    <img  src="{{URL::asset('/img/img_step_proses/design_phone/1.png')}}" style="width: 80%;">
    </center>
<h3 style="color: #E31E1A;">ID Card Portal</h3>
<p style="color: #808080;">My Application Type</p>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <button type="button" class="btn btn-secondary btn-lg btn-block" id="news" value="@php echo news @endphp"  >New</button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-secondary btn-lg btn-block" id="replacement" value="@php echo replacement @endphp" >Replacement</button>
            </div>
            <div class="col-sm">
                <button type="button" class="btn btn-secondary btn-lg btn-block" id="renewal" value="@php echo renewal @endphp" >Renewal</button>
            </div>
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

        </div>
    </div>
    <form method="post" id="personal_particular" action="{{ route('personal.particular') }}" style="display: none">
        @csrf
        <input type="hidden" id="app_type" name="app_type">
        <input type="hidden" id="card" name="card">
        <input type="submit">
    </form>
<br>
<p style="color: #808080;">History Applications</p>
    <div style="border-style: groove;padding: 10px;">
        <table class="table" >
            <thead>
            <tr>
                <th scope="col">Application Type</th>
                <th scope="col" >Request Application</th>
                <th scope="col">Grade</th>
                <th scope="col" >Status Proses</th>
                <th scope="col" >Expired Date</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($schedule))
                @foreach($schedule as $index => $f)
                    @if($f->Status_app == submission)
                        @php $url="/history/book/appointment"; @endphp
                    @elseif($f->Status_app == book_appointment)
                        @php $url="/history/book/payment"; @endphp
                    @endif
                    <tr class='clickable-row' data-href='{{$url}}' style="cursor: pointer;">
                        @if($f->app_type == news)
                            <td>New</td>
                        @elseif($f->app_type == replacement)
                            <td>Replacement</td>
                        @elseif($f->app_type == renewal)
                            <td>Renewal</td>
                        @endif

                        @if($f->card_id == so_app)
                            <td>SO Application</td>
                        @elseif($f->card_id == avso_app)
                            <td>AVSO Application</td>
                        @elseif($f->card_id == pi_app)
                            <td>PI Application</td>
                        @endif
                        @if($f->card_id == so_app)
                                @if(!empty($f->grade_id) && $f->grade_id== so)
                                    <td>SO</td>
                                @elseif(!empty($f->grade_id) && $f->grade_id== sso)
                                    <td>SSO</td>
                                @elseif(!empty($f->grade_id) && $f->grade_id== sss)
                                    <td>SSS</td>
                                @else
                                    <td >SO</td>
                                @endif
{{--                            <td>--}}
{{--                                @foreach($grade as $g)--}}
{{--                                    @foreach (json_decode($f->grade_id) as $i)--}}
{{--                                        @if($g->id == $i)--}}
{{--                                            <pre>{{$g->name}}</pre>--}}
{{--                                        @endif--}}
{{--                                    @endforeach--}}
{{--                                @endforeach--}}
{{--                            </td>--}}
{{--                            @foreach($grade as $g)--}}
{{--                                @if($g->id == $f->grade_id)--}}
{{--                                    <td>{{$g->name}}</td>--}}
{{--                                @endif--}}
{{--                            @endforeach--}}
                        @else
                            <td>NA</td>
                        @endif
                        @if($f->Status_app == submission)
                            <td>Book Appointment</td>
                        @elseif($f->Status_app == book_appointment)
                            <td>Payment</td>
                        @endif
                        @if($f->Status_app == payment)
                            <td>{{$f->expired_date}}</td>
                        @else
                            <td></td>
                        @endif

                    </tr>
                @endforeach
            @endif
            @if(!empty($sertifikat))
                    @foreach($sertifikat as $index => $f)
                        <tr>
                            @if($f->app_type == news)
                                <td>New</td>
                            @elseif($f->app_type == replacement)
                                <td>Replacement</td>
                            @elseif($f->app_type == renewal)
                                <td>Renewal</td>
                            @endif

                            @if($f->card_id == so_app)
                                <td>SO Application</td>
                            @elseif($f->card_id == avso_app)
                                <td>AVSO Application</td>
                            @elseif($f->card_id == pi_app)
                                <td>PI Application</td>
                            @endif
                            @if($f->card_id == so_app)
                                @if(!empty($f->grade_id) && $f->grade_id== so)
                                    <td>SO</td>
                                @elseif(!empty($f->grade_id) && $f->grade_id== sso)
                                    <td>SSO</td>
                                @elseif(!empty($f->grade_id) && $f->grade_id== sss)
                                    <td>SSS</td>
                                @else
                                    <td >SO</td>
                                @endif
{{--                                <td>--}}
{{--                                @foreach($grade as $g)--}}
{{--                                        @foreach (json_decode($f->grade_id) as $i)--}}
{{--                                            @if($g->id == $i)--}}
{{--                                                    <pre>{{$g->name}}</pre>--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
{{--                                    @if($g->id == $f->grade_id)--}}
{{--                                        <td>{{$g->name}}</td>--}}
{{--                                    @endif--}}
{{--                                @endforeach--}}
{{--                                </td>--}}
                            @else
                                <td>NA</td>
                            @endif
                            <td>Completed</td>
                            <td>{{$f->expired_date}}</td>
                        </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
</div>
<script type="application/javascript">
    $(window).bind('resize', function(e)
    {
        this.location.reload(false); /* false to get page from cache */
        /* true to fetch page from server */
    });
    jQuery(document).ready(function($) {
        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
        });
    });
    if ((screen.width>=1024) && (screen.height>=768)) {
        $(".table").css({"display": "", "max-height": "50%","overflow":"auto"});
    } else {
        $(".table").css({"display": "inline-block", "max-height": "50%","overflow":"auto"});
    }
    // $.ajax({
    //     type:'get',
    //     url:'/ajax/cek/data/from',
    //     success:function(data) {
    //         if(data['new'] == true){
    //             $("#news").prop('disabled', false);
    //             $("#replacement").prop('disabled', true);
    //             $("#renewal").prop('disabled', true);
    //         }
    //         if(data['replacement'] == true){
    //             $("#news").prop('disabled', true);
    //             $("#replacement").prop('disabled', false);
    //             $("#renewal").prop('disabled', true);
    //         }
    //         if(data['renewal'] == true){
    //             $("#news").prop('disabled', true);
    //             $("#replacement").prop('disabled', true);
    //             $("#renewal").prop('disabled', false);
    //         }
    //         if(data['new'] == false && data['replacement'] == false && data['renewal'] == false){
    //             $("#news").prop('disabled', true);
    //             $("#replacement").prop('disabled', true);
    //             $("#renewal").prop('disabled', true);
    //         }
    //     }
    // });
    $(document).ready(function() {
        // Application type
        $("#news").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#replacement").addClass('btn-secondary').removeClass('btn-danger ');
            $("#renewal").addClass('btn-secondary').removeClass('btn-danger ');
            RemoveDissableRequest();
            $("#app_type").val(document.getElementById("news").value);
        });
        $("#replacement").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#news").addClass('btn-secondary').removeClass('btn-danger ');
            $("#renewal").addClass('btn-secondary').removeClass('btn-danger ');
            // RemoveDissableRequest();
            $("#app_type").val(document.getElementById("replacement").value);
            $( "#personal_particular" ).submit();
        });
        $("#renewal").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#news").addClass('btn-secondary').removeClass('btn-danger ');
            $("#replacement").addClass('btn-secondary').removeClass('btn-danger ');
            // RemoveDissableRequest();
            $("#app_type").val(document.getElementById("renewal").value);
            $( "#personal_particular" ).submit();
        });
        // End Application type

        // card
        $("#so_app").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#avso_app").addClass('btn-secondary').removeClass('btn-danger ');
            $("#pi_app").addClass('btn-secondary').removeClass('btn-danger ');
            $("#card").val(document.getElementById("so_app").value);
            $( "#personal_particular" ).submit();
        });
        $("#avso_app").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#so_app").addClass('btn-secondary').removeClass('btn-danger ');
            $("#pi_app").addClass('btn-secondary').removeClass('btn-danger ');
            $("#card").val(document.getElementById("avso_app").value);
            $( "#personal_particular" ).submit();
        });
        $("#pi_app").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#so_app").addClass('btn-secondary').removeClass('btn-danger ');
            $("#avso_app").addClass('btn-secondary').removeClass('btn-danger ');
            $("#card").val(document.getElementById("pi_app").value);
            $( "#personal_particular" ).submit();
        });
        // End card
    });

    function RemoveDissableRequest() {
        //remove disable request
        $.ajax({
            type:'get',
            url:'/ajax/cek/card/type',
            success:function(data) {
              if(data['so_app'] == true){
                  if(data['so_app'] == true && data['avso_app'] == true && data['pi_app'] == true){

                  }else if(data['so_app'] == true && data['avso_app'] == true){
                      $("#pi_app").prop("disabled", false);
                  }else if(data['so_app'] == true && data['pi_app'] == true){
                      $("#avso_app").prop("disabled", false);
                  }else{
                     $("#avso_app").prop("disabled", false);
                     $("#pi_app").prop("disabled", false);
                  }
              }else if(data['avso_app'] == true){
                  $("#pi_app").prop("disabled", false);
                  $("#so_app").prop("disabled", false);
              }else if(data['pi_app'] == true){
                  $("#avso_app").prop("disabled", false);
                  $("#so_app").prop("disabled", false);
              }else{
                  $("#pi_app").prop("disabled", false);
                  $("#avso_app").prop("disabled", false);
                  $("#so_app").prop("disabled", false);
              }

            }
        });
        //end remove disable request

        //remove disable request
        // $("#avso_app").prop("disabled", false);
        // $("#pi_app").prop("disabled", false);
        // $("#so_app").prop("disabled", false);
        //end remove disable request
    }
</script>
@endsection
