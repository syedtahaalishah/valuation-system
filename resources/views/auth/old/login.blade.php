@extends('layouts.app')
@section('title', 'Neurastem - Sign in')
@section('content')
    <div class="row">
        <div class="col-lg-12 col-xl-6  column-overflow my-col-1 padd-y-3rem">
            <div class="custom-padding">
                <div class="text-center mb-4">
                    <h2 class="form-heading">Sign in to your account</h2>
                </div>
                <form action="{{ route('login') }}" method="post" id="ajaxform">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="inputs">
                                <label for="">
                                    <span>Email</span>
                                    <input type="text" name="email" id="email" class="form-control" placeholder="Username or Email Address">
                                </label>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="inputs">
                                <label for="">
                                    <span>Password</span>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="mt-2 d-flex justify-content-between pages-switch">
                        <p class="bottom-para login-para">New here? <a href="{{ route('register') }}">Create an account!</a></p>
                        <p class="bottom-para login-para">Forgot Your Password?<a href="{{ route('password.email') }}"> Click here</a></p>
                    </div>
                    <div class="auth-buttons mt-5">
                        <button type="submit">
                            Sign In
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-6  p-0 column-img-sect my-col-2">
            <img class="img-sect-1" src="{{ asset('assets/images/signin-page.png') }}" />
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
