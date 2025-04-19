@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card mb-4 shadow">
            <div class="card-header d-flex align-items-center justify-content-between flex-row py-3">
                <h6 class="font-weight-bold text-primary m-0">Basic Information</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" class="user" id="ajaxform">
                    @csrf

                    <div class="form-group row">
                        <div class="col-sm-6 mb-sm-0 mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control form-control-user"
                                placeholder="e.g., John" value="{{ auth()->user()->first_name }}">
                        </div>
                        <div class="col-sm-6">
                            <label for="plot_number" class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control form-control-user"
                                placeholder="e.g., Doe" value="{{ auth()->user()->last_name }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 mb-sm-0 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" name="email" id="email" class="form-control form-control-user"
                                placeholder="e.g., john@example.com" value="{{ auth()->user()->email }}">
                        </div>
                        <div class="col-sm-6">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number"
                                class="form-control form-control-user" placeholder="e.g., 123-456-7890"
                                value="{{ auth()->user()->phone_number }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-12 mb-sm-0 mb-3">
                            <label for="reac_number" class="form-label">REAC Number</label>
                            <input type="text" class="form-control form-control-user" id="reac_number" name="reac_number"
                                value="{{ auth()->user()->reac_number }}">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group row mt-4">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary btn-user btn-block py-3">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card mb-4 shadow">
            <div class="card-header d-flex align-items-center justify-content-between flex-row py-3">
                <h6 class="font-weight-bold text-primary m-0">Change Password</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.password.update') }}" class="user" id="ajaxform2">
                    @csrf

                    <div class="form-group row">
                        <div class="col-sm-4 mb-sm-0 mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" name="current_password" id="current_password"
                                class="form-control form-control-user" placeholder="Enter current password">
                        </div>
                        <div class="col-sm-4">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" name="new_password" id="new_password"
                                class="form-control form-control-user" placeholder="Enter new password">
                        </div>
                        <div class="col-sm-4">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                class="form-control form-control-user" placeholder="Confirm new password">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group row mt-4">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary btn-user btn-block py-3">
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.8/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
    <script>
        $.LoadingOverlaySetup({
            background: "rgba(0, 0, 0, 0.5)",
            imageColor: "#140a62"
        });

        $(document).on("submit", "#ajaxform, #ajaxform2", function(e) {
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

                    Swal.fire({
                        timer: 3000,
                        icon: 'success',
                        iconColor: '#1cc88a',
                        showConfirmButton: false,
                        text: response.data.message,
                    })

                    if(response.data.reset) {
                        form.trigger('reset');
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
                            iconColor: '#e02d1b',
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
