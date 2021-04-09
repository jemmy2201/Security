@extends('layouts.app')

<style>
    .Listpaymentmenthod{
        font-size: 18px;
    }
</style>
@section('content')
<div class="container">
    <img src="{{URL::asset('/img/img_step_proses/5.png')}}" style="width: 100%;margin-bottom: 20px;">
    <h2 style="color: #E31E1A;">Payment Details</h2>
    <br>
    <form method="post" id="save_payment" action="{{ route('save.payment') }}" >
        @csrf
    <div class="row">
        <div class="col payment_method" style="border-style: groove;">
            <h3><b>Payment Method</b></h3><br>
            <div class="row" >
                <div class="col-3 VPpaynow Listpaymentmenthod">
                    <button type="button" class="btn btn-secondary btn-lg" id="payment" style="border-style: groove;" value="@php echo paynow;@endphp">PayNow</button>
                </div>
                <div class="col-3 VPenets Listpaymentmenthod">
                    <button type="button" class="btn btn-secondary btn-lg" id="enets" style="border-style: groove;" value="@php echo enets;@endphp">eNets</button>
                </div>
                <div class="col-3 VPvisa Listpaymentmenthod">
                    <button type="button" class="btn btn-secondary btn-lg" id="visa" style="border-style: groove;" value="@php echo visa;@endphp">Visa</button>
                </div>
                <div class="col-3 VPmaster Listpaymentmenthod" >
                    <button type="button" class="btn btn-secondary btn-lg" id="master" style="border-style: groove;" value="@php echo mastercard;@endphp">Mastercard</button>
                </div>
                <input type="hidden" id="payment_method" name="payment_method">
            </div><br>
            <div class="row">
                <div class="col-6">
                    <p style="color:#808080;">Cardholder name</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <input type="text" class="form-control" id="card_holder_name" name="card_holder_name"  placeholder="XXXXXX" required>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6">
                    <p style="color:#808080;">Card Number</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <input type="text" class="form-control" id="card_number" name="card_number"  placeholder="000000" required>
                </div>
            </div><br>
            <div class="row">
                <div class="col">Month</div>
                <div class="col">Year</div>
                <div class="col">CCV</div>
                <div class="w-100"></div>
                <div class="col">
                    <select class="form-control" name="month" id="month" required>
                        <option value="0" selected>please choose</option>
                        <option value="1">01</option>
                        <option value="2">02</option>
                        <option value="3">03</option>
                        <option value="4">04</option>
                        <option value="5">05</option>
                        <option value="6">06</option>
                        <option value="7">07</option>
                        <option value="8">08</option>
                        <option value="9">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>
                <div class="col">
                    @php
                        $end = date('Y', strtotime('+5 years'));
                    @endphp
                    <select class="form-control" id="year" name="year" required>
                        <option value="0" selected>please choose</option>
                        <option value="1">@php echo date('Y', strtotime('+1 years')) @endphp</option>
                        <option value="2">@php echo date('Y', strtotime('+2 years')) @endphp</option>
                        <option value="3">@php echo date('Y', strtotime('+3 years')) @endphp</option>
                        <option value="4">@php echo date('Y', strtotime('+4 years')) @endphp</option>
                        <option value="5">@php echo date('Y', strtotime('+5 years')) @endphp</option>
                    </select>
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="ccv_number" name="ccv_number"  placeholder="000000" required>
                </div>
            </div><br><br>
        </div>
        <div class="col-4 hidden-xs">
            <div class="row" style="border-style: groove;">
                <div class="col">
                    <h3><b>Summary</b></h3>
                    <div class="row">
                        <div class="col-4">Aplication :</div>
                        @if($booking_schedule->app_type == news)
                            <div class="col">New</div>
                        @elseif($booking_schedule->app_type == replacement)
                            <div class="col">Replacement</div>
                        @else
                            <div class="col">Renewal</div>
                        @endif
                        <div class="w-100"></div>
                        <div class="col-4">Type :</div>
                        @if($booking_schedule->card_id == so_app)
                            <div class="col">SO/SSO/SSS</div>
                        @elseif($booking_schedule->card_id == avso_app)
                            <div class="col">AVSO</div>
                        @else
                            <div class="col">PI</div>
                        @endif
                        <div class="w-100"></div>
                        <div class="col-4">Fee :</div>
                        <div class="col">${{$transaction_amount->transaction_amount}}</div>
                        <div class="w-100"></div>
                        <div class="col-4">GST ({{$gst->amount_gst}}%) :</div>
                        <input type="hidden" name="grade_id" id="grade_id" value="{{$gst->id}}">
                        <input type="hidden" name="transaction_amount_id" id="transaction_amount_id" value="{{$transaction_amount->id}}">
                        @php
                            $gst = ($gst->amount_gst/100)*$transaction_amount->transaction_amount;
                        @endphp
                        <input type="hidden" name="grand_gst" id="grand_gst" value="{{$gst}}">
                        <div class="col">${{$gst}}</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-4">
                            <h4><b>Total</b></h4>
                            <p style="color: #808080">(incl.GSTI)</p>
                        </div>
                        <div class="col">
                            @php
                                $grand_total = $transaction_amount->transaction_amount + $gst;
                            @endphp
                            <input type="hidden" name="grand_total" id="grand_total" value="{{$grand_total}}">
                            <h4>{{$grand_total}}</h4>
                        </div>
                    </div>
                </div>
            </div><br>
            <div class="row">
                <div class="col">
                    <button type="button" id="create_payment" class="btn btn-danger btn-lg btn-block" >Confirm <img src="{{URL::asset('/img/next.png')}}" style="width: 5%;"></button>
                </div>
            </div>
        </div>
    </div>
    <div class="row visible-xs hidden-md" style="border-style: groove;">
        <div class="col">
            <h3><b>Summarry</b></h3>
            <div class="row">
                <div class="col-4">Aplication :</div>
                @if($booking_schedule->app_type == news)
                    <div class="col">New</div>
                @elseif($booking_schedule->app_type == replacement)
                    <div class="col">Replacement</div>
                @else
                    <div class="col">Renewal</div>
                @endif
                <div class="w-100"></div>
                <div class="col-4">Type :</div>
                @if($booking_schedule->card_id == so_app)
                    <div class="col">SO/SSO/SSS</div>
                @elseif($booking_schedule->card_id == avso_app)
                    <div class="col">Replacement</div>
                @else
                    <div class="col">Renewal</div>
                @endif
                <div class="w-100"></div>
                <div class="col-4">Fee :</div>
                <div class="col">$12</div>
                <div class="w-100"></div>
                <div class="col-4">GST (7%) :</div>
                <div class="col">$0.8</div>
            </div>
            <hr>
            <div class="row">
                <div class="col-4">
                    <h4><b>Total</b></h4>
                    <p style="color: #808080">(incl.GSTI)</p>
                </div>
                <div class="col">
                    <h4>$128</h4>
                </div>
            </div>
        </div>
    </div><br class="visible-xs hidden-md">
    <div class="row visible-xs hidden-md">
        <div class="col">
            <button type="button"  class="btn btn-danger btn-lg btn-block create_payment" >Confirm <img src="{{URL::asset('/img/next.png')}}" style="width: 5%;"></button>
        </div>
    </div>
    <br><br class="hidden-xs"><br class="hidden-xs">
    </form>
