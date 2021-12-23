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
                <button type="button" id="avso_app" class="btn btn-secondary btn-lg btn-block" value="@php echo avso_app @endphp" disabled>AVSO Application</button>
            </div>
            <div class="col-sm">
                <button type="button" id="pi_app" class="btn btn-secondary btn-lg btn-block" value="@php echo pi_app @endphp" disabled>PI Application</button>
            </div>

        </div>
    </div>
    <form method="post" id="personal_particular" action="{{ route('personal.particular') }}" style="display: none">
        @csrf
        <input type="text" id="app_type" name="app_type">
        <input type="text" id="card" name="card">
        <input type="submit">
    </form>

    <input type="hidden" id="new_click" name="new_click">
    <input type="hidden" id="replacement_click" name="replacement_click">
    <input type="hidden" id="renewal_click" name="renewal_click">

<br>
<p style="color: #808080;">My Applications</p>
    <div style="border-style: ridge;padding: 10px;">
        <table class="table" >
            <thead>
            <tr>
                <th scope="col">Application Type</th>
                <th scope="col" >Request Application</th>
{{--                <th scope="col" >Date Of Application</th>--}}
                <th scope="col">Date Of Transaction</th>
                <th scope="col">Grade</th>
                <th scope="col" >Status</th>
{{--                <th scope="col" >Expired Date</th>--}}
                <th scope="col" >Action</th>
            </tr>
            </thead>
            <tbody>
            @if(!empty($schedule))
                @foreach($schedule as $index => $f)
                    @if($f->Status_app == processing)
{{--                    @php $url="/history/book/appointment/".$f->app_type."/".$f->card_id; @endphp--}}
                        @php $url=url("/history/book/appointment/")."/".$f->app_type."/".$f->card_id; @endphp
                    @elseif($f->Status_app == draft)
{{--                        @php $url="/history/book/payment/".$f->app_type."/".$f->card_id; @endphp--}}
                        @php $url=url("/history/book/payment/")."/".$f->app_type."/".$f->card_id; @endphp
                    @endif
                    <tr style="cursor: pointer;">
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
{{--                            <td>@php echo Carbon\Carbon::createFromFormat('Y-m-d', $f->declaration_date)->format('d-m-Y') @endphp</td>--}}
                            @if(!empty($f->trans_date))
{{--                                <td>@php echo Carbon\Carbon::createFromFormat('Y-m-d h:i:s', $f->trans_date)->format('d-m-Y') @endphp</td>--}}
                                <td>{{$f->trans_date}}</td>
                            @else
                                <td></td>
                            @endif

                        @if($f->card_id == so_app)
                                @if(!empty($f->grade_id) && $f->grade_id== so)
                                    <td>SO</td>
                                @elseif(!empty($f->grade_id) && $f->grade_id== sso)
                                    <td>SSO</td>
                                @elseif(!empty($f->grade_id) && $f->grade_id== ss)
                                    <td>SS</td>
                                @elseif(!empty($f->grade_id) && $f->grade_id== sss)
                                    <td>SSS</td>
                                @elseif(!empty($f->grade_id) && $f->grade_id== cso)
                                    <td>CSO</td>
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
                       @if($f->Status_app == draft)
                            <td>{{txt_draft}}</td>
                        @elseif($f->Status_app == processing)
                            <td>{{txt_submitted}}</td>
                        @elseif($f->Status_app == processing)
                            <td>{{txt_processing}}</td>
                        @elseif($f->Status_app == id_card_ready_for_collection)
                            <td>{{txt_id_card_ready_for_collection}}</td>
                        @elseif($f->Status_app == resubmission)
                            <td>{{txt_resubmission}}</td>
                        @elseif($f->Status_app == Resubmitted)
                            <td>{{txt_Resubmitted}}</td>
                        @endif
                        @if($f->Status_app == processing)
{{--                             <td>@php echo Carbon\Carbon::createFromFormat('Y-m-d h:i:s', $f->expired_date)->format('d-m-Y') @endphp</td>--}}
                        @else
{{--                            <td></td>--}}
                        @endif

                        @if($f->Status_app == draft)
{{--                                @if($f->Status_draft == draft_book_appointment)--}}
{{--                                    @php $url="/history/book/appointment/".$f->app_type."/".$f->card_id; @endphp--}}
{{--                                @elseif($f->Status_draft == draft_payment)--}}
{{--                                    @php $url=url("/history/book/payment/")."/".$f->app_type."/".$f->card_id; @endphp--}}
{{--                                @endif--}}
                                @php $url=url("/draft")."/".$f->app_type."/".$f->card_id; @endphp
                                <td><a href="{{$url}}"><button class="btn btn-primary">Draft</button></a></td>
                        @elseif($f->Status_app == resubmission)
                            @php $url=url("/personal/particular")."/".$f->app_type."/".$f->card_id."/".resubmission; @endphp
                                <td><a href="{{$url}}"><button class="btn btn-success">Resubmit</button></a></td>
                        @elseif($f->Status_app >= processing)
                                @php $url=url("/view/course")."/".$f->card_id; @endphp
                                <td><a href="{{$url}}"><button class="btn btn-success">View</button></a></td>
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
{{--                                <td>@php echo Carbon\Carbon::createFromFormat('Y-m-d h:i:s', $f->declaration_date)->format('d-m-Y') @endphp</td>--}}
                                @if(!empty($f->trans_date))
{{--                                <td>@php echo Carbon\Carbon::createFromFormat('Y-m-d h:i:s', $f->trans_date)->format('d-m-Y') @endphp</td>--}}
                                    <td>{{$f->trans_date}}</td>
                                @else
                                    <td></td>
                                @endif
                            @if($f->card_id == so_app)
                                @if(!empty($f->grade_id) && $f->grade_id== so)
                                    <td>SO</td>
                                @elseif(!empty($f->grade_id) && $f->grade_id== sso)
                                    <td>SSO</td>
                                @elseif(!empty($f->grade_id) && $f->grade_id== ss)
                                    <td>SS</td>
                                @elseif(!empty($f->grade_id) && $f->grade_id== sss)
                                    <td>SSS</td>
                                @elseif(!empty($f->grade_id) && $f->grade_id== cso)
                                    <td>CSO</td>
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
{{--                            <td>@php echo Carbon\Carbon::createFromFormat('Y-m-d h:i:s', $f->expired_date)->format('d-m-Y') @endphp</td>--}}
                            <td></td>
                        </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>
    <div class="modal" tabindex="-1" role="dialog" id="Modalreplacement">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table" >
                        <thead>
                        <tr>
                            <th scope="col">Application Type</th>
                            <th scope="col" >Request Application</th>
                            <th scope="col">Grade</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $expried_replacement =true; @endphp
                        @if(!empty($replacement))
                            @foreach($replacement as $index => $f)
{{--                                @php $url="/replacement/personal/particular/".$f->card_id; @endphp--}}
                                    @php $url=url("/replacement/personal/particular/")."/".$f->card_id; @endphp
                                    @php
                                      //$expried = Carbon\Carbon::today()->toDateString() >= Carbon\Carbon::parse($f->expired_date)->toDateString();
                                       if ($f->expired_date){
                                            $expried_replacement = Carbon\Carbon::today()->toDateString() >= Carbon\Carbon::createFromFormat('d/m/Y', $f->expired_date)->format('Y-m-d');
                                       }else{
                                           $expried_replacement =true;
                                       }
                                    @endphp
{{--                                @if($expried == false)--}}
                                @if($f->Status_app == completed && $expried_replacement == false)

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
                                        @elseif(!empty($f->grade_id) && $f->grade_id== ss)
                                            <td>SS</td>
                                        @elseif(!empty($f->grade_id) && $f->grade_id== sss)
                                            <td>SSS</td>
                                        @elseif(!empty($f->grade_id) && $f->grade_id== cso)
                                            <td>CSO</td>
                                        @else
                                            <td >SO</td>
                                        @endif
                                    @else
                                        <td>NA</td>
                                    @endif
                                </tr>
                                @endif
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="Modalrenewal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Application Type</th>
                            <th scope="col" >Request Application</th>
                            <th scope="col">Grade</th>
                        </tr>
                        </thead>
                        <tbody>
                        @php $expried_renewal =true; @endphp
                        @if(!empty($renewal))
                            @foreach($renewal as $index => $f)
                                @php
                                if (!empty($f->expired_date)){
                                        $expried_renewal = Carbon\Carbon::today()->toDateString() >= Carbon\Carbon::createFromFormat('d/m/Y', $f->expired_date)->format('Y-m-d');
                                }else{
                                        $expried_renewal = false;
                                }
                                @endphp
                                @if($f->Status_app == completed && $expried_renewal == true )
{{--                                @php $url="/renewal/personal/particular/".$f->card_id; @endphp--}}
                                @php $url=url("/renewal/personal/particular/")."/".$f->card_id; @endphp
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
                                        @elseif(!empty($f->grade_id) && $f->grade_id== ss)
                                            <td>SS</td>
                                        @elseif(!empty($f->grade_id) && $f->grade_id== sss)
                                            <td>SSS</td>
                                        @elseif(!empty($f->grade_id) && $f->grade_id== cso)
                                            <td>CSO</td>
                                        @else
                                            <td >SO</td>
                                        @endif
                                    @else
                                        <td>NA</td>
                                    @endif
                                </tr>
                                @endif
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>

