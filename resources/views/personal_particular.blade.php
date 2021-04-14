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
<div class="container">
    <img class="hidden-xs" src="{{URL::asset('/img/img_step_proses/2.png')}}" style="width: 100%; margin-bottom: 20px;">
    <center class="visible-xs hidden-md">
        <img  src="{{URL::asset('/img/img_step_proses/design_phone/2.png')}}" style="width: 80%;">
    </center>
    <h2 style="color: #E31E1A;">Personal Particular</h2>
    <br>
{{--        <div class="row">--}}
            <div class="col-sm">
                <div class="row">
                    <div class="col-0 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                    <div class="col-6 ColoumndataPersonal">{{$personal->name}}</div>
                    <div class="w-100"></div>
                    <div class="col-0 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                    <div class="col-6 ColoumndataPersonal">{{$personal->nric}}</div>
                    <div class="w-100"></div>
                    <div class="col-0 HeaderdataPersonal">Pass ID No &nbsp;:</div>
                    <div class="col-6 ColoumndataPersonal">{{$personal->passid}}</div>
                </div>
            </div>
            <div class="col-sm">
            </div>
            <br class="visible-xs hidden-md">
            <div class="col-sm" hidden>
                <img src="{{URL::asset('/img/profile.png')}}" style="width: 30%;border-style: groove;">
            </div>
{{--        </div>--}}
    <br><br>

    <h3 style="color: black;font-weight: bold;">Update Contact Details</h3>
    <br>
    <div class="row">
        <div class="col HeaderdataPersonal email">
            Email
        </div>
        <div class="col">
        </div>
        <div class="col-6 HeaderdataPersonal phone">
            Phone Number
        </div>
    </div>
    <form method="post" id="submission" action="{{ route('submission') }}" >
        @csrf
    <div class="row">
        <div class="col-4 HeaderdataPersonal">
            <input type="email" class="form-control" id="email" name="email"  placeholder="XXXXXX@gmail.com" value="{{$personal->email}}">
        </div>
        <div class="col-2">
        </div>
        <div class="col-4 HeaderdataPersonal">
            <input type="text" class="form-control" id="mobileno" name="mobileno"  placeholder="0000000" value="{{$personal->mobileno}}">
        </div>
    </div>
    <br ><br class="hidden-xs"><br class="hidden-xs">
    <div class="row">
        <div class="col-2 back">
            <button type="submit" class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: #E5E5E5; color: #E31D1A"> <a href="javascript:history.go(-1)" style="text-decoration:none;"><img src="{{URL::asset('/img/back.png')}}" style="width: 10%;"> Back</a> </button>
        </div>
        <div class="col-6 medium">
        </div>
        <div class="col-2 next">
            <button type="submit" class=" btn btn-danger btn-lg btn-block">Next <img src="{{URL::asset('/img/next.png')}}" style="width: 10%;"></button>
        </div>
    </div>
        <input type="hidden" id="app_type" name="app_type" value="{{$request->app_type}}">
        <input type="hidden" id="card" name="card" value="{{$request->card}}">
    </form>

</div>

<script type="application/javascript">
    //refresh page on browser resize
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