</div>
<script type="application/javascript">
    $( document ).ready(function() {
        $("#create_payment").click(function() {
            if ($('#payment_method').val() && $("#card_holder_name").val() && $("#card_number").val() &&  $("#month").val() != false &&  $("#year").val() != false &&  $("#ccv_number").val()){
                $( "#save_payment" ).submit();
            }else{
                swal("Please!", "Complete the data", "error")
            }
        });
        $(".create_payment").click(function() {
            if ($('#payment_method').val() && $("#card_holder_name").val() && $("#card_number").val() &&  $("#month").val() != false &&  $("#year").val() != false &&  $("#ccv_number").val()){
                $( "#save_payment" ).submit();
            }else{
                swal("Please!", "Select a payment method", "error")
            }
        });
    });

    //refresh page on browser resize
    $(window).bind('resize', function(e)
    {
        this.location.reload(false); /* false to get page from cache */
        /* true to fetch page from server */
    });
    if($(window).width() < 767)
    {
        RemoveColNextBack();
        $(".payment_method").addClass("col-12");
        $(".VPenets").addClass("col-2");
        $(".VPvisa").addClass("col-2");
        $(".VPmaster").addClass("col-2");
    }
    function RemoveColNextBack() {
        $(".payment_method").removeClass("co");
        $(".VPenets").removeClass("col-3");
        $(".VPvisa").removeClass("col-3");
        $(".VPmaster").removeClass("col-3");
        $("#enets").removeClass("btn-lg");
        $("#visa").removeClass("btn-lg");
        $("#master").removeClass("btn-lg");
        $("#payment").removeClass("btn-lg");
    }
    $(document).ready(function() {

        $("#payment").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#enets").addClass('btn-secondary').removeClass('btn-danger ');
            $("#visa").addClass('btn-secondary').removeClass('btn-danger ');
            $("#master").addClass('btn-secondary').removeClass('btn-danger ');
            $("#payment_method").val(document.getElementById("payment").value);
        });
        $("#enets").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#payment").addClass('btn-secondary').removeClass('btn-danger ');
            $("#visa").addClass('btn-secondary').removeClass('btn-danger ');
            $("#master").addClass('btn-secondary').removeClass('btn-danger ');
            $("#payment_method").val(document.getElementById("enets").value);
        });
        $("#visa").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#payment").addClass('btn-secondary').removeClass('btn-danger ');
            $("#enets").addClass('btn-secondary').removeClass('btn-danger ');
            $("#master").addClass('btn-secondary').removeClass('btn-danger ');
            $("#payment_method").val(document.getElementById("visa").value);
        });
        $("#master").click(function() {
            $(this).addClass('btn-danger').removeClass('btn-secondary ');
            $("#payment").addClass('btn-secondary').removeClass('btn-danger ');
            $("#enets").addClass('btn-secondary').removeClass('btn-danger ');
            $("#visa").addClass('btn-secondary').removeClass('btn-danger ');
            $("#payment_method").val(document.getElementById("master").value);
        });
    });

</script>
@endsection
