@extends('layouts.app_admin')
<style>
    .datatableCeate{
        margin: 10px 0px 0px 10px;
    }
    #table_holiday_filter{
        padding-top:16px;
    }
</style>
@section('content')
    <div class="container">
        <div class=" navbar-light navbar-white">
            <table id="table_holiday" class="table table-striped table-bordered dt-responsive nowrap">
                <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Name Holiday</th>
                    <th scope="col">Time work Holiday</th>
                    <th width="100px">Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            {{-- Modal --}}
            <div class="modal fade" id="FormHoliday" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="font-family: sans-serif">
                        <div class="modal-header" style="justify-content: center !important;border-bottom:0px">
                            <h5 class="modal-title" style="font-size: 25px;font-weight:600" id="ExerciseModalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form  style="font-weight:600;margin-left:31px;margin-right:31px;color:#595959" id="FormHolidayCreate">
                                @csrf
                                <div class="mb-3" >
                                    <label for="date" class="col-form-label">Date</label>
                                    <input name="date" type="date" class="form-control form-control-lg"  id="date" required>
                                </div>
                                <div class="mb-3">
                                    <label for="title" class="col-form-label">Name Holiday</label>
                                    <input name="name_holiday" type="text" class="form-control form-control-lg"  id="name_holiday" required>
                                </div>
                                <div class="mb-3">
                                    <label for="time_work" class="col-form-label">Time Work</label>
                                    <select class="form-control" id="time_work" name="time_work" required>
                                        <option selected>Please choose</option>
                                        <option value="@php echo full @endphp">Full</option>
                                        <option value="@php echo half @endphp">Half</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <input type="hidden" name="validasi_url" id="validasi_url">
                                    <input type="hidden" name="id" id="id">
                                    <button type="submit" id="save" style="background-color: #E01E37;font-size:16px" class="btn btn-secondary btn-lg btn-block"><b>Save</b></button>
                                    <button type="submit" id="update" style="background-color: #E01E37;width:100%;font-size:16px" class="btn btn-secondary btn-lg"><b>update</b></button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
            {{-- End Modal --}}
        </div>


    </div>

@endsection
@section('js')
    <!-- DataTables -->
    <script type="application/javascript">
        $(window).bind('resize', function(e)
        {
            this.location.reload(false); /* false to get page from cache */
            /* true to fetch page from server */
        });

        $(document).ready(function(){
            table_holiday = $('#table_holiday').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: 'Add Holiday',
                        className: 'buttontable btn btn-light datatableCeate',
                        action: function ( e, dt, node, config ) {
                            $('#FormHoliday').modal('show');
                            $("#date").val("").attr("disabled", false);
                            $("#name_holiday").val("").attr("disabled", false);
                            $("#time_work").val("").attr("disabled", false);
                            $("#update").css("display", "none");
                            $("#save").css("display", "block");
                            $("#validasi_url").val(@php echo save @endphp);
                        }
                    }
                ],
                "ajax": {
                    "url": "{{route('admin.data.holiday')}}",
                    "global": false,
                    "type": "POST",
                    "headers": {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                },
                columns: [
                    {data: 'date', name: 'date'},
                    {data: 'name_holiday', name: 'name_holiday'},
                    {data: 'time_work', name: 'time_work',
                        render: function (data, type, row) {
                            if(data == @php echo full @endphp){
                                    return "FULL";
                            }else if(data == @php echo half @endphp){
                                    return "HALF";
                            }
                        }
                    },
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });

        // edit
        $('#table_holiday').on('click', 'a.editor_edit', function (e) {
            e.preventDefault();
            let rowData = table_holiday.row($(event.target).parents('tr')).data();
            $("#id").val(rowData.id);
            $("#date").val(rowData.date).attr("disabled", true);
            $("#name_holiday").val(rowData.name_holiday);
            $("#time_work").val(rowData.time_work);

            $("#save").css("display", "none");
            $("#update").css("display", "block");
            $('#FormHoliday').modal('show');
            $("#validasi_url").val(@php echo update @endphp);
        });
        // end edit

        // delete
        $('#table_holiday').on('click', 'a.delete', function (e) {
            e.preventDefault();
            let rowData = table_holiday.row($(event.target).parents('tr')).data();
            swal({
                title: 'Are you sure?',
                text: 'Delete Data!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                        $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: "{{route('admin.delete.holiday')}}",
                        data: {id: rowData.id},
                        success: function(data,textStatus, xhr)
                        {
                            table_holiday.ajax.reload();
                        }
                    });
                }
            });
        });
        // delete
        $("#FormHolidayCreate").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            if($("#validasi_url").val() == @php echo save @endphp){
                var url = "{{route('admin.insert.holiday')}}";
            }else{
                var url = "{{route('admin.update.holiday')}}";
            }
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize(), // serializes the form's elements.
                        success: function(data,textStatus, xhr)
                        {
                            if (data.error == @php echo data_already_exists @endphp) {
                                swal("Error!", " the data already exists", "error");
                            }else if(xhr.status == "201" || xhr.status == "200"){
                                table_holiday.ajax.reload();
                                $('#FormHoliday').modal('hide');
                            }
                        }
                    });

        });


    </script>
@endsection
