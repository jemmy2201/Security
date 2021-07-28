@extends('layouts.app')
<style>
    table {
        width: 100%;
    }

    th {
        height: 50px;
    }
</style>
@section('content')
<div class="container">
    <img class="hidden-xs" src="{{URL::asset('/img/img_step_proses/5.png')}}" style="width: 100%;margin-bottom: 20px;">
    <center class="visible-xs hidden-md">
        <img  src="{{URL::asset('/img/img_step_proses/design_phone/5.png')}}" style="width: 80%;">
    </center>
    <h2 style="color: #E31E1A;">Payment Details</h2>
    <br>
        @csrf
    <div class="row">
        <div class="col payment_method" style="border-style: groove;">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Application Type</th>
                    <th scope="col" >Type</th>
{{--                    <th scope="col">Invoice</th>--}}
                    <th scope="col">Fee</th>
                    <th scope="col">GST</th>
                    <th scope="col">Total</th>
                </tr>
                </thead>
                @if($booking_schedule->app_type == news)
                    <td>New</td>
                @elseif($booking_schedule->app_type == replacement)
                    <td>Replacement</td>
                @elseif($booking_schedule->app_type == renewal)
                    <td>Renewal</td>
                @endif
                @if($booking_schedule->card_id == so_app)
                    <td>SO Application</td>
                @elseif($booking_schedule->card_id == avso_app)
                    <td>AVSO Application</td>
                @elseif($booking_schedule->card_id == pi_app)
                    <td>PI Application</td>
                @endif
{{--                <td>${{$booking_schedule->rece}}</td>--}}
                @if(!empty($addition_transaction_amount))
                    <td>${{$addition_transaction_amount}}</td>
                @else
                    <td>${{$transaction_amount->transaction_amount}}</td>
                @endif
                @php
                    $value_gst = ($gst->amount_gst/100)*$transaction_amount->transaction_amount;
                @endphp
                @php
                    $grand_total = $transaction_amount->transaction_amount + $value_gst;
                @endphp
                    <td>{{$gst->amount_gst}}%</td>
                    <td>${{$grand_total}}</td>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <h3>Select Payment By</h3>
    <img  src="{{URL::asset('/img/payment_icon/enets.png')}}" data-toggle="modal" data-target="#Form_payment" id="enets" style="width: 15%; margin-right: 20px;">
    <img src="{{URL::asset('/img/payment_icon/paynow.jpeg')}}" data-toggle="modal" data-target="#Form_payment_paynow" id="paynow" style="width: 15%;"><br class="visible-xs hidden-md"><br class="visible-xs hidden-md">

    <input type="hidden" name="card" id="card" value="{{$request->card}}">

    <br><br class="hidden-xs"><br class="hidden-xs">

    <!-- Modal Enets -->
    <div class="modal fade" id="Form_payment" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Form payment</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="post" id="save_payment" action="{{ route('save.payment') }}" >
                        @csrf
                        <input type="hidden" name="card" id="card" value="{{$request->card}}">
                        <input type="hidden" name="grade_id" id="grade_id" value="{{$gst->id}}">
                        <input type="hidden" name="transaction_amount_id" id="transaction_amount_id" value="{{$transaction_amount->id}}">
                        <input type="hidden" name="grand_gst" id="grand_gst" value="{{$gst}}">
                        <input type="hidden" name="grand_total" id="grand_total" value="{{$grand_total}}">
                        <input type="hidden" id="payment_method" name="payment_method">
                        <div class="row">
                        <div class="col payment_method" >
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
                    </div>
                    </form>

                </div>
                <div class="modal-footer">
                    @php $url_cancel=url("/cancel/payment")."/".$booking_schedule->app_type."/".$booking_schedule->card_id; @endphp
                    <a href="{{ $url_cancel }}" style="color: inherit; text-decoration: none;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </a>
                    <button type="button" id="confirm_payment_enets" class="btn btn-danger" data-dismiss="modal">Confirm</button>
                </div>
            </div>

        </div>
    </div>
    <!-- End Modal Enets -->
    <!-- Modal Paynow -->
    <div class="modal fade" id="Form_payment_paynow" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Barcode payment</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <center>
                    <div id="qrcodePaynow"></div>
                    </center>
                </div>
                <div class="modal-footer">
                    @php $url_cancel=url("/cancel/payment")."/".$booking_schedule->app_type."/".$booking_schedule->card_id; @endphp
                    <a href="{{ $url_cancel }}" style="color: inherit; text-decoration: none;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </a>
                    <button type="button" id="confirm_payment_paynow" class="btn btn-danger" data-dismiss="modal">Confirm</button>
                </div>
            </div>

        </div>
    </div>
    <!-- End Modal Paynow -->
