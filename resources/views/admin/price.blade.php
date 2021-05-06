@extends('layouts.app_admin')
<style>
    .datatableCeate{
        margin: 10px 0px 0px 10px;
    }
</style>
@section('content')
<div class="container">
    <div class=" navbar-light navbar-white">
        <table id="table_price" class="table table-striped table-bordered dt-responsive nowrap">
            <thead>
            <tr>
                <th scope="col">Application</th>
                <th scope="col">Request</th>
                <th scope="col">Grade</th>
                <th scope="col">Amount</th>
                <th width="100px">Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        {{-- Modal --}}
        <div class="modal fade" id="FormPrice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" style="font-family: sans-serif">
                    <div class="modal-header" style="justify-content: center !important;border-bottom:0px">
                        <h5 class="modal-title" style="font-size: 25px;font-weight:600" id="ExerciseModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <form  style="font-weight:600;margin-left:31px;margin-right:31px;color:#595959" id="FormPriceCreate">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="col-form-label">Application type</label>
                                <select class="form-control" id="app_type" name="app_type" required>
                                    <option selected>Please choose</option>
                                    <option value="@php echo news @endphp">New</option>
                                    <option value="@php echo replacement @endphp">Replacement</option>
                                    <option value="@php echo renewal @endphp">Renewal</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="location" class="col-form-label">Card</label>
                                <select class="form-control" id="card_id" name="card_id" required>
                                    <option selected>Please choose</option>
                                    <option value="@php echo so_app @endphp">SO Application</option>
                                    <option value="@php echo avso_app @endphp">AVSO Application</option>
                                    <option value="@php echo pi_app @endphp">PI Application</option>
                                </select>
                            </div>
                            <div class="mb-3 form_grade" style="display: none" >
                                <label for="status" class="col-form-label">Grade</label>
                                <select class="form-control" id="grade_id" name="grade_id">
                                    <option selected>Please choose</option>
{{--                                    @foreach ($grade as $f)--}}
{{--                                        <option value="{{$f->id}}">{{$f->name}}</option>--}}
{{--                                    @endforeach--}}
                                    <option value="@php echo so @endphp">SO</option>
                                    <option value="@php echo sso @endphp">SSO</option>
                                    <option value="@php echo sss @endphp">SSS</option>

                                </select>
                            </div>
                            <div class="mb-3 " >
                                <label for="status" class="col-form-label">Amount</label>
                                <input name="transaction_amount" type="text" class="form-control form-control-lg"  id="transaction_amount" required>
                            </div>
                            <div class="mb-3">
                                <input type="hidden" name="validasi_url" id="validasi_url">
                                <input type="hidden" name="transaction_amounts_id" id="transaction_amounts_id">
                                <input type="hidden" name="grade_type" id="grade_type">
                                <input type="hidden" name="card_type" id="card_type">
                                <input type="hidden" name="app_types" id="app_types">
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
        $( "#card_id" ).change(function() {
            if ($( "#card_id" ).val() == @php  echo so_app @endphp){
                $(".form_grade").css("display", "block");
            }else{
                $(".form_grade").css("display", "none");
            }
        });
        $(document).ready(function(){
                table_price = $('#table_price').DataTable({
                    processing: true,
                    serverSide: true,
                    searching: false,
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            text: 'Add Price',
                            className: 'buttontable btn btn-light datatableCeate',
                            action: function ( e, dt, node, config ) {
                                $('#FormPrice').modal('show');
                                $("#app_type").val("").attr("disabled", false);
                                $("#card_id").val("").attr("disabled", false);
                                $(".form_grade").css("display", "none");
                                $("#grade_id").val("").attr("disabled", false);
                                $("#transaction_amount").val("");
                                $("#update").css("display", "none");
                                $("#save").css("display", "block");
                                $("#validasi_url").val(@php echo save @endphp);
                            }
                        }
                    ],
                    "ajax": {
                        "url": "{{route('admin.data_price')}}",
                        "global": false,
                        "type": "POST",
                        "headers": {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    },
                    columns: [
                        {
                            data: 'app_type', name: 'app_type',
                            render: function (data, type, row) {
                                if(data == @php echo news @endphp){
                                    var data = 'New';
                                    return data;
                                }else if(data ==@php echo replacement @endphp){
                                        var data = 'Replacement';
                                    return data;
                                }else if(data ==@php echo renewal @endphp){
                                    var data = 'Renewal';
                                return data;
                            }
                            }
                        },
                        {data: 'card_type', name: 'card_type',
                            render: function (data, type, row) {
                                if(data == @php echo so_app @endphp){
                                    var data = 'SO Application';
                                    return data;
                                }else if(data ==@php echo avso_app @endphp){
                                        var data = 'AVSO Application';
                                    return data;
                                }else if(data ==@php echo pi_app @endphp){
                                        var data = 'PI Application';
                                    return data;
                                }
                            }
                        },
                        {data: 'grade_type', name: 'grade_type',
                            render: function (data, type, row) {
                                if(data == @php echo so @endphp){
                                    return "SO";
                                }else if(data == @php echo sso @endphp){
                                    return "SSO";
                                }else if(data == @php echo sss @endphp){
                                    return "SSS";
                                }else{
                                    return '-';
                                }
                            }
                        },
                        {data: 'transaction_amount', name: 'transaction_amount'},
                        {data: 'action', name: 'action', orderable: false, searchable: false},
                    ]
                });
            });
            $('#table_price').on('click', 'a.editor_edit', function (e) {
                e.preventDefault();
                let rowData = table_price.row($(event.target).parents('tr')).data();
                $("#app_types").val(rowData.app_type).attr("disabled", true);
                $("#card_id").val(rowData.card_type).attr("disabled", true);
                if (rowData.card_type == @php  echo so_app @endphp){
                    $(".form_grade").css("display", "block");
                }else{
                    $(".form_grade").css("display", "none");
                }

                $("#grade_id").val(rowData.grade_type).attr("disabled", true);
                $("#transaction_amount").val(rowData.transaction_amount);
                $("#transaction_amounts_id").val(rowData.id);
                $("#grade_type").val(rowData.grade_type);
                $("#card_type").val(rowData.card_type);
                $("#app_type").val(rowData.app_type);
                $("#save").css("display", "none");
                $("#update").css("display", "block");
                $('#FormPrice').modal('show');
                $("#validasi_url").val(@php echo update @endphp);
            });
        $("#FormPriceCreate").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            if($("#app_type").val() == "Please choose"){
                alert("Please choose Application type"); // show response from the php script.
            }else  if($("#card_id").val() == "Please choose"){
                alert("Please choose Card"); // show response from the php script.
            }
            if ($( "#card_id" ).val() == @php  echo so_app @endphp){
                if($("#grade_id").val() == "Please choose"){
                alert("Please choose Grade"); // show response from the php script.
            }
        }
            var form = $(this);
            if($("#validasi_url").val() == @php echo save @endphp){
                var url = "{{route('admin.insert.price')}}";
            }else{
                var url = "{{route('admin.update.price')}}";
            }

            if ($("#app_type").val() != "Please choose" && $("#card_id").val() != "Please choose"){
                if($( "#card_id" ).val() == @php  echo so_app @endphp ){
                    if($("#grade_id").val() != "Please choose") {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize(), // serializes the form's elements.
                        success: function(data,textStatus, xhr)
                        {
                            if (data == @php echo data_already_exists @endphp) {
                                swal("Error!", " the data already exists", "error");
                            }else if(xhr.status == "201" || xhr.status == "200"){
                                table_price.ajax.reload();
                                $('#FormPrice').modal('hide');
                            }
                        }
                    });
                }

            }else{
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize(), // serializes the form's elements.
                        success: function(data,textStatus, xhr)
                        {
                            if (data == @php echo data_already_exists @endphp) {
                            swal("Error!", " the data already exists", "error");
                            }else if(xhr.status == "201" || xhr.status == "200"){
                                table_price.ajax.reload();
                                $('#FormPrice').modal('hide');
                            }
                        }
                    });
                }
            }

        });


    </script>
@endsection
