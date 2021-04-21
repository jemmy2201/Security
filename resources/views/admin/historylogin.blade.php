@extends('layouts.app_admin')

@section('content')
<div class="container">
    <div class="navbar-light navbar-white">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="table_history_login">
            <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">NRIC / FIN</th>
                <th scope="col">Time Login</th>
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
            table_history_login = $('#table_history_login').DataTable({
                processing: true,
                serverSide: true,
                searching: true,
                // dom: 'Bfrtip',
                "ajax": {
                    {{--"url": "{{route('admin.history.login')}}",--}}
                    "url": "https://solusight.com/training_application_schedule/public/ajax/cek/card/type",
                    "global": false,
                    "type": "POST",
                    "headers": {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                },
                columns: [
                    {data: 'action', name: 'action',orderable: false, searchable: false},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'nric', name: 'nric'},
                    {data: 'time_login_at', name: 'time_login_at'},
                ]
            });

            $('#table_history_login').on('click', 'a.photo', function (e) {
                e.preventDefault();
                let rowData = table_history_login.row($(event.target).parents('tr')).data();
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
