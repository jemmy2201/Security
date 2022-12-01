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
@if(!empty($grade))
<form method="post" id="delcare_submission" action="{{ route('submission') }}" enctype="multipart/form-data">
    @csrf
<div class="container declare">
    <h2 style="color: #E31E1A;"> Declaration of Training</h2>
    <h3><b>Statement of Attainment for the following modules :</b></h3>
    <div class="row">
        <div class="col-10 select_declare">
            <ul class="list-group">
            @foreach ($grade as $f)
                    @if($f->take_grade)
                        <li class="list-group-item"><input class="form-check-input" type="checkbox" name="Cgrade[]" id="Cgrade" value="{{$f->id}}" disabled>&ensp;&ensp; {{$f->name}}</li>
                        <input class="form-check-input" type="hidden" name="array_grade" id="array_grade" value="{{$request->array_grade}}" >
                    @elseif($f->display)
                        <li class="list-group-item"><input class="form-check-input" type="checkbox" name="Cgrade[]" id="Cgrade" value="{{$f->id}}" disabled>&ensp;&ensp; {{$f->name}}</li>
                    @else
                        <li class="list-group-item"><input class="form-check-input" type="checkbox" name="Cgrade[]" id="Cgrade" value="{{$f->id}}" >&ensp;&ensp; {{$f->name}}</li>
                    @endif
            @endforeach
            </ul>
        </div>
    </div>
    <input type="hidden" id="app_type" name="app_type" value="{{$request->app_type}}">
    <input type="hidden" id="card" name="card" value="{{$request->card}}">
{{--    <input type="checkbox" id="declare_trainig" name="declare_trainig">&ensp;&ensp;--}}
{{--    <b>I declare that I have been assessed and certified in the following training modules</b>--}}
    <div class="row">
        <div class="col-2 back">
            <a href="javascript:history.go(-1)" style="text-decoration:none;"><button type="button"  class=" btn btn-danger btn-lg btn-block">Cancel</button></a>
        </div>
        <div class="col-6 medium">
        </div>
        <div class="col-2 next">
            <button type="button" id="submit_declare_trainig" class=" btn btn-danger btn-lg btn-block">Confirm</button>
        </div>
    </div>
</div>
</form>

@endif
<script type="application/javascript">
    //refresh page on browser resize
    $(window).bind('resize', function(e)
    {
        this.location.reload(false); /* false to get page from cache */
        /* true to fetch page from server */
    });
    $(function(){
        $("#submit_declare_trainig" ).click(function() {
            if ($("input[name='Cgrade[]']:checked").val() != undefined) {
                // if ($("input[name='declare_trainig']:checked").val()){
                    $( "#delcare_submission" ).submit();
                // }else{
                //     swal("Please!", " tick declare", "error")
                // }
            }else{
                swal("Error!", " select training", "error")

            }

        });

    });
    $( document ).ready(function() {
        if($(window).width() < 767)
        {
            RemoveColNextBack();
            $(".back").addClass("col-4");
            $(".medium").addClass("col-4");
            $(".next").addClass("col-4");

        }
        function RemoveColNextBack() {
            $(".back").removeClass("col-2");
            $(".medium").removeClass("col-6");
            $(".next").removeClass("col-2");
        }
    });


</script>
@endsection
