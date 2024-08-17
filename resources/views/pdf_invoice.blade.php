<!DOCTYPE html>
<html>
<head>
    <title>PDF_Screen Shot.pdf</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        /* Create four equal columns that floats next to each other */
        .column {
            float: right;
            width: 100%;
            padding: 15px;
            /*height: 300px; !* Should be removed. Only for demonstration *!*/
        }
        .column2{
            display: inline-block;
            width: 200%;
            /*height: 300px; !* Should be removed. Only for demonstration *!*/
        }
        .column-left {
            float: left;
            width: 30%;
        }

        .column-right {
            float: right;
            width: 86%;
            font-weight: bold;
        }
        .column-right-border {
            float: right;
            width: 68%;
            font-weight: bold;
        }
        .column-right-paynow {
            float: right;
            width: 79%;
            font-weight: bold;
        }
        .column-center {
            display: inline-block;
            padding-left: 12%;
            padding-top: 5px;
            width: 30%;
        }
        .column-center-border {
            display: inline-block;
            padding-left: 28%;
            width: 30%;
            margin-top: 3px;
        }
        .column-right-left {
            float: right;
            width: 47%;
        }

        .column-right-right {
            float: right;
            width: 34%;
            font-weight: bold;
        }

        .column-right-center {
            display: inline-block;
            padding-left: 22%;
            padding-top: 5px;
            width: 30%;
        }
        .column-right-center2 {
            display: inline-block;
            padding-left: 62%;
            padding-top: 5px;
            width: 30%;
        }
        .column-right-center3 {
            display: inline-block;
            padding-left: 97%;
            padding-top: 5px;
            width: 10%;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
        .text_big {
            font-size: 20px;
        }

    </style>
</head>
<body>

<div style="margin-top:30px; margin-left:45px;">
        <h4 style="color: black;">ID Card Application Details</h4>
        {{--        <h6><b>Details</b></h6>--}}
</div>
<div style="margin-top:-40px; margin-left:86%;">
    <h4>Date :<?php echo date('d/m/Y'); ?></h4>
</div>
@php
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
@endphp
<div class="column text_big " style="z-index: 0; position: absolute;right: 0;top: 0;margin-right:2%;width:40%;">
    <div class="column"  style="margin-top:5%;border: 5px solid gray;">

        <div class="column-center-border">:</div>
        <div class="column-left">Collection At</div>
        <div class="column-right-border">UNION OF SECURITY EMPLOYEESS</div>
        <br>
        <div class="column-center-border"></div>
        <div class="column-left"></div>
        <div class="column-right-border">200 Jalan Sultan</div>
        <br>
        <div class="column-center-border"></div>
        <div class="column-left"></div>
        <div class="column-right-border">#03-24 Textile Centre</div>
        <br>
        <div class="column-center-border"></div>
        <div class="column-left"></div>
        <div class="column-right-border">Singapore 199018</div>
        <br>
        <div class="column-center-border">:</div>
        <div class="column-left">Collection Date</div>
        @php
            $date_appointment=date_create($courses->appointment_date);
        @endphp

        <div class="column-right-border">{{ date_format($date_appointment,"d F Y")}}</div>
        <br>
        <div class="column-center-border">:</div>
        <div class="column-left">Time Slot</div>
        <div class="column-right-border">{{ $courses->time_start_appointment}} - {{$courses->time_end_appointment}}</div>
    </div>
</div>
<div class="text_big" style="margin-left:2px;">
    <div class="column" style="margin-left:30px;">
        @php
            $nric = secret_decode($courses->nric);
            $cutnric = substr($nric, -4);
            $nric = "XXXXX$cutnric";
        @endphp
        <div class="column-center">:</div>
        <div class="column-left">NRIC / FIN</div>
        <div class="column-right">{{$nric}}</div>
        {{--        <div class="column-right-center">:</div>--}}
        {{--        <div class="column-right-left">Pass ID No</div>--}}
        {{--        <div class="column-right-right">{{substr($courses->passid, 0, -2)}}</div>--}}
        <br>
        <div class="column-center">:</div>
        <div class="column-left">Name</div>
        @if (strlen($courses->name) >= 40)
            <div class="column-right">
                @php
                    echo wordwrap($courses->name,30,"<br>\n");
                @endphp
            </div>
            {{--            <div class="column-right-center">:</div>--}}
            {{--            <div class="column-right-left">Card Type</div>--}}
            {{--            <div class="column-right-right">--}}
            {{--                @if($courses->app_type == news)--}}
            {{--                    NEW--}}
            {{--                @elseif($courses->app_type == replacement)--}}
            {{--                    REPLACEMENT--}}
            {{--                @elseif($courses->app_type == renewal)--}}
            {{--                    RENEWAL--}}
            {{--                @endif--}}
            {{--                ---}}
            {{--                @if($courses->card_id == so_app)--}}
            {{--                    SO--}}
            {{--                @elseif($courses->card_id == avso_app)--}}
            {{--                    AVSO--}}
            {{--                @elseif($courses->card_id == pi_app)--}}
            {{--                    PI--}}
            {{--                @endif--}}
            {{--            </div>--}}
            <br>
            <div class="column-right-center2">&nbsp;:</div>
            <div class="column-right-left">Grade</div>
            <div class="column-right-right">
                @if ($request->card == so_app)
                    @foreach($t_grade as $index =>$f)
                        @if(!empty($courses) && $courses->grade_id== $f->id)
                            {{$f->name}}
                        @endif
                    @endforeach
                @elseif($request->card == avso_app)
                    NA
                @else
                    NA
                @endif
            </div>
        @endif
        @if (strlen($courses->name) <= 40)
            <div class="column-right">{{$courses->name}}</div>
            {{--            <div class="column-right-center">:</div>--}}
            {{--            <div class="column-right-left">Card Type</div>--}}
            {{--            <div class="column-right-right">--}}
            {{--                @if($courses->app_type == news)--}}
            {{--                    NEW--}}
            {{--                @elseif($courses->app_type == replacement)--}}
            {{--                    REPLACEMENT--}}
            {{--                @elseif($courses->app_type == renewal)--}}
            {{--                    RENEWAL--}}
            {{--                @endif--}}
            {{--                ---}}
            {{--                @if($courses->card_id == so_app)--}}
            {{--                    SO--}}
            {{--                @elseif($courses->card_id == avso_app)--}}
            {{--                    AVSO--}}
            {{--                @elseif($courses->card_id == pi_app)--}}
            {{--                    PI--}}
            {{--                @endif--}}
            {{--            </div>--}}
        @endif
        <br>
        <div class="column-center">:</div>
        <div class="column-left">Pass ID No</div>
        <div class="column-right">{{substr($courses->passid, 0, -2)}}</div>
        {{--        @if (strlen($courses->name) <= 40)--}}
        {{--            <div class="column-right-center">:</div>--}}
        {{--            <div class="column-right-left">Grade</div>--}}
        {{--            <div class="column-right-right">--}}
        {{--                @if ($request->card == so_app)--}}
        {{--                    @foreach($t_grade as $index =>$f)--}}
        {{--                        @if(!empty($courses) && $courses->grade_id== $f->id)--}}
        {{--                            {{$f->name}}--}}
        {{--                        @endif--}}
        {{--                    @endforeach--}}
        {{--                @elseif($request->card == avso_app)--}}
        {{--                    NA--}}
        {{--                @else--}}
        {{--                    NA--}}
        {{--                @endif--}}
        {{--            </div>--}}
        {{--        @endif--}}
        <br>
        <div class="column-left">Card Type</div>
        <div class="column-center">:</div>
        <div class="column-right">
            @if($courses->app_type == news)
                NEW
            @elseif($courses->app_type == replacement)
                REPLACEMENT
            @elseif($courses->app_type == renewal)
                RENEWAL
            @endif
            -
            @if($courses->card_id == so_app)
                SO
            @elseif($courses->card_id == avso_app)
                AVSO
            @elseif($courses->card_id == pi_app)
                PI
            @endif
        </div>
        <br>
        <div class="column-left">Grade</div>
        <div class="column-center">:</div>
        <div class="column-right">
            @if ($request->card == so_app)
                @foreach($t_grade as $index =>$f)
                    @if(!empty($courses) && $courses->grade_id== $f->id)
                        {{$f->name}}
                    @endif
                @endforeach
            @elseif($request->card == avso_app)
                NA
            @else
                NA
            @endif
        </div>
        <br>
        @if (strlen($courses->name) <= 40)
            <div class="column-left">Card Expiry Date</div>
            <div class="column-center">:</div>
            <div class="column-right">
                @if(!empty( $courses->expired_date))
                    {{$courses->expired_date}}
                @endif
            </div>
        @endif
        <br>
        <div class="column-center">:</div>
        <div class="column-left">Mobile No</div>
        <div class="column-right">{{substr($courses->mobileno, 2)}}</div>
        <br>
        <div class="column-center">:</div>
        <div class="column-left">Email</div>
        @php
            if(substr($courses->email,0,5) == default_email){
               $email = '-';
            }else{
               $email = $courses->email;
            }
        @endphp
        <div class="column-right">{{$email}}</div>
        <br>
        <div class="column-center">:</div>
        {{--            <div class="column-left">Status</div>--}}
        {{--            <div class="column-right">--}}
        {{--                @if($courses->Status_app == draft)--}}
        {{--                    {{txt_draft}}--}}
        {{--                @elseif($courses->Status_app == processing)--}}
        {{--                    {{txt_processing}}--}}
        {{--                @elseif($courses->Status_app == ready_for_id_card_printing)--}}
        {{--                    {{txt_ready_for_id_card_printing}}--}}
        {{--                @elseif($courses->Status_app == id_card_ready_for_collection)--}}
        {{--                    {{txt_id_card_ready_for_collection}}--}}
        {{--                @elseif($courses->Status_app == resubmission)--}}
        {{--                    {{txt_resubmission}}--}}
        {{--                @elseif($courses->Status_app == Resubmitted)--}}
        {{--                    {{txt_Resubmitted}}--}}
        {{--                @elseif($courses->Status_app == completed)--}}
        {{--                    {{txt_completed}}--}}
        {{--                @endif--}}
        {{--            </div>--}}
        {{--            <br>--}}
        {{--            <div class="column-center">:</div>--}}
        <div class="column-left">Transaction Ref </div>
        <div class="column-right">{{$courses->receiptNo}}</div>
        <br>
        @php
            $grand_total = formatcurrency($courses->grand_total);
        @endphp
        @if($courses->Status_app == ready_for_id_card_printing || $courses->Status_app == id_card_ready_for_collection || $courses->Status_app == resubmission || $courses->Status_app == Resubmitted || $courses->Status_app == completed )
            <div class="column-center">:</div>
            <div class="column-left">Remarks </div>

            <div class="column-right">This is a confirmation of payment of ${{$grand_total}} for the online application of the PLRD ID card</div>
            <br><br><br>
        @endif
{{--        @if($courses->Status_app == processing && $courses->paymentby =="paynow")--}}
            <div class="column-center">:</div>
            <div class="column-left">Payment Amount </div>
            <div class="column-right">${{$grand_total}} inclusive of GST (Pending confirmation)</div>
            <br><br><br>
            <div class="column-center"></div>
            <div class="column-left"></div>
            <div class="column-right-paynow" style=" margin-right: 300px;">

{{--                @if(!empty($courses->data_barcode_paynow))--}}
{{--                    <img src="{{ public_path('img/payment_icon/paynow.jpeg') }} " style=" position: absolute;--}}
{{--                margin-left: 130px;--}}
{{--                margin-top: 100px;--}}
{{--               transform: translate(-50%, -50%); width: 70px;">--}}
{{--                    <img src="{{$courses->data_barcode_paynow}}" style="margin-left=-30px;">--}}
{{--                @else--}}
                    <img src="{{ public_path('img/payment_icon/paynow.jpeg') }} " style=" position: absolute;
                margin-left: 105px;
                margin-top: 75px;
               transform: translate(-50%, -50%); width: 70px;">
                    <img src="data:image/png;base64, {!! $qrcode !!}">
{{--                @endif--}}
                <div style="margin-left: 70px;margin-top: -20px;">Valid for 14</div>
                <div style="margin-left: 40px;">calendar days only</div>

            </div>
            <div class="column-right-paynow"  style=" margin-right: 30px;margin-top: -32px;">
                <h4 >How to Make a PayNow Transfer</h4>
                <img src="{{public_path('/img/barcode_paynow.jpg')}}" style="width: 25%;" >
                <br>
                <div>
                    1.Scan this QR code with the QR scanner on your banking app on your phone.
                </div>
                <div>
                    2.Verity that it displays the following : Entity Name  Union Of Security Employees.
                </div>
                <div>
                    3.Ensure the reference number and amount provided on this page is displaying in banking app and proceed to submit.
                </div>
                <div>
                    4.Once your Paynow transaction has been successful, USE will process with your application.
                </div>
            </div>
{{--        @endif--}}
    </div>
    {{--        <div class="column2">--}}
    {{--            <div class="column-center">:</div>--}}
    {{--            <div class="column-left">NRIC / FIN</div>--}}
    {{--            <div class="column-right">{{$nric}}</div>--}}
    {{--            <div class="column-center">:</div>--}}
    {{--            <div class="column-left">Home No</div>--}}
    {{--            <div class="column-right">{{$courses->mobileno}}</div>--}}
    {{--            <br>--}}
    {{--            <div class="column-center">:</div>--}}
    {{--            <div class="column-left">Status</div>--}}
    {{--            <div class="column-right">{{$courses->homeno}}</div>--}}
    {{--            <br>--}}
    {{--            <div class="column-center">:</div>--}}
    {{--            <div class="column-left">Receipt No</div>--}}
    {{--            <div class="column-right">{{$courses->receiptNo}}</div>--}}

    {{--        </div>--}}
</div>
</body>

</html>
