@extends('layouts.app_admin')
<style>
    .datatableCeate{
        margin: 10px 0px 0px 10px;
    }
</style>
@section('content')
<div class="container">
    <div class=" navbar-light navbar-white">
        <table id="table_limit_schedule" class="table table-striped table-bordered dt-responsive nowrap"  >
            <thead>
            <tr>
                <th scope="col">Start at</th>
                <th scope="col">End at</th>
                <th scope="col">Amount</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        {{-- Modal --}}
        <div class="modal fade" id="ModalFormLimitSchedule" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="font-family: sans-serif">
                    <div class="modal-header" style="justify-content: center !important;border-bottom:0px">
                        <h5 class="modal-title" style="font-size: 25px;font-weight:600" id="ExerciseModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form  style="font-weight:600;margin-left:31px;margin-right:31px;color:#595959" id="FormLimitSchedule">
                            @csrf
                            <div class="row" id="UpdateAllLimitSchedule">
                                <div class="col">
                                    <label for="location" class="col-form-label">Start at</label>
                                    <select class="form-control" id="start_at" name="start_at[]" required>
                                        <option selected>Please choose</option>
                                        <option value="@php echo time08 @endphp">@php echo time08 @endphp</option>
                                        <option value="@php echo time09 @endphp">@php echo time09 @endphp</option>
                                        <option value="@php echo time10 @endphp">@php echo time10 @endphp</option>
                                        <option value="@php echo time11 @endphp">@php echo time11 @endphp</option>
                                        <option value="@php echo time12 @endphp">@php echo time12 @endphp</option>
                                        <option value="@php echo time13 @endphp">@php echo time13 @endphp</option>
                                        <option value="@php echo time14 @endphp">@php echo time14 @endphp</option>
                                        <option value="@php echo time15 @endphp">@php echo time15 @endphp</option>
                                        <option value="@php echo time16 @endphp">@php echo time16 @endphp</option>
                                        <option value="@php echo time17 @endphp">@php echo time17 @endphp</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="location" class="col-form-label">End at</label>
                                    <select class="form-control" id="end_at" name="end_at[]" required>
                                        <option selected>Please choose</option>
                                        <option value="@php echo time08 @endphp">@php echo time08 @endphp</option>
                                        <option value="@php echo time09 @endphp">@php echo time09 @endphp</option>
                                        <option value="@php echo time10 @endphp">@php echo time10 @endphp</option>
                                        <option value="@php echo time11 @endphp">@php echo time11 @endphp</option>
                                        <option value="@php echo time12 @endphp">@php echo time12 @endphp</option>
                                        <option value="@php echo time13 @endphp">@php echo time13 @endphp</option>
                                        <option value="@php echo time14 @endphp">@php echo time14 @endphp</option>
                                        <option value="@php echo time15 @endphp">@php echo time15 @endphp</option>
                                        <option value="@php echo time16 @endphp">@php echo time16 @endphp</option>
                                        <option value="@php echo time17 @endphp">@php echo time17 @endphp</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="location" class="col-form-label">Amount</label>
                                    <input name="amount[]" type="text" class="form-control"  id="amount" required>
                                </div>
                                <div class="col-2">
                                    <label for="location" class="col-form-label">action</label>
                                    <button type="button" id="add_more_field" style="background-color: #E01E37;" class="btn btn-danger btn-lg">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                            <div id="add_form_time"></div><br>
                            <div class="mb-3">
                                <button type="submit" id="save" style="background-color: #E01E37;font-size:16px" class="btn btn-secondary btn-lg btn-block"><b>Save</b></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Modal --}}

        {{-- Modal Update --}}
        <div class="modal fade" id="ModalFormUpdateLimitSchedule" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="font-family: sans-serif">
                    <div class="modal-header" style="justify-content: center !important;border-bottom:0px">
                        <h5 class="modal-title" style="font-size: 25px;font-weight:600" id="ExerciseModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form  style="font-weight:600;margin-left:31px;margin-right:31px;color:#595959" id="FormUpdateLimitSchedule">
                            @csrf
                            <div class="mb-3 " >
                                <label for="status" class="col-form-label">Amount</label>
                                <input name="update_id" type="hidden" class="form-control form-control-lg"  id="update_id">
                                <input name="amount_update" type="text" class="form-control form-control-lg"  id="amount_update">
                            </div>
                            <div class="mb-3">
                             <button type="submit" id="update" style="background-color: #E01E37;width:100%;font-size:16px" class="btn btn-secondary btn-lg"><b>update</b></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        {{-- End Modal Update --}}
    </div>


</div>

