@extends('layouts.app_admin')
<style>
    .datatableCeate{
        margin: 10px 0px 0px 10px;
    }
</style>
@section('content')
<div class="container">
    <div class=" navbar-light navbar-white">
        <table id="table_grade" class="table table-striped table-bordered dt-responsive nowrap">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Name</th>
                <th scope="col">Grade Type</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        {{-- Modal --}}
        <div class="modal fade" id="FormUAddCourse" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" >
            <div class="modal-dialog">
                <div class="modal-content" style="font-family: sans-serif">
                    <div class="modal-header" style="justify-content: center !important;border-bottom:0px">
                        <h5 class="modal-title" style="font-size: 25px;font-weight:600" id="ExerciseModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form style="font-weight:600;margin-left:31px;margin-right:31px;color:#595959" id="FormAddCourse" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="col-form-label">Name</label>
                               <input type="text" name="name" id="name" class="form-control form-control-lg">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="col-form-label">Grade Type</label>
                                <select class="form-control" id="type" name="type">
                                    <option value="Please choose">Please choose</option>
                                    <option value="@php echo so @endphp">SO</option>
                                    <option value="@php echo sso @endphp">SSO</option>
                                    <option value="@php echo ss @endphp">SS</option>
                                    <option value="@php echo sss @endphp">SSS</option>
                                    <option value="@php echo cso @endphp">CSO</option>
                                </select>
                            </div>
                            <input type="hidden" name="validasi_url" id="validasi_url">
                            <input type="hidden" name="id_grade" id="id_grade">
                            <div class="mb-3">
                                <button type="submit" id="save" style="background-color: #E01E37;font-size:16px" class="btn btn-secondary btn-lg btn-block"><b>Save</b></button>
                                <button type="submit" id="update" style="background-color: #E01E37;font-size:16px" class="btn btn-secondary btn-lg btn-block"><b>Update</b></button>
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
            $.fn.dataTable.ext.errMode = 'none';
            table_grade = $('#table_grade').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            text: 'Add Course',
                            className: 'buttontable btn btn-light datatableCeate',
                            action: function ( e, dt, node, config ) {
                                $('#FormUAddCourse').modal('show');
                                $("#validasi_url").val(@php echo save @endphp);
                                $("#save").css("display", "block");
                                $("#update").css("display", "none");
                            }
                        }
                    ],
                    "ajax": {
                        "url": "{{route('admin.data.course')}}",
                        "global": false,
                        "type": "POST",
                        "headers": {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    },
                    columns: [
                        {data: 'id', name: 'id'},
                        {data: 'name', name: 'name'},
                        {data: 'type', name: 'type',
                            render: function (data, type, row) {
                            if(data == @php echo so @endphp){
                                    return "SO";
                            }else if(data == @php echo sso @endphp){
                                    return "SSO";
                            }else if(data == @php echo ss @endphp){
                                    return "SS";
                            }else if(data == @php echo sss @endphp){
                                    return "SSS";
                            }else if(data == @php echo cso @endphp){
                                    return "CSO";
                            }else{
                                    return '-';
                            }}
                        },
                        {data: 'action', name: 'action'},
                    ]
                });
        });

        $("#FormAddCourse").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            if($("#validasi_url").val() == @php echo save @endphp){
                var url = "{{route('admin.insert.course')}}";
            }else{
                var url = "{{route('admin.update.course')}}";
            }

            var form = $(this);
            var form_data = new FormData(document.getElementById("FormAddCourse"));
            form_data.append("_token", "{{ csrf_token() }}");
            form_data.append("id", $("#id_grade").val());
            if($("#type").val() == "Please choose"){
                alert("Please choose Grade type"); // show response from the php script.
            }else{
                $.ajax({
                type: "POST",
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                url: url,
                data: form_data, // serializes the form's elements.
                success: function(data,textStatus, xhr)
                {
                    if (data['error'] == false){
                        table_grade.ajax.reload();
                        $('#FormUAddCourse').modal('hide');
                    }else{
                        swal("Error!", "the data already exists", "error");
                    }

                }, error: function(data,textStatus, xhr){
                    // Error...
                }
            });
            }

        });

        // Edit
        $('#table_grade').on('click', 'a.editor_edit', function (e) {
            e.preventDefault();
            let rowData = table_grade.row($(event.target).parents('tr')).data();
            $("#name").val(rowData.name);
            $("#type").val(rowData.type);
            $("#id_grade").val(rowData.id).attr("disabled", true);
            $("#save").css("display", "none");
            $("#update").css("display", "block");
            $('#FormUAddCourse').modal('show');
            $("#validasi_url").val(@php echo update @endphp);
        });
        // End Edit

        // delete
        $('#table_grade').on('click', 'a.delete', function (e) {
            e.preventDefault();
            let rowData = table_grade.row($(event.target).parents('tr')).data();
            swal({
                title: 'Are you sure?',
                text: 'Delete Data!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                    console.log('id',rowData.id)
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: "POST",
                        url: "{{route('admin.delete.course')}}",
                        data: {id: rowData.id},
                        success: function(data,textStatus, xhr)
                        {
                            table_grade.ajax.reload();
                        }
                    });
                }
            });
        });
        // delete


    </script>
@endsection
