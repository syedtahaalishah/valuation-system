@extends('layouts.auth')
@section('title', 'Property Valuation - Register')
@section('content')
    <div class="container">
        <div class="card o-hidden my-5 border-0 shadow-lg">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 mb-4 text-gray-900">Create an Account!</h1>
                            </div>
                            <form action="{{ route('register') }}" method="post" id="ajaxform" class="user">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-sm-0 mb-3">
                                        <input type="text" name="first_name" id="first_name"
                                            class="form-control form-control-user" placeholder="First Name">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="last_name" id="last_name"
                                            class="form-control form-control-user" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="email" id="email"
                                        class="form-control form-control-user" placeholder="Email Address">
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-sm-0 mb-3">
                                        <input type="text" name="reac_number" id="reac_number"
                                            class="form-control form-control-user" placeholder="REAC Number">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="phone_number" id="phone_number"
                                            class="form-control form-control-user" placeholder="Phone Number">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-sm-0 mb-3">
                                        <input type="password" name="password" id="password"
                                            class="form-control form-control-user" placeholder="Password">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" name="password_confirmation" id="password_confirmation"
                                            class="form-control form-control-user" placeholder="Confirm Password">
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-user btn-block">
                                    Register Account
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
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

                    if (response.status === 201) {
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
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