@endsection
@section('js')
    <!-- DataTables -->
    <script type="application/javascript">
        $(document).ready(function() {
            var max_fields      = 10; //maximum input boxes allowed
            var wrapper   		= $("#add_form_time"); //Fields wrapper
            var add_button      = $("#add_more_field"); //Add button ID

            var x = 1; //initlal text box count
            $(add_button).click(function(e){ //on add input button click
                e.preventDefault();
                if(x < max_fields){ //max input box allowed
                    x++; //text box increment
                    $(wrapper).append('<div class="row" id="form_time1">\n' +
                        '                                <div class="col">\n' +
                        '                                    <label for="location" class="col-form-label"></label>\n' +
                        '                                    <select class="form-control" id="start_at" name="start_at[]" required>\n' +
                        '                                        <option selected>Please choose</option>\n' +
                        '                                        <option value="@php echo time08 @endphp">@php echo time08 @endphp</option>\n' +
                        '                                        <option value="@php echo time09 @endphp">@php echo time09 @endphp</option>\n' +
                        '                                        <option value="@php echo time10 @endphp">@php echo time10 @endphp</option>\n' +
                        '                                        <option value="@php echo time11 @endphp">@php echo time11 @endphp</option>\n' +
                        '                                        <option value="@php echo time12 @endphp">@php echo time12 @endphp</option>\n' +
                        '                                        <option value="@php echo time13 @endphp">@php echo time13 @endphp</option>\n' +
                        '                                        <option value="@php echo time14 @endphp">@php echo time14 @endphp</option>\n' +
                        '                                        <option value="@php echo time15 @endphp">@php echo time15 @endphp</option>\n' +
                        '                                        <option value="@php echo time16 @endphp">@php echo time16 @endphp</option>\n' +
                        '                                        <option value="@php echo time17 @endphp">@php echo time17 @endphp</option>\n' +
                        '                                    </select>\n' +
                        '                                </div>\n' +
                        '                                <div class="col">\n' +
                        '                                    <label for="location" class="col-form-label"></label>\n' +
                        '                                    <select class="form-control" id="end_at" name="end_at[]" required>\n' +
                        '                                        <option selected>Please choose</option>\n' +
                        '                                        <option value="@php echo time08 @endphp">@php echo time08 @endphp</option>\n' +
                        '                                        <option value="@php echo time09 @endphp">@php echo time09 @endphp</option>\n' +
                        '                                        <option value="@php echo time10 @endphp">@php echo time10 @endphp</option>\n' +
                        '                                        <option value="@php echo time11 @endphp">@php echo time11 @endphp</option>\n' +
                        '                                        <option value="@php echo time12 @endphp">@php echo time12 @endphp</option>\n' +
                        '                                        <option value="@php echo time13 @endphp">@php echo time13 @endphp</option>\n' +
                        '                                        <option value="@php echo time14 @endphp">@php echo time14 @endphp</option>\n' +
                        '                                        <option value="@php echo time15 @endphp">@php echo time15 @endphp</option>\n' +
                        '                                        <option value="@php echo time16 @endphp">@php echo time16 @endphp</option>\n' +
                        '                                        <option value="@php echo time17 @endphp">@php echo time17 @endphp</option>\n' +
                        '                                    </select>\n' +
                        '                                </div>\n' +
                        '                                <div class="col">\n' +
                        '                                    <label for="location" class="col-form-label"></label>\n' +
                        '                                    <input name="amount[]" type="text" class="form-control"  id="amount" required>\n' +
                        '                                </div>\n' +
                        '                                <div class="col-2">\n' +
                        '                                    <label for="location" class="col-form-label"></label>\n' +
                        '                                    <button type="button" id="add_more_field" style="background-color: #E01E37;" class="btn btn-danger btn-lg remove_field">\n' +
                        '                                        <i class="fa fa-times" aria-hidden="true"></i>\n' +
                        '                                    </button>\n' +
                        '                                </div>\n' +
                        '                            </div>'); //add input box
                }
            });

            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault();
                $("#form_time1").remove(); x--;
            })
        });
        $(window).bind('resize', function(e)
        {
            this.location.reload(false); /* false to get page from cache */
            /* true to fetch page from server */
        });
        $(document).ready(function(){
            table_limit_schedule = $('#table_limit_schedule').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            text: 'Update Limit Schedule',
                            className: 'buttontable btn btn-light datatableCeate',
                            action: function ( e, dt, node, config ) {
                                $("#ModalFormLimitSchedule").modal("show");
                            }
                        }
                    ],
                    "ajax": {
                        "url": "{{route('admin.data_limit_shedule')}}",
                        "global": false,
                        "type": "POST",
                        "headers": {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    },
                    columns: [
                        {data: 'start_at', name: 'start_at'},
                        {data: 'end_at', name: 'end_at'},
                        {data: 'amount', name: 'amount'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
            });
        $('#table_limit_schedule').on('click', 'a.editor_edit', function (e) {
            e.preventDefault();
            $("#ModalFormUpdateLimitSchedule").modal("show");
            let rowData = table_limit_schedule.row($(event.target).parents('tr')).data();
            $("#amount_update").val(rowData.amount);
            $("#update_id").val(rowData.id);
        });

        $("#FormUpdateLimitSchedule").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var url = "{{route('admin.update.limit_schedule')}}";
            var form = $(this);
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data,textStatus, xhr) {
                    table_limit_schedule.ajax.reload();
                    $("#ModalFormUpdateLimitSchedule").modal("hide");
                }
            });
        });

        $("#FormLimitSchedule").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var url = "{{route('admin.insert.limit_schedule')}}";
            var form = $(this);
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data,textStatus, xhr)
                {
                    if (data == @php echo start_empty @endphp){
                        swal("Error!", "blank start time data", "error");
                    }else if (data == @php echo end_empty @endphp){
                        swal("Error!", "blank end time data", "error");
                    }else if (data == @php echo data_has_been_used_in_the_booking_schedule @endphp){
                        swal("Error!", "data has been used in the booking schedule, please try tomorrow", "error");
                    }else{
                        table_limit_schedule.ajax.reload();
                        $("#ModalFormLimitSchedule").modal("hide");
                    }
                }
            });
        });
    </script>
@endsection
