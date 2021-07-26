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
    .dissable{
        pointer-events: none;
        opacity: 0.6;
        background-color:lightgrey;

    }
    .weekend{
        pointer-events: none;
        opacity: 0.6;
        background-color:lightgrey;
    }
    .choice_order_date{
        background-color:forestgreen;
    }
    .holidayfull{
        pointer-events: none;
        opacity: 0.6;
        background-color:red;
    }
    .holidayhalf{
        /*pointer-events: none;*/
        /*opacity: 0.6;*/
        background-color:yellow;
    }
    .active{
        background-color:blue;
    }
    .now{
        background-color:blue;
    }
</style>
@section('content')
<div class="container">
    <img class="hidden-xs" src="{{URL::asset('/img/img_step_proses/4.png')}}" style="width: 100%;margin-bottom: 20px;">
    <center class="visible-xs hidden-md">
        <img  src="{{URL::asset('/img/img_step_proses/design_phone/4.png')}}" style="width: 80%;">
    </center>
    <h2 style="color: #E31E1A;">Book Appointment</h2><br>
    <form method="post" id="save_appointment" action="{{ route('save.book.appointment') }}" >
        @csrf
        <input type="hidden"  class="form-control" name="card" id="card" value="{{$request->card}}" readonly>
        <input type="hidden"  class="form-control" name="valid_resubmission" id="valid_resubmission" readonly>

    <div class="row">
        <div class="col-2 HeaderdataPersonal view_date_text">
            <h4>Select Date :</h4>
        </div>
        <div class="col-2 HeaderdataPersonal value_date_text">
            <input type="text"  class="form-control" name="view_date" id="view_date" readonly>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div id="apps"></div>
        </div>
    </div>
        <div class="row">
            <div class="col">
                <ul style="font-weight: bold; list-style-type: none;margin-left: -25px;">
                    <li>
                        <img src="{{URL::asset('/img/yellow_box.jpg')}}" style="width: 2%;"> : half working day up to 13:00
                    </li>
                    <li><img src="{{URL::asset('/img/red_box.jpeg')}}" style="width: 2%;"> : full day vacation</li>
                    @if(!empty($request->Status_app) && $request->Status_app == resubmission)
                    <li><img src="{{URL::asset('/img/green_box.jpg')}}" style="width: 2%;"> : selected date</li>
                    @endif
                </ul>
            </div>
        </div>
    <br><br class="hidden-xs"><br class="hidden-xs">
    <div class="row">
        <div class="col-2 back">
            <button type="submit" class=" btn btn-light btn-lg btn-block" style="border-style: groove; background: #E5E5E5; color: #E31D1A" onclick="window.history.go(-1); return false;"><a href="#" style="text-decoration:none;"> <img src="{{URL::asset('/img/back.png')}}" style="width: 10%;"> Back </a></button>
        </div>
        <div class="col-8 medium hidden-xs">
        </div>
        <div class="col-6 medium visible-xs hidden-md">
        </div>
        <div class="col-2 next">
            @if(!empty($request->Status_app) && $request->Status_app == resubmission)
                <button type="button" id="save_book_appointment" class=" btn btn-danger btn-lg btn-block">Resubmit <img src="{{URL::asset('/img/next.png')}}" style="width: 10%;"></button>
            @else
                <button type="button" id="save_book_appointment" class=" btn btn-danger btn-lg btn-block">Payment <img src="{{URL::asset('/img/next.png')}}" style="width: 10%;"></button>
            @endif

        </div>
    </div>
    </form>
</div>

<script type="application/javascript">
    $( document ).ready(function() {
        $( "#save_book_appointment" ).click(function() {
            if ($("input[name='limit_schedule_id']:checked").val()){
                $( "#save_appointment" ).submit();
            }else{
                swal("Please!", " select a date and time", "error")
            }
        });
    });

    // $( "#payment" ).submit(function( event ) {
    //     event.preventDefault();
    // });
    $("#time_schedule").change(function(){
        var selValue = $("input[type='radio']:checked").val();
    });

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
        $(".view_date_text").addClass("col-4");
        $(".value_date_text").addClass("col-6");
        $(".back").addClass("col-4");
        $(".medium").addClass("col-4");
        $(".next").addClass("col-4");

        $(".file_upload_profile").css("margin-top", "70px");
    }
    function RemoveColNextBack() {
        $(".view_date_text").removeClass("col-2");
        $(".value_date_text").removeClass("col-2");
        $(".upload_profile").removeClass("col-2");
        $(".back").removeClass("col-2");
        $(".medium").removeClass("col-6");
        $(".next").removeClass("col-2");
    }
