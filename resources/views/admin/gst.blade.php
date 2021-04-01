@extends('layouts.app_admin')
<style>
    .datatableCeate{
        margin: 10px 0px 0px 10px;
    }
</style>
@section('content')
    <div class="container">
        <div class=" navbar-light navbar-white">
            <table id="table_gst" class="table table-striped table-bordered dt-responsive nowrap">
                <thead>
                <tr>
                    <th scope="col">Create Time</th>
                    <th scope="col">Amount GST</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            {{-- Modal --}}
            <div class="modal fade" id="FormGst" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content" style="font-family: sans-serif">
                        <div class="modal-header" style="justify-content: center !important;border-bottom:0px">
                            <h5 class="modal-title" style="font-size: 25px;font-weight:600" id="ExerciseModalLabel"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form  style="font-weight:600;margin-left:31px;margin-right:31px;color:#595959" id="FormGstCreate">
                                @csrf
                                <div class="mb-3 " >
                                    <label for="status" class="col-form-label">Amount GST</label>
                                    <input name="amount_gst" type="text" class="form-control form-control-lg"  id="amount_gst" required>
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
            table_gst = $('#table_gst').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                dom: 'Bfrtip',
                buttons: [
                    {
                        text: 'Add Gst',
                        className: 'buttontable btn btn-light datatableCeate',
                        action: function ( e, dt, node, config ) {
                            $('#FormGst').modal('show');
                        }
                    }
                ],
                "ajax": {
                    "url": "{{route('admin.data.gst')}}",
                    "global": false,
                    "type": "POST",
                    "headers": {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                },
                columns: [
                    {data: 'create_date', name: 'create_date'},
                    {data: 'amount_gst', name: 'amount_gst'},
                ]
            });
        });
        $("#FormGstCreate").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            var url = "{{route('admin.create.gst')}}";
            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(), // serializes the form's elements.
                success: function(data,textStatus, xhr)
                {
                    table_gst.ajax.reload();
                    $('#FormGst').modal('hide');
                }
            });

        });

    </script>
@endsection
