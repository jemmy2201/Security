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
{{--                    <th scope="col">Fee</th>--}}
{{--                    <th scope="col">GST</th>--}}
                    <th scope="col">Amount</th>
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
{{--                    <td>${{$addition_transaction_amount}}</td>--}}
                @else
{{--                    <td>${{$transaction_amount->transaction_amount}}</td>--}}
                @endif
                @php
                    $value_gst = ($gst->amount_gst/100)*$transaction_amount->transaction_amount;
                @endphp
                @php
                    $grand_total = $transaction_amount->transaction_amount + $value_gst;
                     function formatcurrency($floatcurr, $curr = "USD"){
                        $currencies['ARS'] = array(2,',','.');          //  Argentine Peso
                        $currencies['AMD'] = array(2,'.',',');          //  Armenian Dram
                        $currencies['AWG'] = array(2,'.',',');          //  Aruban Guilder
                        $currencies['AUD'] = array(2,'.',' ');          //  Australian Dollar
                        $currencies['BSD'] = array(2,'.',',');          //  Bahamian Dollar
                        $currencies['BHD'] = array(3,'.',',');          //  Bahraini Dinar
                        $currencies['BDT'] = array(2,'.',',');          //  Bangladesh, Taka
                        $currencies['BZD'] = array(2,'.',',');          //  Belize Dollar
                        $currencies['BMD'] = array(2,'.',',');          //  Bermudian Dollar
                        $currencies['BOB'] = array(2,'.',',');          //  Bolivia, Boliviano
                        $currencies['BAM'] = array(2,'.',',');          //  Bosnia and Herzegovina, Convertible Marks
                        $currencies['BWP'] = array(2,'.',',');          //  Botswana, Pula
                        $currencies['BRL'] = array(2,',','.');          //  Brazilian Real
                        $currencies['BND'] = array(2,'.',',');          //  Brunei Dollar
                        $currencies['CAD'] = array(2,'.',',');          //  Canadian Dollar
                        $currencies['KYD'] = array(2,'.',',');          //  Cayman Islands Dollar
                        $currencies['CLP'] = array(0,'','.');           //  Chilean Peso
                        $currencies['CNY'] = array(2,'.',',');          //  China Yuan Renminbi
                        $currencies['COP'] = array(2,',','.');          //  Colombian Peso
                        $currencies['CRC'] = array(2,',','.');          //  Costa Rican Colon
                        $currencies['HRK'] = array(2,',','.');          //  Croatian Kuna
                        $currencies['CUC'] = array(2,'.',',');          //  Cuban Convertible Peso
                        $currencies['CUP'] = array(2,'.',',');          //  Cuban Peso
                        $currencies['CYP'] = array(2,'.',',');          //  Cyprus Pound
                        $currencies['CZK'] = array(2,'.',',');          //  Czech Koruna
                        $currencies['DKK'] = array(2,',','.');          //  Danish Krone
                        $currencies['DOP'] = array(2,'.',',');          //  Dominican Peso
                        $currencies['XCD'] = array(2,'.',',');          //  East Caribbean Dollar
                        $currencies['EGP'] = array(2,'.',',');          //  Egyptian Pound
                        $currencies['SVC'] = array(2,'.',',');          //  El Salvador Colon
                        $currencies['ATS'] = array(2,',','.');          //  Euro
                        $currencies['BEF'] = array(2,',','.');          //  Euro
                        $currencies['DEM'] = array(2,',','.');          //  Euro
                        $currencies['EEK'] = array(2,',','.');          //  Euro
                        $currencies['ESP'] = array(2,',','.');          //  Euro
                        $currencies['EUR'] = array(2,',','.');          //  Euro
                        $currencies['FIM'] = array(2,',','.');          //  Euro
                        $currencies['FRF'] = array(2,',','.');          //  Euro
                        $currencies['GRD'] = array(2,',','.');          //  Euro
                        $currencies['IEP'] = array(2,',','.');          //  Euro
                        $currencies['ITL'] = array(2,',','.');          //  Euro
                        $currencies['LUF'] = array(2,',','.');          //  Euro
                        $currencies['NLG'] = array(2,',','.');          //  Euro
                        $currencies['PTE'] = array(2,',','.');          //  Euro
                        $currencies['GHC'] = array(2,'.',',');          //  Ghana, Cedi
                        $currencies['GIP'] = array(2,'.',',');          //  Gibraltar Pound
                        $currencies['GTQ'] = array(2,'.',',');          //  Guatemala, Quetzal
                        $currencies['HNL'] = array(2,'.',',');          //  Honduras, Lempira
                        $currencies['HKD'] = array(2,'.',',');          //  Hong Kong Dollar
                        $currencies['HUF'] = array(0,'','.');           //  Hungary, Forint
                        $currencies['ISK'] = array(0,'','.');           //  Iceland Krona
                        $currencies['INR'] = array(2,'.',',');          //  Indian Rupee
                        $currencies['IDR'] = array(2,',','.');          //  Indonesia, Rupiah
                        $currencies['IRR'] = array(2,'.',',');          //  Iranian Rial
                        $currencies['JMD'] = array(2,'.',',');          //  Jamaican Dollar
                        $currencies['JPY'] = array(0,'',',');           //  Japan, Yen
                        $currencies['JOD'] = array(3,'.',',');          //  Jordanian Dinar
                        $currencies['KES'] = array(2,'.',',');          //  Kenyan Shilling
                        $currencies['KWD'] = array(3,'.',',');          //  Kuwaiti Dinar
                        $currencies['LVL'] = array(2,'.',',');          //  Latvian Lats
                        $currencies['LBP'] = array(0,'',' ');           //  Lebanese Pound
                        $currencies['LTL'] = array(2,',',' ');          //  Lithuanian Litas
                        $currencies['MKD'] = array(2,'.',',');          //  Macedonia, Denar
                        $currencies['MYR'] = array(2,'.',',');          //  Malaysian Ringgit
                        $currencies['MTL'] = array(2,'.',',');          //  Maltese Lira
                        $currencies['MUR'] = array(0,'',',');           //  Mauritius Rupee
                        $currencies['MXN'] = array(2,'.',',');          //  Mexican Peso
                        $currencies['MZM'] = array(2,',','.');          //  Mozambique Metical
                        $currencies['NPR'] = array(2,'.',',');          //  Nepalese Rupee
                        $currencies['ANG'] = array(2,'.',',');          //  Netherlands Antillian Guilder
                        $currencies['ILS'] = array(2,'.',',');          //  New Israeli Shekel
                        $currencies['TRY'] = array(2,'.',',');          //  New Turkish Lira
                        $currencies['NZD'] = array(2,'.',',');          //  New Zealand Dollar
                        $currencies['NOK'] = array(2,',','.');          //  Norwegian Krone
                        $currencies['PKR'] = array(2,'.',',');          //  Pakistan Rupee
                        $currencies['PEN'] = array(2,'.',',');          //  Peru, Nuevo Sol
                        $currencies['UYU'] = array(2,',','.');          //  Peso Uruguayo
                        $currencies['PHP'] = array(2,'.',',');          //  Philippine Peso
                        $currencies['PLN'] = array(2,'.',' ');          //  Poland, Zloty
                        $currencies['GBP'] = array(2,'.',',');          //  Pound Sterling
                        $currencies['OMR'] = array(3,'.',',');          //  Rial Omani
                        $currencies['RON'] = array(2,',','.');          //  Romania, New Leu
                        $currencies['ROL'] = array(2,',','.');          //  Romania, Old Leu
                        $currencies['RUB'] = array(2,',','.');          //  Russian Ruble
                        $currencies['SAR'] = array(2,'.',',');          //  Saudi Riyal
                        $currencies['SGD'] = array(2,'.',',');          //  Singapore Dollar
                        $currencies['SKK'] = array(2,',',' ');          //  Slovak Koruna
                        $currencies['SIT'] = array(2,',','.');          //  Slovenia, Tolar
                        $currencies['ZAR'] = array(2,'.',' ');          //  South Africa, Rand
                        $currencies['KRW'] = array(0,'',',');           //  South Korea, Won
                        $currencies['SZL'] = array(2,'.',', ');         //  Swaziland, Lilangeni
                        $currencies['SEK'] = array(2,',','.');          //  Swedish Krona
                        $currencies['CHF'] = array(2,'.','\'');         //  Swiss Franc
                        $currencies['TZS'] = array(2,'.',',');          //  Tanzanian Shilling
                        $currencies['THB'] = array(2,'.',',');          //  Thailand, Baht
                        $currencies['TOP'] = array(2,'.',',');          //  Tonga, Paanga
                        $currencies['AED'] = array(2,'.',',');          //  UAE Dirham
                        $currencies['UAH'] = array(2,',',' ');          //  Ukraine, Hryvnia
                        $currencies['USD'] = array(2,'.',',');          //  US Dollar
                        $currencies['VUV'] = array(0,'',',');           //  Vanuatu, Vatu
                        $currencies['VEF'] = array(2,',','.');          //  Venezuela Bolivares Fuertes
                        $currencies['VEB'] = array(2,',','.');          //  Venezuela, Bolivar
                        $currencies['VND'] = array(0,'','.');           //  Viet Nam, Dong
                        $currencies['ZWD'] = array(2,'.',' ');          //  Zimbabwe Dollar

                        function formatinr($input){
                            //CUSTOM FUNCTION TO GENERATE ##,##,###.##
                            $dec = "";
                            $pos = strpos($input, ".");
                            if ($pos === false){
                                //no decimals
                            } else {
                                //decimals
                                $dec = substr(round(substr($input,$pos),2),1);
                                $input = substr($input,0,$pos);
                            }
                            $num = substr($input,-3); //get the last 3 digits
                            $input = substr($input,0, -3); //omit the last 3 digits already stored in $num
                            while(strlen($input) > 0) //loop the process - further get digits 2 by 2
                            {
                                $num = substr($input,-2).",".$num;
                                $input = substr($input,0,-2);
                            }
                            return $num . $dec;
                        }


                        if ($curr == "INR"){
                            return formatinr($floatcurr);
                        } else {
                            return number_format($floatcurr,$currencies[$curr][0],$currencies[$curr][1],$currencies[$curr][2]);
                        }
                    }
                    $grand_total = formatcurrency($grand_total);
                @endphp
{{--                    <td>{{$gst->amount_gst}}%</td>--}}
                    <td>${{$grand_total}} inclusive GST</td>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <h2>Payment Mode</h2><br>
     <div class="row hidden-xs">
         <div class="col-2">
         </div>
         <div class="col-4">
             <h3>Select Your Payment Method</h3><br>
         </div>
     </div>
    <div class="row hidden-xs">
        <div class="col-2">
        </div>
        <div class="col-10">
            <img src="{{URL::asset('/img/payment_icon/paynow.jpeg')}}" data-toggle="modal" data-target="#Form_payment_paynow" id="paynow" style="width: 15%; margin-left: -30px;"><br class="visible-xs hidden-md"><br class="visible-xs hidden-md">
            <img  src="{{URL::asset('/img/payment_icon/enets.png')}}" id="enets" style="width: 15%; margin-left: 60px;">
        </div>
    </div>
    <div class="visible-xs hidden-md">
        <h3>Select Your Payment Method</h3><br>
        <img src="{{URL::asset('/img/payment_icon/paynow.jpeg')}}" data-toggle="modal" data-target="#Form_payment_paynow" id="paynow" style="width: 35%;"><br class="visible-xs hidden-md"><br class="visible-xs hidden-md">
        <img  src="{{URL::asset('/img/payment_icon/enets.png')}}" id="phone_enets" style="width: 35%;">
    </div>
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
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
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
                    <h4 class="modal-title">Barcode paynow</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <center>
                        <img src="{{URL::asset('/img/payment_icon/paynow.jpeg')}}" style=" position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%); width: 70px;">
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

    <form id="eNETSRedirectForm" name="eNETSRedirectForm"  action={{ ApiurlEnets }} method='POST' style="display: none;">
        <textarea rows="8" cols="126" name="payload" id="payload" form="eNETSRedirectForm" form="usrform"></textarea>
        <br>
        <input type="text" id="apiKey" name="apiKey" value={{ secretIDEnets }} size="130">
        <br>
        <input type="text" id="hmac" name="hmac"  size="130">
        <br>
        <input type='submit' name="submit_enets" id="submit_enets" >
    </form>

    <div class="row hidden-xs">
        <div class="col-2 back">
            <button type="submit" class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: #1E90FF; color: #E31D1A" onclick="window.history.go(-1); return false;">
                <a href="#" style="text-decoration:none; color: white;">
                    {{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;">--}}
                    Back
                </a>
            </button>
        </div>
        <div class="col-6 medium ">
        </div>
        <div class="col-2 next">
        </div>
        <div class="col-2 next">
            <button class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: #1E90FF; color: #E31D1A">
                <a href="{{url('/save_draft/'.$request->app_type.'/'.$request->card.'/'.draft.'/'.draft)}}" style="text-decoration:none; color: white;">
                    {{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;">--}}
                    Save Draft
                </a>
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col-4 back Visible-xs hidden-md">
            <button type="submit" class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: #1E90FF; color: #E31D1A" onclick="window.history.go(-1); return false;">
                <a href="#" style="text-decoration:none;color: white;">
                    {{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;"> --}}
                    Back
                </a>
            </button>
        </div>
        <div class="col-4  visible-xs hidden-md">

        </div>
        <div class="col-4 visible-xs hidden-md">
            <button class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: #1E90FF; color: #E31D1A">
                <a href="{{url('/save_draft/'.$request->app_type.'/'.$request->card.'/'.draft)}}" style="text-decoration:none; color: white;">
                    {{--                    <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;">--}}
                    Save Draft
                </a>
            </button>
        </div>
    </div>


</div>
<script src="https://unpkg.com/paynowqr@latest/dist/paynowqr.min.js"></script>
<script>
    $( document ).ready(function() {
        //Create a PaynowQR object
        let qrcode = new PaynowQR({
            uen: {!!  json_encode(uen) !!},           //Required: UEN of company
            {{--amount : {!!  json_encode(preg_replace("/[.]/", "", $grand_total)) !!},               //Specify amount of money to pay.--}}
            amount :"1",               //Specify amount of money to pay.
            editable: true,             //Whether or not to allow editing of payment amount. Defaults to false if amount is specified
            expiry: {!!  json_encode( date("Ymd")) !!},         //Set an expiry date for the Paynow QR code (YYYYMMDD). If omitted, defaults to 5 years from current time.
            refNumber: {!!  json_encode(refNumber) !!} + " " +{!!  json_encode( $booking_schedule->receiptNo) !!},   //Reference number for Paynow Transaction. Useful if you need to track payments for recouncilation.
            // refNumber: "Website Testing reference number",   //Reference number for Paynow Transaction. Useful if you need to track payments for recouncilation.
            company:  'ACME Pte Ltd.'   //Company name to embed in the QR code. Optional.
        });

        //Outputs the qrcode to a UTF-8 string format, which can be passed to a QR code generation script to generate the paynow QR
        let QRstring = qrcode.output();
        new QRCode(document.getElementById("qrcodePaynow"), QRstring)
    });

    $( document ).ready(function() {
        $("#confirm_payment_enets").click(function() {
            if ($("#card_holder_name").val() && $("#card_number").val() &&  $("#month").val() != false &&  $("#year").val() != false &&  $("#ccv_number").val()) {
                var Enets = enets();
                {{--Enets.onreadystatechange = function() {--}}
                {{--    if (this.readyState == 4 && this.status == 200 ) {--}}
                {{--        var StatusEnets = jQuery.parseJSON(this.response);--}}
                {{--        console.log('status',StatusEnets['msg'])--}}
                {{--        if(StatusEnets['msg']['netsTxnStatus'] == {!!  json_encode(success) !!}){--}}
                {{--            // $( "#save_payment").submit();--}}
                {{--        }else{--}}
                {{--            swal("Payment Failed !", "Please try again", "error")--}}
                {{--        }--}}
                {{--    }else{--}}
                {{--        swal("Payment Failed !", "Connection lost, Please try again", "error")--}}
                {{--    }--}}
                {{--};--}}
            }else{
                swal("Please!", "Complete the data", "error")
            }
        });
        $(".logout_save_draft").click(function() {
            $("#logout_save_draft").val(true)
            window.location.href ='/save_draft/'+{!! json_encode($request->app_type) !!}+'/'+{!! json_encode($request->card) !!}+'/'+{!! json_encode(draft) !!}+'/'+ $("#logout_save_draft").val();
        });
        $("#confirm_payment_paynow").click(function() {
           $( "#save_payment").submit();
        });
        $("#enets").click(function() {
            {{--$("#payment_method").val({!!  json_encode(enets) !!})--}}
            enets();
        });
        $("#phone_enets").click(function() {
            {{--$("#payment_method").val({!!  json_encode(enets) !!})--}}
            enets();
        });
        $("#paynow").click(function() {
            $("#payment_method").val({!!  json_encode(paynow) !!})
        });

    });
    function paynow() {
    }
    function expiryDate() {
        if ($("#year").val() == "1"){
            var expiryDateY = {!!  json_encode(date('y', strtotime('+1 years'))) !!};
        }else if ($("#year").val() == "2"){
            var expiryDateY = {!!  json_encode(date('y', strtotime('+2 years'))) !!};
        }else if ($("#year").val() == "3"){
            var expiryDateY = {!!  json_encode(date('y', strtotime('+3 years'))) !!};
        }else if ($("#year").val() == "4"){
            var expiryDateY = {!!  json_encode(date('y', strtotime('+4 years'))) !!};
        }else if ($("#year").val() == "5"){
            var expiryDateY = {!!  json_encode(date('y', strtotime('+5 years'))) !!};
        }
        return expiryDateY + $("#month").val();
    }
    function enets(){
        var Val_b2sTxnEndURLParam = {"nric":{!!  json_encode(Auth::user()->nric) !!},"app_type":{!!  json_encode( $booking_schedule->app_type) !!},"card":{!!  json_encode( $booking_schedule->card_id) !!},"grand_total":{!!  json_encode( $grand_total) !!},"transaction_amount_id":{!!  json_encode($transaction_amount->id) !!},"grade_id":{!!  json_encode($gst->id) !!}};
        var b2sTxnEndURLParam = JSON.stringify(Val_b2sTxnEndURLParam);
        var data = {"ss":"1","msg":{"netsMid":{!!  json_encode(netsMid) !!},"tid":"","submissionMode":"B","txnAmount":{!!  json_encode(preg_replace("/[.]/", "", $grand_total)) !!},"merchantTxnRef":{!!  json_encode(date("Ymdhis")) !!},"merchantTxnDtm":{!!  json_encode(date("Ymd h:i:s.v")) !!},"paymentType":"SALE","currencyCode":"SGD","paymentMode":"","merchantTimeZone":"+8:00","b2sTxnEndURL":{!!  json_encode(b2sTxnEndURL) !!},"b2sTxnEndURLParam":b2sTxnEndURLParam,"s2sTxnEndURL":{!!  json_encode(s2sTxnEndURL) !!},"s2sTxnEndURLParam":"","clientType":"W","supMsg":"","netsMidIndicator":"U","ipAddress":{!!  json_encode(Merchant_server_IP_Address) !!},"language":"en"}};
        {{--var data = {"ss":"1","msg":{"netsMid":{!!  json_encode(netsMid) !!},"tid":"","submissionMode":"B","txnAmount":{!!  json_encode(preg_replace("/[.]/", "", $grand_total)) !!},"merchantTxnRef":{!!  json_encode(date("Ymd h:i:s")) !!} + "" +{!!  json_encode( $booking_schedule->receiptNo) !!},"merchantTxnDtm":{!!  json_encode(date("Ymd h:i:s.v")) !!},"paymentType":"SALE","currencyCode":"SGD","paymentMode":"","merchantTimeZone":"+8:00","b2sTxnEndURL":{!!  json_encode(b2sTxnEndURL) !!},"b2sTxnEndURLParam":b2sTxnEndURLParam,"s2sTxnEndURL":{!!  json_encode(s2sTxnEndURL) !!},"s2sTxnEndURLParam":"","clientType":"W","supMsg":"","netsMidIndicator":"U","ipAddress":{!!  json_encode(Merchant_server_IP_Address) !!},"language":"en"}};--}}
        var txnreq = JSON.stringify(data);
        var secretKey = {!!  json_encode(secretKeyEnets) !!};
        $("#payload").val(txnreq);
        var sign = btoa(sha256(txnreq + secretKey).match(/\w{2}/g).map(function (a) {
            return String.fromCharCode(parseInt(a, 16));
        }).join(''));
        $("#hmac").val(sign);

        document.getElementById("submit_enets").click();
    }
    //refresh page on browser resize
    $(window).bind('resize', function(e)
    {
        this.location.reload(false); /* false to get page from cache */
        /* true to fetch page from server */
    });

</script>
@endsection
