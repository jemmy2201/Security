@extends('layouts.app_admin')

@section('content')
<div class="container">
    <div class="navbar-light navbar-white">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="table_security_employees">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">NRIC / FIN</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Application Type</th>
                <th scope="col">Request Application</th>
                <th scope="col">Grade</th>
                <th scope="col">Expired Date</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>

@endsection
@section('js')
    <script type="application/javascript">
        $(window).bind('resize', function(e)
        {
            this.location.reload(false); /* false to get page from cache */
            /* true to fetch page from server */
        });
        $(document).ready(function(){
            table_security_employees = $('#table_security_employees').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                // dom: 'Bfrtip',
                "ajax": {
                    "url": "{{route('admin.security.employees')}}",
                    "global": false,
                    "type": "POST",
                    "headers": {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                },
                columns: [
                    {data: 'action', name: 'action',orderable: false, searchable: false},
                    {data: 'nric', name: 'nric'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
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
                            if(data != null ){
                                return row.name_grade;
                            }else{
                                return '-';
                            }
                        }
                    },
                    {data: 'expired_date', name: 'expired_date'},
                ]
            });

            $('#table_security_employees').on('click', 'a.photo', function (e) {
                e.preventDefault();
                let rowData = table_security_employees.row($(event.target).parents('tr')).data();
                $(this).magnificPopup({
                    items: {
                        src: '{{asset('img/img_users')}}/'+rowData.photo
                    },
                    type: 'image' // this is default type
                });


            });
        });
    </script>
@endsection
