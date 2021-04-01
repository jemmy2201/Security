@extends('layouts.app_admin')

@section('content')
<div class="container">
    <div class="navbar-light navbar-white">
        <table class="table table-striped table-bordered dt-responsive nowrap" id="table_history_login">
            <thead>
            <tr>
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
                    "url": "{{route('admin.history.login')}}",
                    "global": false,
                    "type": "POST",
                    "headers": {'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                },
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'nric', name: 'nric'},
                    {data: 'time_login_at', name: 'time_login_at'},
                ]
            });
        });

    </script>
@endsection