</div>
<script type="application/javascript">
    $(window).bind('resize', function(e)
    {
        this.location.reload(false); /* false to get page from cache */
        /* true to fetch page from server */
    });
    if ({!!  json_encode($cekStatusUser) !!} == null ){
        $("#news").prop('disabled', true);
        $("#replacement").prop('disabled', true);
        $("#renewal").prop('disabled', true);
    }
    // delete process
    function delete_process(id,app_type,card_id){
        swal({
            title: 'Are you sure?',
            text: 'Delete!',
            icon: 'warning',
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    url: "{{route('users.delete.process')}}",
                    data: {id: id,app_type:app_type,card_id:card_id},
                    success: function(data,textStatus, xhr)
                    {
                        location.reload();
                    }
                });
            }
        });
    }
    // end delete process

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
            Remove_course();
            // RemoveDissableRequest();
            check_card_new();
            $("#app_type").val(document.getElementById("news").value);
            $("#new_click").val(true);
            $("#replacement_click").val(false);
            $("#renewal_click").val(false);
        });
        $("#replacement").click(function() {
            // $('#Modalreplacement').modal('show');
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#news").addClass('btn-secondary').removeClass('btn-danger ');
            $("#renewal").addClass('btn-secondary').removeClass('btn-danger ');
            // RemoveDissableRequest();
            Remove_course();
            check_card_replacement();
            $("#replacement_click").val(true);
            $("#new_click").val(false);
            $("#renewal_click").val(false);
            $("#app_type").val(document.getElementById("replacement").value);
            // $( "#personal_particular" ).submit();
        });
        $("#renewal").click(function() {
            // $('#Modalrenewal').modal('show');
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#news").addClass('btn-secondary').removeClass('btn-danger ');
            $("#replacement").addClass('btn-secondary').removeClass('btn-danger ');
            // RemoveDissableRequest();
            Remove_course();
            check_card_renewal();
            $("#renewal_click").val(true);
            $("#new_click").val(false);
            $("#replacement_click").val(false);
            $("#app_type").val(document.getElementById("renewal").value);
            // $( "#personal_particular" ).submit();
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
            if($("#new_click").val() == "true"){
                $( "#personal_particular" ).submit();
            }
            if($("#replacement_click").val() == "true"){
                document.getElementById('personal_particular').action = 'replacement/personal/particular';
                $("#personal_particular" ).submit();
            }
            if($("#renewal_click").val() == "true"){
                document.getElementById('personal_particular').action = 'renewal/personal/particular';
                $("#personal_particular" ).submit();
            }
        });
        $("#pi_app").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#so_app").addClass('btn-secondary').removeClass('btn-danger ');
            $("#avso_app").addClass('btn-secondary').removeClass('btn-danger ');
            $("#card").val(document.getElementById("pi_app").value);
            if($("#new_click").val() == "true"){
                $( "#personal_particular" ).submit();
            }
            if($("#replacement_click").val() == "true"){
                document.getElementById('personal_particular').action = 'replacement/personal/particular';
                $("#personal_particular" ).submit();
            }
            if($("#renewal_click").val() == "true"){
                document.getElementById('personal_particular').action = 'renewal/personal/particular';
                $("#personal_particular" ).submit();
            }
        });
        // End card
    });

    function Remove_course() {
        $("#so_app").prop("disabled", true);
        $("#avso_app").prop("disabled", true);
        $("#pi_app").prop("disabled", true);
    }
    function check_card_new() {
        {!!  json_encode($new) !!}.forEach((entry) => {
            if(entry['Status_app'] == null) {
                if (entry['card_id'] == {!!  json_encode(so_app) !!}) {
                    $("#so_app").prop("disabled", false);
                } else if (entry['card_id'] == {!!  json_encode(avso_app) !!}) {
                    $("#avso_app").prop("disabled", false);
                } else if (entry['card_id'] == {!!  json_encode(pi_app) !!}) {
                    $("#pi_app").prop("disabled", false);
                }
            }
        });
    }
    function check_card_replacement() {
        {!!  json_encode($replacement) !!}.forEach((entry) => {
            if(entry['Status_app'] == {!!  json_encode(completed) !!} && {!!  json_encode($expried_replacement) !!} == false ) {
                if (entry['card_id'] == {!!  json_encode(so_app) !!}) {
                    $("#so_app").prop("disabled", false);
                } else if (entry['card_id'] == {!!  json_encode(avso_app) !!}) {
                    $("#avso_app").prop("disabled", false);
                } else if (entry['card_id'] == {!!  json_encode(pi_app) !!}) {
                    $("#pi_app").prop("disabled", false);
                }
            }
        });
    }
    function check_card_renewal() {
        {!!  json_encode($renewal) !!}.forEach((entry) => {
            if(  entry['Status_app'] == {!!  json_encode(completed) !!} && {!!  json_encode($expried_renewal) !!} == true) {
                if (entry['card_id'] == {!!  json_encode(so_app) !!}) {
                    $("#so_app").prop("disabled", false);
                } else if (entry['card_id'] == {!!  json_encode(avso_app) !!}) {
                    $("#avso_app").prop("disabled", false);
                } else if (entry['card_id'] == {!!  json_encode(pi_app) !!}) {
                    $("#pi_app").prop("disabled", false);
                }
            }
        });
    }
    function RemoveDissableRequest() {
        //remove disable request
        $.ajax({
            type:'get',
            // url:'/ajax/cek/card/type',
            url:"{{ url('/ajax/cek/card/type') }}",
            success:function(data) {
                console.log('da',data)
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
                    if(data['avso_app'] == true && data['pi_app'] == true){
                        $("#so_app").prop("disabled", false);
                    }else{
                        $("#pi_app").prop("disabled", false);
                        $("#so_app").prop("disabled", false);
                    }
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
