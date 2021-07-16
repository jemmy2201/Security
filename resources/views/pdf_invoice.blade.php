<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        * {
            box-sizing: border-box;
        }

        /* Create four equal columns that floats next to each other */
        .column {
            float: left;
            width: 100%;
            padding: 15px;
            /*height: 300px; !* Should be removed. Only for demonstration *!*/
        }
        .column2{
            margin-left: -170px;
            float: left;
            width: 40%;
            padding: 10px;
            /*height: 300px; !* Should be removed. Only for demonstration *!*/
        }
        .column-left {
            float: left;
            width: 30%;
        }

        .column-right {
            float: right;
            width: 55%;
        }

        .column-center {
            display: inline-block;
            padding-left: 40%;
            padding-top: 5px;
            width: 30%;
        }


        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
<h4 style="color: #E31E1A;">ID Card Application Details</h4>
<h6><b>Details</b></h6>
    <div class="row">
        <div class="column" >
            @php
                $cutnric = substr($courses->nric, -4);
                $nric = "XXXXX$cutnric";
            @endphp
            <div class="column-center">:</div>
            <div class="column-left">NRIC / FIN</div>
            <div class="column-right">{{$nric}}</div>
            <br>
            <div class="column-center">:</div>
            <div class="column-left">Name</div>
            @if (strlen($courses->name) > 40)
            <div class="column-right">{{substr($courses->name,0,40)}}<br>{{substr($courses->name,40)}}</div>
                <br><br>
            @else
                <div class="column-right">{{$courses->name}}</div>
                <br>
            @endif
            <div class="column-center">:</div>
            <div class="column-left">Mobile No</div>
            <div class="column-right">{{$courses->mobileno}}</div>
            <br>
            <div class="column-center">:</div>
            <div class="column-left">Home No</div>
            <div class="column-right">{{$courses->homeno}}</div>
            <br>
            <div class="column-center">:</div>
            <div class="column-left">Status</div>
            <div class="column-right">
                @if($courses->Status_app == draft)
                    Draft
                @elseif($courses->Status_app == submitted)
                    Submitted (Payment Done)
                @elseif($courses->Status_app == processing)
                    Processing
                @elseif($courses->Status_app == id_card_ready_for_collection)
                    ID Card Ready for Collection
                @elseif($courses->Status_app == resubmission)
                    Resubmission
                @elseif($courses->Status_app == completed)
                    Completed
                @endif
            </div>
            <br>
            <div class="column-center">:</div>
            <div class="column-left">Receipt No</div>
            <div class="column-right">{{$courses->receiptNo}}</div>
            <br>
            <div class="column-center">:</div>
            <div class="column-left">Pass ID No</div>
            <div class="column-right">{{$courses->passid}}</div>
            <br>
            <div class="column-center">:</div>
            <div class="column-left">Card Type</div>
            <div class="column-right">
                @if($courses->card_id == so_app)
                    SO
                @elseif($courses->card_id == avso_app)
                    AVSO
                @elseif($courses->card_id == pi_app)
                    PI
                @endif
            </div>
            <br>
            <div class="column-center">:</div>
            <div class="column-left">Grade</div>
            @if ($request->card == so_app)
                @foreach($t_grade as $index =>$f)
                    @if(!empty($courses) && $courses->grade_id== $f->id)
                        <div class="column-right">{{$f->name}}</div>
                    @endif
                @endforeach
            @elseif($request->card == avso_app)
                <div class="column-right">NA</div>
            @else
                <div class="column-right">NA</div>
            @endif
            <br>
            <div class="column-center">:</div>
            <div class="column-left">Card Expiry Date</div>
            @if(!empty( $courses->passexpirydate))
                <div class="column-right">{{$courses->passexpirydate}}</div>
            @endif
        </div>


{{--        <div class="column2" style="background-color:#ccc;">--}}
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
