@extends('layouts.app')

<style>
    .Listpaymentmenthod{
        font-size: 18px;
    }
</style>
@section('content')
<div class="container">
    <h3 style="color: #E31E1A;">Payment Details</h3>
    <br>
    <div class="row">
        <div class="col payment_method" style="border-style: groove;">
            <h3><b>Payment Method</b></h3>
            <div class="row" >
                <div class="col-3 VPpaynow Listpaymentmenthod">
                    <button type="button" class="btn btn-secondary btn-lg" id="payment" style="border-style: groove;">PayNow</button>
                </div>
                <div class="col-3 VPenets Listpaymentmenthod">
                    <button type="button" class="btn btn-secondary btn-lg" id="enets" style="border-style: groove;">eNets</button>
                </div>
                <div class="col-3 VPvisa Listpaymentmenthod">
                    <button type="button" class="btn btn-secondary btn-lg" id="visa" style="border-style: groove;">Visa</button>
                </div>
                <div class="col-3 VPmaster Listpaymentmenthod" >
                    <button type="button" class="btn btn-secondary btn-lg" id="master" style="border-style: groove;">Mastercard</button>
                </div>
            </div><br>
            <div class="row">
                <div class="col-6">
                    <p style="color:#808080;">Cardholder name</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <input type="text" class="form-control" id="card_holder_name" name="card_holder_name"  placeholder="XXXXXX">
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
                    <input type="text" class="form-control" id="card_number" name="card_number"  placeholder="000000">
                </div>
            </div><br>
            <div class="row">
                <div class="col">Month</div>
                <div class="col">Year</div>
                <div class="col">CCV</div>
                <div class="w-100"></div>
                <div class="col">
                    <select class="form-control" aria-label="Default select example">
                        <option selected></option>
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
                    <select class="form-control" aria-label="Default select example">
                        <option selected></option>
                        <option value="12">21</option>
                    </select>
                </div>
                <div class="col">
                    <input type="text" class="form-control" id="ccv_number" name="ccv_number"  placeholder="000000">
                </div>
            </div><br><br>
        </div>
        <div class="col-4 hidden-xs">
            <div class="row" style="border-style: groove;">
                <div class="col">
                    <h3><b>Summarry</b></h3>
                    <div class="row">
                        <div class="col-4">Aplication :</div>
                        <div class="col">New</div>
                        <div class="w-100"></div>
                        <div class="col-4">Type :</div>
                        <div class="col">So ID Card</div>
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
            </div><br>
            <div class="row">
                <div class="col">
                    <button type="button" class="btn btn-danger btn-lg btn-block" >Confirm -></button>
                </div>
            </div>
        </div>
    </div>
    <div class="row visible-xs hidden-md" style="border-style: groove;">
        <div class="col">
            <h3><b>Summarry</b></h3>
            <div class="row">
                <div class="col-4">Aplication :</div>
                <div class="col">New</div>
                <div class="w-100"></div>
                <div class="col-4">Type :</div>
                <div class="col">So ID Card</div>
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
            <button type="button" class="btn btn-danger btn-lg btn-block" >Confirm -></button>
        </div>
    </div>
    <br><br class="hidden-xs"><br class="hidden-xs">

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
</script>
@endsection
