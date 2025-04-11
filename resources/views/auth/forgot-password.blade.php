@extends('layouts.auth')
@section('title', 'Property Valuation - Forgot Password')
@section('content')
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden my-5 border-0 shadow-lg">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 mb-2 text-gray-900">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <form action="{{ route('password.email') }}" method="post" id="ajaxform" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" name="email" id="email" class="form-control form-control-user" placeholder="Email Address">
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block">
                                            Reset Password
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="{{ route('login') }}">Back to login</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.8/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js"></script>
    <script>
        $.LoadingOverlaySetup({
            background: "rgba(0, 0, 0, 0.5)",
            imageColor: "#140a62"
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

                    $(".input-error").remove();

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
                        $(".input-error").remove();
                        $.each(error.response.data.errors, function(key, value) {

                            key = key.replace(/\.(\d+)\./g, "-$1-");
                            key = $('#' + key);
                            key.after(
                                '<small class="input-error text-danger">' + value[0] + "</small>"
                            );

                        });
                    } else {
                        Swal.fire({
                            timer: 3000,
                            icon: 'error',
                            iconColor: '#140a62',
                            showConfirmButton: false,
                            text: error.response.data.message,
                        })
                    }
                })
                .finally(() => {
                    $.LoadingOverlay("hide");
                });
        });
    </script>
@endpush