</div>
<script src="https://unpkg.com/paynowqr@latest/dist/paynowqr.min.js"></script>
<script>
    $( document ).ready(function() {
        //Create a PaynowQR object
        let qrcode = new PaynowQR({
            uen:'201403121W',           //Required: UEN of company
            amount : 500,               //Specify amount of money to pay.
            editable: true,             //Whether or not to allow editing of payment amount. Defaults to false if amount is specified
            expiry: '20201231',         //Set an expiry date for the Paynow QR code (YYYYMMDD). If omitted, defaults to 5 years from current time.
            refNumber: 'TQINV-10001',   //Reference number for Paynow Transaction. Useful if you need to track payments for recouncilation.
            company:  'ACME Pte Ltd.'   //Company name to embed in the QR code. Optional.
        });

        //Outputs the qrcode to a UTF-8 string format, which can be passed to a QR code generation script to generate the paynow QR
        let QRstring = qrcode.output();
        console.log('jrg',QRstring)
        new QRCode(document.getElementById("qrcodePaynow"), QRstring)
    });
</script>
<script type="application/javascript">
    $( document ).ready(function() {
        $("#confirm_payment_enets").click(function() {
            if ($("#card_holder_name").val() && $("#card_number").val() &&  $("#month").val() != false &&  $("#year").val() != false &&  $("#ccv_number").val()) {
                // enets();
                $( "#save_payment").submit();
            }else{
                swal("Please!", "Complete the data", "error")
            }
            {{--if ($("#card_holder_name").val() && $("#card_number").val() &&  $("#month").val() != false &&  $("#year").val() != false &&  $("#ccv_number").val()){--}}
            {{--    if($("#payment_method").val() == {!!  json_encode(enets) !!}){--}}
            {{--        // enets();--}}
            {{--    }else if($("#payment_method").val() == {!!  json_encode(paynow) !!}){--}}
            {{--        // paynow()--}}
            {{--    }--}}
            {{--    $( "#save_payment").submit();--}}
            {{--}else{--}}
            {{--    swal("Please!", "Complete the data", "error")--}}
            {{--}--}}
        });

        $("#confirm_payment_paynow").click(function() {
            console.log('s')
           $( "#save_payment").submit();
        });
        $("#enets").click(function() {
            $("#payment_method").val({!!  json_encode(enets) !!})
        });
        $("#paynow").click(function() {
            $("#payment_method").val({!!  json_encode(paynow) !!})
        });

    });
    function paynow() {
    }
    function enets(){
        var data = {"ss":"1","msg":{"netsMid":{!!  json_encode(netsMid) !!},"tid":"","submissionMode":"B","txnAmount":{!!  json_encode(preg_replace("/[.]/", "", $grand_total)) !!},"merchantTxnRef":$("#card_number").val(),"merchantTxnDtm":{!!  json_encode(date("Ymd h:i:s.u")) !!},"paymentType":"SALE","currencyCode":"SGD","paymentMode":"","merchantTimeZone":"+8:00","b2sTxnEndURL":"https://httpbin.org/post","b2sTxnEndURLParam":"","s2sTxnEndURL":"https://sit2.enets.sg/MerchantApp/rest/s2sTxnEnd","s2sTxnEndURLParam":"","clientType":"W","supMsg":"","netsMidIndicator":"U","ipAddress":{!!  json_encode(Merchant_server_IP_Address) !!},"language":"en"}};
        var txnreq = JSON.stringify(data);
        console.log('jrg',data)
        var secretKey = {!!  json_encode(secretKeyEnets) !!};
        var sign = btoa(sha256(txnreq + secretKey).match(/\w{2}/g).map(function (a) {
            return String.fromCharCode(parseInt(a, 16));
        }).join(''));

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log('sukses',this.responseText)
            }
        };
        xhttp.open("POST", "https://api.nets.com.sg/GW2/TxnQuery", true);
        xhttp.setRequestHeader("Content-type", "application/json");
        xhttp.setRequestHeader("keyId", {!!  json_encode(secretIDEnets) !!});
        xhttp.setRequestHeader("hmac", sign);
        xhttp.send(txnreq);
    }
    //refresh page on browser resize
    $(window).bind('resize', function(e)
    {
        this.location.reload(false); /* false to get page from cache */
        /* true to fetch page from server */
    });

</script>
@endsection
