@extends('layouts.app')
@section('title', 'Neurastem - Forgot Password')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-xl-6 my-col-1 column-overflow">
            <div class="text-webkit-center">
                <div class="custom-padding-2 forget-padding">
                    <div class="text-center mb-4">
                        <h2 class="form-heading">Forgot Password</h2>
                    </div>
                    <div>
                        <p class="send-code-para">Insert your <strong style="color:#515151;">Email Address</strong>
                            associated with your account then you will receive a verification code for password recovery</p>
                    </div>

                    <form action="{{ route('password.email') }}" method="post" id="ajaxform">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="inputs">
                                    <label for="">
                                        <input type="text" name="email" id="email" class="form-control" placeholder="Email address">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="auth-buttons mt-2 send-code-button">
                            @csrf
                            <button type="submit">
                                Submit
                            </button>
                        </div>
                    </form>
                    <div class="mt-2 d-flex justify-content-center pages-switch">
                        <p class="bottom-para">Remember password?<a href="{{ route('login') }}"> Login!</a></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 column-img-sect my-col-2">
            <img class="img-sect-1" src="{{ asset('assets/images/forget-pass.png') }}" />
        </div>
    </div>
@endsection


@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.8/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
<script>
    $.LoadingOverlaySetup({
        background      : "rgba(0, 0, 0, 0.5)",
        imageColor      : "#140a62"
    });

    $(document).on("submit", "#ajaxform", function(e) {

        e.preventDefault();
        var form = jQuery(this);
        var url = form.attr("action");
        var method = form.attr("method");
        var data = new FormData(form[0]);

        $.LoadingOverlay("show");

        axios({
            method: method,
            url: url,
            data: data,
        })
        .then(function(response) {

            $(".error").remove();

            if (response.data.message) {
                Swal.fire({
                    timer: 3000,
                    icon: 'success',
                    iconColor: '#140a62',
                    showConfirmButton: false,
                    text: response.data.message,
                })

                form[0].reset();
            }
        })
        .catch(function(error) {

            if (error.response.status === 422) {
                $(".error").remove();
                $.each(error.response.data.errors, function(key, value) {

                    key = key.replace(/\.(\d+)\./g, "-$1-");
                    key = $('#' + key);
                    key.after(
                        '<small class="error text-danger">' + value[0] + "</small>"
                    );

                });
            } else {

                Swal.fire({
                    timer: 3000,
                    icon: 'error',
                    iconColor: '#140a62',
                    text: 'Something went wrong, please try again',
                    showConfirmButton: false,
                })
            }
        })
        .finally(() => {
            $.LoadingOverlay("hide");
        });
    });
</script>
@endpush
