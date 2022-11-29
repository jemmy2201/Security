@extends('layouts.app')
<style>
    .disabled{
        font-weight: normal;
    }
    @media (min-width :768px) {
        .modal-dialog {
            width: 968px !important;
        }
        #view_terms {
            width: 900px;
        }
        #ViewFormUploadFile{
            margin-top: 225px;
        }
    }
    @media (min-width :576px) {
        .modal-dialog {
            max-width: 930px !important;
        }
        #view_terms {
            width: 900px;
        }

    }

    @media only screen and (max-width: 600px) {
        #view_terms {
            width: 300px;
        }
    }

</style>
@section('content')
    <div class="container">
        <form  method="POST" action="{{ route('landing_page_passID') }}" id="formPassID">
            @csrf
        <div class="row align-items-start">
            <div class="col-0" style="margin-top: 6px">
                <b>Enter PassID</b>
            </div>
            <div class="col-3 ">
                <input type="text" name="passid" id="passid" class="form-control form-control-lg" >
            </div>
        <div class="col-0">
                <button type="button"  style="background-color: black;" id="next" class="btn btn-secondary ">
                    <b>Next</b>
                </button>
            </div>
        </div>
        </form>
    </div>
    <script>
        $( document ).ready(function() {
            $('#next').on('click', function () {
                if ($('#passid').val()) {
                    $.ajax({
                        url: "{{ url('/ajax/check/passID') }}",
                        type: 'POST',
                        /* send the csrf-token and the input to the controller */
                        data: {_token: $('meta[name="csrf-token"]').attr('content'), passid:$('#passid').val()},
                        success: function (data) {
                            if (data['massages'] == {!! json_encode(succes) !!}){
                                $("#formPassID").submit();
                            }else{
                                swal("Attention!", "Pass ID not found", "error")
                            }
                        }
                    });

                }else{
                    swal("Error!", "Please input PassID.", "error")
                }
            });
        });

    </script>

@endsection
