@extends('layouts.app')

<style>
    .HeaderdataPersonal{
        color:#808080;
        font-size: 20px;
    }
    .ColoumndataPersonal{
        font-weight: bold;
        font-size: 20px;
    }
</style>
@section('content')
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
    <div class="container submission">
{{--        <img class="hidden-xs" src="{{URL::asset('/img/img_step_proses/3.png')}}" style="width: 100%; margin-bottom: 20px;">--}}
{{--        <center class="visible-xs hidden-md">--}}
{{--            <img  src="{{URL::asset('/img/img_step_proses/design_phone/3.png')}}" style="width: 80%;">--}}

{{--        <a href="javascript:history.go(-1)" style="text-decoration:none;">--}}
{{--        <button class="btn btn-light" style="border-style: groove; background: #E5E5E5; color: #E31D1A">--}}
{{--         <img src="{{URL::asset('/img/back.png')}}" style="width: 20%;"> Back--}}
{{--        </button>--}}
{{--        </a>--}}

        {{--        </center>--}}
        <h2 style="color: #E31E1A;">ID Card Application Details
        </h2>
        <br>
        @if($request->thank_payment == true)
        <center>
{{--        <h3><b>{{thanks_payment}}</b></h3>--}}
        </center>
        @endif
        {{-- Desktop --}}
        <h4><b>Details</b></h4>

        <div class="container">
            <div class="row hidden-xs">
                <div class="col-sm">
                    <div class="row">
{{--                        <div class="col-0 HeaderdataPersonal">NRIC/FIN&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >NRIC/FIN <span style="margin-left: 80px;">:</span></div>
                        @php
                            $cutnric = substr(secret_decode($courses->nric), -4);
                            $nric = "XXXXX$cutnric";
                        @endphp
                        <div class="col-4 ColoumndataPersonal">{{$nric}}</div>
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Name <span style="margin-left: 114px;">:</span></div>
                    @if (strlen($courses->name) > 40)
                            <div class="col-4 ColoumndataPersonal hidden-xs">
                                <textarea rows="4" cols="30" id="TextAreaName" style="resize: none;" readonly>
                                {{$courses->name}}
                                </textarea>
                            </div>
                        @else
                            <div class="col-4 ColoumndataPersonal">{{$courses->name}}</div>
                        @endif
{{--                        <div class="col-4 ColoumndataPersonal">{{$courses->name}}</div>--}}
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal"> Mobile No&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Mobile No <span style="margin-left: 78px;">:</span></div>
                        <div class="col-4 ColoumndataPersonal">{{$courses->mobileno}}</div>
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal"> Home No&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Email <span style="margin-left: 117px;">:</span></div>
                        <div class="col-4 ColoumndataPersonal">{{$courses->email}}</div>

                    </div>
                </div>
                <div class="col-sm-0">
                </div>
                <br class="visible-xs hidden-md">
                <div class="col-sm">
                    <div class="row">
{{--                        <div class="col-0 HeaderdataPersonal">Pass ID No &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Pass ID <span style="margin-left: 92px;">:</span></div>
                        <div class="col-4 ColoumndataPersonal">{{$courses->passid}}</div>
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Card Type &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Card Type <span style="margin-left: 70px;">:</span></div>
                        <div class="col-4 ColoumndataPersonal">
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
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Grade &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;&nbsp;&nbsp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Grade <span style="margin-left: 106px;">:</span></div>
                    @if ($request->card == so_app)
                            @foreach($t_grade as $index =>$f)
                                @if(!empty($courses) && $courses->grade_id== $f->id)
                                    <div class="col-4 ColoumndataPersonal">{{$f->name}}</div>
{{--                            @if(!empty($course) && $course->grade_id== so)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SO</div>--}}
{{--                            @elseif(!empty($course) && $course->grade_id == sso)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SSO</div>--}}
{{--                            @elseif(!empty($course) && $course->grade_id== ss)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SS</div>--}}
{{--                            @elseif(!empty($course) && $course->grade_id== sss)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SSS</div>--}}
{{--                            @elseif(!empty($course) && $course->grade_id== cso)--}}
{{--                                <div class="col-4 ColoumndataPersonal">CSO</div>--}}
{{--                            @else--}}
{{--                                <div class="col-4 ColoumndataPersonal">SO</div>--}}
                                @endif
                            @endforeach
                        @elseif($request->card == avso_app)
                            <div class="col-4 ColoumndataPersonal">NA</div>
                        @else
                            <div class="col-4 ColoumndataPersonal">NA</div>
                        @endif
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Card Expiry Date&ensp;&nbsp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Card Expiry Date <span style="margin-left: 10px;">:</span></div>
                    @if(!empty( $courses->passexpirydate))
                        <div class="col-4 ColoumndataPersonal">{{$courses->passexpirydate}}</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="container">
            <div class="row hidden-xs">
                <div class="col-sm">
                    <div class="row">
{{--                        <div class="col-0 HeaderdataPersonal">Status &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Status <span style="margin-left: 111px;">:</span></div>
                        <div class="col-4 ColoumndataPersonal">
                            @if($courses->Status_app == completed)
                                <td>{{txt_completed}}</td>
                            @elseif($courses->Status_app == draft)
                                <td>{{txt_draft}}</td>
                            @elseif($courses->Status_app == submitted)
                                <td>{{txt_submitted}}</td>
                            @elseif($courses->Status_app == processing)
                                <td>{{txt_processing}}</td>
                            @elseif($courses->Status_app == id_card_ready_for_collection)
                                <td>{{txt_id_card_ready_for_collection}}</td>
                            @elseif($courses->Status_app == resubmission)
                                <td>{{txt_resubmission}}</td>
                            @elseif($courses->Status_app == Resubmitted)
                                {{txt_Resubmitted}}
                            @endif
                        </div>
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Receipt &nbsp;No&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Receipt No <span style="margin-left: 68px;">:</span></div>
                        <div class="col-4 ColoumndataPersonal">{{$courses->receiptNo}}</div>
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Payment Amount&ensp;&ensp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Payment Amount <span style="margin-left: 15px;">:</span></div>
                        @php
                        $grand_total = formatcurrency($courses->grand_total);
                        @endphp
                        <div class="col-4 ColoumndataPersonal">${{$grand_total}} inclusive of GST</div>
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Appointment Date &nbsp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Appointment Date <span style="margin-left: 7px;">:</span></div>
                        <div class="col-4 ColoumndataPersonal">{{Carbon\Carbon::parse($courses->appointment_date)->format('d-m-Y')}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal" >Time Slot <span style="margin-left: 84px;">:</span></div>
                        <div class="col-4 ColoumndataPersonal">{{ $courses->time_start_appointment}} : {{$courses->time_end_appointment}} </div>
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Payment &ensp;&ensp;&nbsp;:</div>--}}
{{--                        <div class="col-4 ColoumndataPersonal">--}}
{{--                            @if($courses->status_payment == paid)--}}
{{--                                Paid--}}
{{--                            @else--}}
{{--                                UnPaid--}}
{{--                            @endif--}}
{{--                        </div>--}}
                        <div class="w-100"></div>
                        @if ($request->card == so_app && !empty($courses->array_grade))
                            <br>
{{--                        <div class="col-0 HeaderdataPersonal">Courses &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>--}}
{{--                            <div class="col-0 HeaderdataPersonal" >Courses <span style="margin-left: 94px;">:</span></div>--}}
{{--                            <div class="col-8 ColoumndataPersonal">--}}
{{--                            @foreach (json_decode($courses->array_grade) as $f)--}}
{{--                                @php $data = DB::table('grades')->where(['id'=>$f])->get();@endphp--}}
{{--                                <ul class="list-group">--}}
{{--                                    <li class="list-group-item">--}}
{{--                                        <img src="{{URL::asset('/img/rounded .png')}}" style="width:5px;">--}}
{{--                                        {{$data[0]->name}}--}}
{{--                                    </li>--}}
{{--                                </u>--}}
{{--                            @endforeach--}}

{{--                        </div>--}}
                        @endif
                    </div>
                </div>
                <div class="col-sm-0">
                </div>
                <br class="visible-xs hidden-md">
            </div>
        </div>
        {{-- End Desktop --}}

        {{-- Phone --}}
        <div class="row visible-xs hidden-md">
            <div class="col-sm">
                <div class="container">
                    <div class="row">
{{--                        <div class="col-0 HeaderdataPersonal">NRIC/FIN&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >NRIC/FIN <span style="margin-left: 70px;">:</span></div>
                        <div class="col-6 ColoumndataPersonal">{{$nric}}</div>
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Name&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Name <span style="margin-left: 103px;">:</span></div>
                    @if (strlen($courses->name) > 40)
                            <div class="col-6 ColoumndataPersonal ">
                                 <textarea rows="4" cols="18" id="TextAreaNamePhone" style="resize: none;" readonly>
                                {{$courses->name}}
                                </textarea>
{{--                                {{substr($courses->name,0,20)}}<br>{{substr($courses->name,20,20)}}<br>{{substr($courses->name,40,20)}}<br>{{substr($courses->name,60,20)}}<br>--}}
                            </div>
                        @else
                            <div class="col-6 ColoumndataPersonal">{{$courses->name}}</div>
                        @endif
{{--                        <div class="col-6 ColoumndataPersonal">{{$courses->name}}</div>--}}
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Mobile No &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Mobile No <span style="margin-left: 67px;">:</span></div>
                        <div class="col-6 ColoumndataPersonal">{{$courses->mobileno}}</div>
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Home No&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Email <span style="margin-left: 108px;">:</span></div>
                        <div class="col-6 ColoumndataPersonal">
                            <textarea rows="4" cols="18" style="resize: none;" readonly>
                                {{$courses->email}}
                                </textarea>
{{--                            {{$courses->email}}--}}
                        </div>
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Status &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Status <span style="margin-left: 101px;">:</span></div>
                        <div class="col-6 ColoumndataPersonal">
                            @if($courses->Status_app == completed)
                                <td>{{txt_completed}}</td>
                            @elseif($courses->Status_app == draft)
                                <td>{{txt_draft}}</td>
                            @elseif($courses->Status_app == submitted)
                                <td>{{txt_submitted}}</td>
                            @elseif($courses->Status_app == processing)
                                <td>{{txt_processing}}</td>
                            @elseif($courses->Status_app == id_card_ready_for_collection)
                                <td>{{txt_id_card_ready_for_collection}}</td>
                            @elseif($courses->Status_app == resubmission)
                                <td>{{txt_resubmission}}</td>
                            @elseif($courses->Status_app == Resubmitted)
                                <td>{{txt_Resubmitted}}</td>
                            @endif
                        </div>
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Card Type &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Card Type <span style="margin-left: 66px;">:</span></div>
                        <div class="col-6 ColoumndataPersonal">
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
                            @endif</div>
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Grade &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Grade <span style="margin-left: 102px;">:</span></div>
                        @if ($request->card == so_app)
                            @foreach($t_grade as $index =>$f)
                            @if(!empty($courses) && $courses->grade_id== $f->id)
                                    <div class="col-4 ColoumndataPersonal">{{$f->name}}</div>
{{--                            @if(!empty($course) && $course->grade_id== so)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SO</div>--}}
{{--                            @elseif(!empty($course) && $course->grade_id== sso)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SSO</div>--}}
{{--                            @elseif(!empty($course) && $course->grade_id== ss)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SS</div>--}}
{{--                            @elseif(!empty($course) && $course->grade_id== sss)--}}
{{--                                <div class="col-4 ColoumndataPersonal">SSS</div>--}}
{{--                            @elseif(!empty($course) && $course->grade_id== cso)--}}
{{--                                <div class="col-4 ColoumndataPersonal">CSO</div>--}}
{{--                            @else--}}
{{--                                <div class="col-4 ColoumndataPersonal">SO</div>--}}
                                @endif
                            @endforeach
                        @elseif($request->card == avso_app)
                            <div class="col-6 ColoumndataPersonal">NA</div>
                        @else
                            <div class="col-6 ColoumndataPersonal">NA</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-sm">
            </div>
            <br class="visible-xs hidden-md">
            <div class="col-sm">
                <div class="container">
                    <div class="row">
{{--                        <div class="col-0 HeaderdataPersonal">Pass ID No &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Pass ID No <span style="margin-left: 57px;">:</span></div>
                        <div class="col-6 ColoumndataPersonal">{{$courses->passid}}</div>
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Card Expiry Date&ensp;&nbsp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Card Expiry Date <span style="margin-left: 6px;">:</span></div>
                        <div class="col-6 ColoumndataPersonal">{{$courses->passexpirydate}}</div>
                    </div>
                </div>
            </div>
            <br class="visible-xs hidden-md">
            <div class="col-sm">
                <div class="container">
                    <div class="row">
{{--                        <div class="col-0 HeaderdataPersonal">Receipt No&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Receipt No <span style="margin-left: 60px;">:</span></div>
                        <div class="col-6 ColoumndataPersonal">{{$courses->receiptNo}}</div>
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Payment Amount&ensp;&ensp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Payment Amount <span style="margin-left: 7px;">:</span></div>
                        <div class="col-4 ColoumndataPersonal">${{$grand_total}} inclusive of GST</div>
                        <div class="w-100"></div>
{{--                        <div class="col-0 HeaderdataPersonal">Appointment Date &nbsp;:</div>--}}
                        <div class="col-0 HeaderdataPersonal" >Appointment Date :</div>
                        <div class="col-4 ColoumndataPersonal">{{Carbon\Carbon::parse($courses->appointment_date)->format('d-m-Y')}}</div>
                        <div class="w-100"></div>
                        <div class="col-0 HeaderdataPersonal" >Time Slot <span style="margin-left: 75px;">:</span></div>
                        <div class="col-4 ColoumndataPersonal">{{ $courses->time_start_appointment}} : {{$courses->time_end_appointment}}</div>
                        <div class="w-100"></div>
                    </div>
                </div>
            </div>
            <br class="visible-xs hidden-md">
            @if ($request->card == so_app && !empty($courses->array_grade) )
            <div class="col-sm">
                <div class="container">
                    <div class="row">
{{--                        <div class="col-0 HeaderdataPersonal">Courses &ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;&ensp;:</div>--}}
{{--                        <div class="col-0 HeaderdataPersonal" >Courses <span style="margin-left: 85px;">:</span></div>--}}
{{--                        <div class="col-12 ColoumndataPersonal">--}}
{{--                            @foreach (json_decode($courses->array_grade) as $f)--}}
{{--                                @php $data = DB::table('grades')->where(['id'=>$f])->get();@endphp--}}
{{--                                <ul class="list-group">--}}
{{--                                    <li class="list-group-item">--}}
{{--                                        <img src="{{URL::asset('/img/rounded .png')}}" style="width:5px;">--}}
{{--                                        {{$data[0]->name}}--}}
{{--                                    </li>--}}
{{--                                    </u>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}

                    </div>
                </div>
            </div>
            @endif
        </div>
        {{-- End Phone --}}
        <br>
        <div class="row">
            <div class="col-2 back">
                <button type="submit" class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: #1E90FF; color: #E31D1A">
                    <a href="{{url("/home")}}" style="text-decoration:none; color: white;">
{{--                        <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;"> --}}
                        Back
                </a> </button>
            </div>
            <div class="col-8 medium hidden-xs">
            </div>
            <div class="col-3  visible-xs hidden-md">
            </div>
            <div class="col-2 next hidden-xs">
                <a href="{{ url('invoice/print/pdf/'.$request->card) }}" target="_blank" style="text-decoration: none;"><button type="button"  class=" btn btn-danger btn-lg btn-block" style=" background: #1E90FF; color: white;">Print Receipt</button></a>
            </div>
            <div class="col-5 visible-xs hidden-md">
                <a href="{{ url('invoice/print/pdf/'.$request->card) }}" target="_blank" style="text-decoration: none;"><button type="button"  class=" btn btn-danger btn-lg btn-block" style=" background: #1E90FF; color: white;">Print Receipt</button></a>
            </div>
        </div>

    <script type="application/javascript">
        $(".logout_save_draft").click(function() {
            $("#logout_save_draft").val(true)
            window.location.href ='/save_draft/'+{!! json_encode($request->app_type) !!}+'/'+{!! json_encode($request->card) !!}+'/'+{!! json_encode(draft) !!}+'/'+ $("#logout_save_draft").val();
        });
        $(window).bind('resize', function(e)
        {
            this.location.reload(false); /* false to get page from cache */
            /* true to fetch page from server */
        });
        if($(window).width() < 767)
        {
            RemoveColNextBack();
            $(".back").addClass("col-4");
            $(".medium").addClass("col-4");
            $(".next").addClass("col-4");

            $(".email").css("font-size", "20px");
            $(".phone").css("font-size", "20px");
        }
        function RemoveColNextBack() {
            $(".back").removeClass("col-2");
            $(".medium").removeClass("col-6");
            $(".next").removeClass("col-2");
        }
    </script>
@endsection