</script>
<script type="application/javascript">
    'use strict';

    //Public Globals
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wedensday', 'Thursday', 'Friday', 'Saturday'];
    const months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];

    let c_date = new Date();
    let day = c_date.getDay();

    if ({!!  json_encode($request->booking_schedule->appointment_date) !!} != null && $('#valid_resubmission').val() == false &&  {!!  json_encode($request->Status_app) !!} == {!!  json_encode(resubmission) !!}){
        //resubmission
        $('#valid_resubmission').val(true);
        var month = {!!  json_encode(date("n", strtotime($request->booking_schedule->appointment_date))-1) !!};
        //End resubmission
    }else {
        var month = c_date.getMonth();
    }
    let year = c_date.getFullYear();

    (function App() {

        const calendar = `<div class="container">
            <div class="row">
                <div class="col-sm-6 col-12 d-flex">
                    <div class="card border-0 mt-5 flex-fill">
                        <div class="card-header py-3 d-flex justify-content-between">
                            <span class="prevMonth">&#10096;</span>
                            <span><strong id="s_m"></strong></span>
                            <span class="nextMonth">&#10097;</span>
                        </div>
                        <div class="card-body px-1 py-3">
                            <div class="table-responsive">
                                <table class="table table-sm table-borderless">
                                    <thead class="days text-center">
                                        <tr>
                                            ${Object.keys(days).map(key => (
            `<th><span>${days[key].substring(0,3)}</span></th>`
        )).join('')}
                                        </tr>
                                    </thead>
                                    <tbody id="dates" class="dates text-center"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-12 d-flex pa-sm">
                    <div class="card border-0 mt-5 flex-fill d-none" id="event">
                        <div class="card-header py-3 text-center">
                            <table id="limit_scheduler" class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Time</th>
                                        <th>Current Booking</th>
                                        <th>Max Available</th>
                                    </tr>
                                </thead>
                                <tbody id="veiw_time_schedule">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
        document.getElementById('apps').innerHTML = calendar;
    })()

    function renderCalendar(m, y) {
        //Month's first weekday
        let firstDay = new Date(y, m, 1).getDay();
        //Days in Month
        let d_m = new Date(y, m+1, 0).getDate();
        //Days in Previous Month
        let d_pm = new Date(y, m, 0).getDate();


        let table = document.getElementById('dates');
        table.innerHTML = '';
        let s_m = document.getElementById('s_m');
            s_m.innerHTML = months[m] + ' ' + y;

        let date = 1;
        //remaing dates of last month
        let r_pm = (d_pm-firstDay) +1;
            for (let i = 0; i < 6; i++) {
            let row = document.createElement('tr');
            for (let j = 0; j < 7; j++) {
                if (i === 0 && j < firstDay) {
                    let cell = document.createElement('td');
                    let span = document.createElement('span');
                    let cellText = document.createTextNode(r_pm);
                    // span.classList.add('prevMonth');
                    cell.appendChild(span).appendChild(cellText);
                    row.appendChild(cell);
                    r_pm++;
                }
                else if (date > d_m && j <7) {
                    if (j!==0) {
                        let i = 0;
                        for (let k = j; k < 7; k++) {
                            i++
                            let cell = document.createElement('td');
                            let span = document.createElement('span');
                            let cellText = document.createTextNode(i);
                            // span.classList.add('ntMonth');
                            // span.classList.add('nextMonth');
                            cell.appendChild(span).appendChild(cellText);
                            row.appendChild(cell);
                        };
                    }
                    break;
                }
                else {
                    let cell = document.createElement('td');
                    let span = document.createElement('span');
                    let cellText = document.createTextNode(date);
                    span.classList.add('showEvent');
                    //  Hidden 7 next day
                    if (date > c_date.getDate() && y === c_date.getFullYear() && m === c_date.getMonth()){
                        var sevenDayHidden = c_date.getDate() + 7;
                        if (date < sevenDayHidden ){
                            span.classList.add('dissable');
                        }
                    }
                    //  End Hidden 7 next day

                    // Date Holiday
                    {!!  json_encode($dayHoliday) !!}.forEach(function(entry) {
                        if (entry.date.substring(8, 10) == date  && y === c_date.getFullYear() && m === entry.date.substring(6, 7)-1 && entry.time_work == @php echo full @endphp) {
                            span.classList.add('holidayfull');
                        }else if (entry.date.substring(8, 10) == date  && y === c_date.getFullYear() && m === entry.date.substring(6, 7)-1 && entry.time_work == @php echo half @endphp) {
                            span.classList.add('holidayhalf');
                        }
                    });
                    // End Date Holiday

                    if (date === c_date.getDate() && y === c_date.getFullYear() && m === c_date.getMonth()) {
                        span.classList.add('dissable');
                        $('.prevMonth').css({"pointer-events": "none", "opacity": "0.6"});
                    }else if(date < c_date.getDate()  && y === c_date.getFullYear() && m === c_date.getMonth()){
                        span.classList.add('dissable');
                    }else if(date == c_date.getDate()  && y === c_date.getFullYear() && m > c_date.getMonth()){
                        $('.prevMonth').css({"pointer-events": "", "opacity": ""});
                        $('.nextMonth').css({"pointer-events": "", "opacity": ""});
                    }else if(date == c_date.getDate()  && y === c_date.getFullYear() && m < c_date.getMonth()){
                        $('.prevMonth').css({"pointer-events": "none", "opacity": "0.6"});
                    }
                    // hidden next 3 month
                    var hidden_3month = c_date.getMonth() + 2;
                    if (y === c_date.getFullYear() && m > hidden_3month) {
                        $('.nextMonth').css({"pointer-events": "none", "opacity": "0.6"});
                    }
                    // End hidden next 3 month

                    // holiday saturday,sunday
                    var d = new Date();
                    var month = m;
                    // var getTot = daysInMonth(month,d.getFullYear());
                    var getTot = {!!  json_encode(date_last) !!};
                    var sat = new Array();
                    var sun = new Array();

                    for(var s=1;s<=getTot;s++){
                        var newDate = new Date(d.getFullYear(), month, s)
                        if (newDate.getDay() == 6) {
                                sat.push(s)
                            }
                            if (newDate.getDay() == 0) {
                                sun.push(s)
                            }
                    }
                    function daysInMonth(month,year) {
                        return new Date(year, month, 0).getDate();
                    }

                    sat.forEach(function(saturday) {
                        if(date == saturday  && y === c_date.getFullYear() && m === c_date.getMonth()){
                                span.classList.add('weekend');
                        }
                    });
                    sat.forEach(function(saturday) {
                        if(date == saturday  && y === c_date.getFullYear() && m > c_date.getMonth()){
                            span.classList.add('weekend');
                        }
                    });
                    sun.forEach(function(saturday) {
                        if(date == saturday  && y === c_date.getFullYear() && m > c_date.getMonth()){
                            span.classList.add('weekend');
                        }
                    });
                    sun.forEach(function(saturday) {
                        if(date == saturday  && y === c_date.getFullYear() && m === c_date.getMonth()){
                            span.classList.add('weekend');
                        }
                    });
                    // End holiday saturday,sunday

                    //resubmission
                    if ({!!  json_encode($request->booking_schedule->appointment_date) !!} != null && {!!  json_encode($request->Status_app) !!} == {!!  json_encode(resubmission) !!}){
                        if({!!  json_encode($request->booking_schedule->appointment_date) !!} != null && date == {!!  json_encode(date("d", strtotime($request->booking_schedule->appointment_date))) !!}  && y == {!!  json_encode(date("Y", strtotime($request->booking_schedule->appointment_date))) !!} &&  m == {!!  json_encode(date("m", strtotime($request->booking_schedule->appointment_date))-1) !!}){
                            span.classList.add('choice_order_date');
                        }
                    }
                    //End resubmission

                    cell.appendChild(span).appendChild(cellText);
                    row.appendChild(cell);
                    date++;
                }
            }

                table.appendChild(row);
        }



    }
        if ({!!  json_encode($request->booking_schedule->appointment_date) !!} != null && {!!  json_encode($request->Status_app) !!} == {!!  json_encode(resubmission) !!}){
            //resubmission
            var m = {!!  json_encode(date("n", strtotime($request->booking_schedule->appointment_date))-1) !!};
            var y = parseInt({!!  json_encode(date("Y", strtotime($request->booking_schedule->appointment_date))) !!});
            $('.showEvent').removeClass('active');
            $('#event').removeClass('d-none');
            //End resubmission
            renderCalendar(m, y)
        }else{
            renderCalendar(month, year)
        }

    $(function(){
        function showEvent(eventDate){
            let storedEvents = JSON.parse(localStorage.getItem('events'));
            if (storedEvents == null){
                $('.events-today').html('<h5 class="text-center">No events found</h5 class="text-center">');
            }else{
                let eventsToday = storedEvents.filter(eventsToday => eventsToday.eventDate === eventDate);
                let eventsList = Object.keys(eventsToday).map(k => eventsToday[k]);
                if(eventsList.length>0){
                    let eventsLi ='';
                    eventsList.forEach(event =>  $('.events-today').html(eventsLi +=`<div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ${event.eventText}
                    <button type="button" class="close remove-event" data-event-id="${event.id}" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>`));
                }else{
                    $('.events-today').html('<h5 class="text-center">No events found</h5 class="text-center">');
                }
            }
        }
        function removeEvent(id){
            let storedEvents = JSON.parse(localStorage.getItem('events'));
            if(storedEvents != null){
                storedEvents = storedEvents.filter( ev => ev.id != id );
                localStorage.setItem('events', JSON.stringify(storedEvents));
                $('.toast-body').html('Your event have been removed');
                $('.toast').toast('show');
            }
        }
        $(document).on('click', '.remove-event', function(){
            let eventId = $(this).data('event-id');
            removeEvent(eventId);
        })

        $(document).on('click', '.prevMonth', function(){
            year = (month === 0) ? year - 1 : year;
            month = (month === 0) ? 11 : month - 1;
            renderCalendar(month, year);
        })
        $(document).on('click', '.nextMonth', function(){
            year = (month === 11) ? year + 1 : year;
            month = (month + 1) % 12;
            renderCalendar(month, year);
        })

        $(document).on('click', '.showEvent', function(){
            $('.showEvent').removeClass('active');
            $('#event').removeClass('d-none');
            $(this).addClass('active');
            let todaysDate = $(this).text() + ' ' + (months[month]) + ' ' + year;
            let eventDay = days[new Date(year, month, $(this).text()).getDay()];
            let eventDate = $(this).text() + month + year;
            // $('.event-date').html(todaysDate).data('eventdate', eventDate);
            // $('.event-day').html(eventDay);
            validate_limit_schedule(todaysDate);
            $('#view_date').val(todaysDate);
            showEvent(eventDate);
        })

        //resubmission
        if ({!!  json_encode($request->booking_schedule->appointment_date) !!} != null && {!!  json_encode($request->Status_app) !!} == {!!  json_encode(resubmission) !!}){
            let todaysDate = {!!  json_encode(date("d", strtotime($request->booking_schedule->appointment_date))) !!} + ' ' + (months[month]) + ' ' + year;
            validate_limit_schedule(todaysDate);
            $('#view_date').val(todaysDate);
        }
        //End resubmission
        function validate_limit_schedule(eventDate) {
            $.ajax({
                url: "{{ url('/ajax/cek/data/limit/schedule') }}",
                type: 'POST',
                /* send the csrf-token and the input to the controller */
                data: {_token: $('meta[name="csrf-token"]').attr('content'), eventDate:eventDate},
                success: function (data) {
                    $('#veiw_time_schedule').html(data);
                }
            });
        }
        $(document).on('click', '.hide', function(){
            $('#event').addClass('d-none');
        })
        $(document).on('click', '#createEvent', function(){
            let events = localStorage.getItem('events');
            let obj = [];
            if (events) {
                obj = JSON.parse(events);
            }
            let eventDate = $('.event-date').data('eventdate');
            let eventText = $('#eventTxt').val();
            let valid = false;
            $('#eventTxt').removeClass('data-invalid');
            $('.error').remove();
            if (eventText == ''){
                $('.events-input').append(`<span class="error">Please enter event</span>`);
                $('#eventTxt').addClass('data-invalid');
                $('#eventTxt').trigger('focus');
            }else if(eventText.length < 3){
                $('#eventTxt').addClass('data-invalid');
                $('#eventTxt').trigger('focus');
                $('.events-input').append(`<span class="error">please enter at least three characters</span>`);
            }else{
                valid = true;
            }
            if (valid){
                let id =1;
                if (obj.length > 0) {
                    id = Math.max.apply('', obj.map(function (entry) { return parseFloat(entry.id); })) + 1;
                }
                else {
                    id = 1;
                }
                obj.push({
                    'id' : id,
                    'eventDate': eventDate,
                    'eventText': eventText
                });
                localStorage.setItem('events', JSON.stringify(obj));
                $('#eventTxt').val('');
                $('.toast-body').html('Your event have been added');
                $('.toast').toast('show');
                showEvent(eventDate);
            }
        })
    })
</script>
@endsection
