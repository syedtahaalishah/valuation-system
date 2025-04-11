@extends('layouts.app')
@section('title', 'Neurastem - Register')
@section('content')
<div class="row">
    <div class="col-lg-6  column-img-sect my-col-1">
        <img src="{{ asset('assets/images/signup-image.png') }}" class="img-sect-1"/>
    </div>

    <div class="col-lg-12 col-xl-6 column-overflow my-col-1">
        <div class="custom-padding signup-form">
            <div class="text-center mb-4 mt-5">
                <h2 class="form-heading signup-heading">Create Your Account</h2>
            </div>

            <form action="{{ route('register') }}" method="post" id="ajaxform">
                @csrf
                <div class="row mb-3">
                    <div class="col-md-12">
                        <h2>Registration Type</h2>
                    </div>
                    <div class="col-md-6">
                        <div class="inputs">
                            <label for="">
                                <span>Student</span>
                                <input type="radio" name="type" class="form-control" value="0" checked>
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="inputs">
                            <label for="">
                                <span>Teacher</span>
                                <input type="radio" name="type" class="form-control" value="1">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="inputs">
                            <label for="">
                                <span>First Name</span>
                                <input type="text" name="first_name" id="first_name" class="form-control" placeholder="First Name">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="inputs">
                            <label for="">
                                <span>Last Name</span>
                                <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Last Name">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="inputs">
                            <label for="">
                                <span>Username</span>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Username">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="inputs">
                            <label for="">
                                <span>Email</span>
                                <input type="email" name="email" id="email" class="form-control" placeholder="Email Address">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12">
                        <div class="inputs">
                            <label for="">
                                <span>Password</span>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-12">
                        <div class="inputs">
                            <label for="">
                                <span>Confirm Password</span>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="bottom-para">Already have an account? <a href="{{ route('login') }}">Login</a></p>
                </div>
                <div class="auth-buttons mt-5">
                    <button type="submit">Create Account
                        <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </div>
            </form>


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

            if (response.status === 201) {
                setTimeout(() => {
                    window.location = "{{ route('teacher.dashboard.index') }}";
                }, 1000);
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
