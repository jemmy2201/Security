@extends('layouts.app')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
    .HeaderdataPersonal{
        color:#808080;
        font-size: 24px;
    }
    .ColoumndataPersonal{
        font-weight: bold;
        font-size: 24px;
    }
</style>
@section('content')
<div class="container">
    <h3 style="color: #E31E1A;">Personal Particular</h3>
    <br>
        <div class="row">
            <div class="col-sm">
                <div class="row">
                    <div class="col-6 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;:</div>
                    <div class="col-6 ColoumndataPersonal">Rio</div>
                    <div class="w-100"></div>
                    <div class="col-6 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                    <div class="col-6 ColoumndataPersonal">S9812381D</div>
                    <div class="w-100"></div>
                    <div class="col-6 HeaderdataPersonal">Pass ID No &nbsp;:</div>
                    <div class="col-6 ColoumndataPersonal">S9812381D</div>
                </div>
            </div>
            <div class="col-sm">
            </div>
            <br class="visible-xs hidden-md">
            <div class="col-sm">
                <img src="{{URL::asset('/img/profile.png')}}" style="width: 30%;border-style: groove;">
            </div>
        </div>
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
    <div class="row">
        <div class="col-4 HeaderdataPersonal">
            <input type="email" class="form-control" id="email" name="email"  placeholder="XXXXXX@gmail.com">
        </div>
        <div class="col-2">
        </div>
        <div class="col-4 HeaderdataPersonal">
            <input type="text" class="form-control" id="mobileno" name="mobileno"  placeholder="0000000">
        </div>
    </div>
    <br ><br class="hidden-xs"><br class="hidden-xs">
    <div class="row">
        <div class="col-2 back">
            <button type="submit" class=" btn btn-light btn-lg btn-block" style="border-style: groove; color: #E31D1A"> <- Back </button>
        </div>
        <div class="col-6 medium">
        </div>
        <div class="col-2 next">
            <button type="submit" class=" btn btn-danger btn-lg btn-block">Next -></button>
        </div>
    </div>
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
