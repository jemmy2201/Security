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
                <th scope="col">NRIC</th>
                <th scope="col">Name</th>
                <th scope="col">Appication Type</th>
                <th scope="col">Card Type</th>
                <th scope="col">Grade Type</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        {{-- Modal --}}
        <div class="modal fade" id="FormUpload" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                               <input type="file" class="form-control form-control-lg">
                            </div>
                            <div class="mb-3">
                                <button type="submit" id="save" style="background-color: #E01E37;font-size:16px" class="btn btn-secondary btn-lg btn-block"><b>Save</b></button>
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
                        "url": "{{route('admin.data.upgrade')}}",
                        "global": false,
                        "type": "POST",
                        "headers": {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    },
                    columns: [
                        {data: 'nric', name: 'nric'},
                        {data: 'name', name: 'name'},
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
                        {data: 'card_id', name: 'card_id',
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
                        {data: 'grade_id', name: 'grade_id',
                            render: function (data, type, row) {
                                if(data == @php echo so @endphp){
                                    return 'SO';
                                }else if(data == @php echo sso @endphp){
                                    return 'SSO';
                                }else if(data == @php echo sss @endphp){
                                    return 'SSS';
                                }else{
                                    return  '-';
                                }
                            }
                        },
                    ]
                });
            });

        $("#FormUpload").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);

            var url = "{{route('admin.insert.price')}}";

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

        });


    </script>
@endsection
