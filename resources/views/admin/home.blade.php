@extends('layouts.app')

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
    <h3 style="color: #E31E1A;">Submission</h3>
    <br>
        {{-- Desktop --}}
            <div class="row hidden-xs">
                <div class="col-sm">
                    <h4><b>Submitted Details</b></h4>
                    <div class="row">
                        <div class="col-4 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">S9812381D</div>
                        <div class="w-100"></div>
                        <div class="col-4 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                        <div class="col-4 ColoumndataPersonal">Rio</div>
                        <div class="w-100"></div>
                        <div class="col-4 HeaderdataPersonal">Grade &ensp;&ensp;&ensp;&ensp;&nbsp;&nbsp;:</div>
                        <div class="col-4 ColoumndataPersonal">SO / SSO / SSS</div>
                    </div>
                </div>
                <div class="col-sm-0">
                </div>
                <br class="visible-xs hidden-md">
                <div class="col-sm">
                    <br><br>
                    <div class="row">
                        <div class="col-4 HeaderdataPersonal">Pass ID No &ensp;:</div>
                        <div class="col-4 ColoumndataPersonal">XXXXXXXXX</div>
                        <div class="w-100"></div>
                        <div class="col-4 HeaderdataPersonal">Expiry Date&ensp;&nbsp;:</div>
                        <div class="col-4 ColoumndataPersonal">Rio</div>
                    </div>
                </div>
            </div>
        {{-- End Desktop --}}

        {{-- Phone --}}
            <div class="row visible-xs hidden-md">
            <div class="col-sm">
                <h4><b>Submitted Details</b></h4>
                <div class="row">
                    <div class="col-6 HeaderdataPersonal">NRIC / FIN &ensp;:</div>
                    <div class="col-6 ColoumndataPersonal">S9812381D</div>
                    <div class="w-100"></div>
                    <div class="col-6 HeaderdataPersonal">Name &ensp;&ensp;&ensp;&ensp;&ensp;&nbsp;:</div>
                    <div class="col-6 ColoumndataPersonal">Rio</div>
                    <div class="w-100"></div>
                    <div class="col-6 HeaderdataPersonal">Grade &ensp;&ensp;&ensp;&ensp;&nbsp;&nbsp;:</div>
                    <div class="col-6 ColoumndataPersonal">SO / SSO / SSS</div>
                </div>
            </div>
            <div class="col-sm">
            </div>
            <br class="visible-xs hidden-md">
            <div class="col-sm">
                <br><br>
                <div class="row">
                    <div class="col-6 HeaderdataPersonal">Pass ID No &ensp;:</div>
                    <div class="col-6 ColoumndataPersonal">XXXXXXXXX</div>
                    <div class="w-100"></div>
                    <div class="col-6 HeaderdataPersonal">Expiry Date&ensp;&nbsp;:</div>
                    <div class="col-6 ColoumndataPersonal">Rio</div>
                </div>
            </div>
        </div>
        {{-- End Phone --}}

    <br><br>
    <h3 style="color: black;font-weight: bold;">Declaration of training records</h3>
    <br>
    <div class="row">
        <div class="col-10 HeaderdataPersonal email">
            <select class="form-control" id="exampleFormControlSelect1">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
    </div>
    <br>
    <h3 style="color: black;font-weight: bold;">Add Photo</h3>
    <div class="row">
        <div class="col-2 upload_profile" style="margin-top: 8px; border-style: groove; padding: 5px; margin-left: 10px;">
            <img class="file_upload_profile"  src="{{URL::asset('/img/upload.png')}}" style="width: 80%; margin-left: 20px; margin-top: 20px;">
            <input type="file" name="upload_profile" id="upload_profile" style="display: none;">
        </div>
        <div class="col-6">
            <p>Guidelines for Digital Photo Image Submission</p>
            <p>- Photo must be taken within last 3 months</p>
            <p>- Photo must be taken within even brightness</p>
            <p>- Photo must be clear and in sharp focus</p>
            <p>- Photo must be taken without spectacles in color</p>
            <p>- Photo background must be white in color</p>
        </div>
    </div>
    <br>
    <div class="row" style="margin-left: 1px;">
        <div class="col-0">
            <input type="checkbox" id="approval_user" name="approval_user">
        </div>
        <div class="col-8">
            <b>I declare that I have been assessed and certified in the following training modules</b>
        </div>
    </div>
    <br><br class="hidden-xs"><br class="hidden-xs">
    <div class="row">
        <div class="col-2 back">
            <button type="submit" class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: #E5E5E5; color: #E31D1A"> <- Back </button>
        </div>
        <div class="col-6 medium">
        </div>
        <div class="col-2 next">
            <button type="submit" class=" btn btn-danger btn-lg btn-block">Next -></button>
        </div>
    </div>
</div>
<script type="application/javascript">
    $('.file_upload_profile').click(function(){ $('#upload_profile').trigger('click'); });
    //refresh page on browser resize
    $(window).bind('resize', function(e)
    {
        this.location.reload(false); /* false to get page from cache */
        /* true to fetch page from server */
    });
    if($(window).width() < 767)
    {
        RemoveColNextBack();
        $(".upload_profile").addClass("col-4");
        $(".back").addClass("col-4");
        $(".medium").addClass("col-4");
        $(".next").addClass("col-4");

        $(".file_upload_profile").css("margin-top", "70px");
    }
    function RemoveColNextBack() {
        $(".upload_profile").removeClass("col-2");
        $(".back").removeClass("col-2");
        $(".medium").removeClass("col-6");
        $(".next").removeClass("col-2");
    }
</script>
@endsection
