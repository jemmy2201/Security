@extends('layouts.app_admin')
<style>
    .datatableCeate{
        margin: 10px 0px 0px 10px;
    }
</style>
@section('content')
<div class="container navbar-light navbar-white">
        <form id="FormChangePass">
            @csrf
            <div class="form-group">
                <label>Password Old</label>
                <input type="password" class="form-control" id="pass_old" name="pass_old" placeholder="Password Old" required>
                    <a href="#" id="showoldpass" style="float: right; display: inline; color: black;"><span class="fa fa-eye" id="eyeoldpass" style="margin: -26px;"></span></a>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" class="form-control" id="pass_new" name="pass_new" placeholder="New Password" required>
                <a href="#" id="shownewpass" style="float: right; display: inline; color: black;"><span class="fa fa-eye" id="eyenewpass" style="margin: -26px;"></span></a>
            </div>
            <div class="form-group">
                <label>Repeat Password</label>
                <input type="password" class="form-control" id="pass_repeat" name="pass_repeat" placeholder="Repeat Password" required>
                <a href="#" id="showpassconfirm" style="float: right; display: inline; color: black;"><span class="fa fa-eye" id="eyepassconfirm" style="margin: -26px;"></span></a>
            </div>
            <div class="form-group">
                <button type="submit" style="background-color: #E01E37;width:100%;font-size:16px" class="btn btn-secondary btn-lg"><b>update</b></button>
            </div>
        </form>
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
        $("#FormChangePass").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.
            var form = $(this);
            if ($("#pass_new").val() ==$("#pass_repeat").val()){
                $.ajax({
                type: "POST",
                url: "{{route('admin.change.password')}}",
                data: form.serialize(), // serializes the form's elements.
                success: function(data,textStatus, xhr)
                    {
                            if (data == @php echo not_find_pass @endphp){
                                swal("Error!", "Wrong Password old", "error");
                            }else{
                                swal("Success !", "Update Password", "success");
                                location.reload();
                            };

                    }
                });
            }else{
                swal("Error!", "passwords are not the same", "error");
            }
        });

        $(document).on("click", "#shownewpass", function(){
            var pass = document.getElementById("pass_new");
            var eye = document.getElementById("eyenewpass");
            if (pass.type === "password") {
                pass.setAttribute("type", "text");
                eye.setAttribute("class", "fa fa-eye-slash");
            } else {
                pass.setAttribute("type", "password");
                eye.setAttribute("class", "fa fa-eye");
            }
        });
        $(document).on("click", "#showoldpass", function(){
            var pass = document.getElementById("pass_old");
            var eye = document.getElementById("eyeoldpass");
            if (pass.type === "password") {
                pass.setAttribute("type", "text");
                eye.setAttribute("class", "fa fa-eye-slash");
            } else {
                pass.setAttribute("type", "password");
                eye.setAttribute("class", "fa fa-eye");
            }
        });
        $(document).on("click", "#showpassconfirm", function(){
            var pass = document.getElementById("pass_repeat");
            var eye = document.getElementById("eyepassconfirm");
            if (pass.type === "password") {
                pass.setAttribute("type", "text");
                eye.setAttribute("class", "fa fa-eye-slash");
            } else {
                pass.setAttribute("type", "password");
                eye.setAttribute("class", "fa fa-eye");
            }
        });

    </script>
@endsection
