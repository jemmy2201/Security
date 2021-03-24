@extends('layouts.app_admin')

<style>
    .HeaderdataPersonal{
        color:#808080;
        font-size: 24px;
    }
    .ColoumndataPersonal{
        font-weight: bold;
        font-size: 24px;
    }
</style>
@section('content')
<div class="container">
    <div class="row navbar-light navbar-white">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">NRIC / FIN</th>
                <th scope="col">Time Login</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row">1</th>
                <td>TRICIA TAN XIAO HUI</td>
                <td>myinfotesting@gmail.com</td>
                <td>T1872646D</td>
                <td>2021-03-24</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<script type="application/javascript">
</script>
@endsection
