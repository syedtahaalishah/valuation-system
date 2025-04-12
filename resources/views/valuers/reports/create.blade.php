@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card mb-4 shadow">
            <div class="card-header py-3">
                <h6 class="font-weight-bold text-primary m-0">Create Report</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('reports.store') }}" class="user" id="ajaxform">
                    @csrf

                    <!-- Location -->
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="location" class="form-label">Location</label>
                            <input type="text" name="location" id="location" class="form-control form-control-user"
                                placeholder="e.g., Gaborone, Block 5">
                        </div>
                    </div>

                    <!-- Suburb and Plot Number -->
                    <div class="form-group row">
                        <div class="col-sm-6 mb-sm-0 mb-3">
                            <label for="suburb" class="form-label">Suburb/Kgotla</label>
                            <input type="text" name="suburb" id="suburb" class="form-control form-control-user"
                                placeholder="e.g., Broadhurst">
                        </div>
                        <div class="col-sm-6">
                            <label for="plot_number" class="form-label">Plot Number</label>
                            <input type="text" name="plot_number" id="plot_number" class="form-control form-control-user"
                                placeholder="e.g., 12345">
                        </div>
                    </div>

                    <!-- Valuation Date and Valuer -->
                    <div class="form-group row">
                        <div class="col-sm-6 mb-sm-0 mb-3">
                            <label for="valuation_date" class="form-label">Valuation Date</label>
                            <input type="date" name="valuation_date" id="valuation_date"
                                class="form-control form-control-user">
                        </div>
                        <div class="col-sm-6">
                            <label for="signing_valuer" class="form-label">Signing Valuer</label>
                            <input type="text" name="signing_valuer" id="signing_valuer"
                                class="form-control form-control-user" placeholder="Full name">
                        </div>
                    </div>

                    <!-- Market Value and Forced Sale Value -->
                    <div class="form-group row">
                        <div class="col-sm-6 mb-sm-0 mb-3">
                            <label for="market_value" class="form-label">Open Market Value (BWP)</label>
                            <input type="number" step="0.01" name="market_value" id="market_value"
                                class="form-control form-control-user" placeholder="0.00">
                        </div>
                        <div class="col-sm-6">
                            <label for="forced_sale_value" class="form-label">Forced Sale Value (BWP)</label>
                            <input type="number" step="0.01" name="forced_sale_value" id="forced_sale_value"
                                class="form-control form-control-user" placeholder="0.00">
                        </div>
                    </div>

                    <!-- GPS Coordinates -->
                    <div class="form-group row">
                        <div class="col-sm-12">
                            <label for="gps_coordinates" class="form-label">GPS Coordinates</label>
                            <input type="text" name="gps_coordinates" id="gps_coordinates"
                                class="form-control form-control-user" placeholder="e.g., -24.658333, 25.908056">
                            <small class="form-text text-muted">Format: latitude, longitude (decimal degrees)</small>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group row mt-4">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary btn-user btn-block py-3">
                                Create
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

                    Swal.fire({
                        timer: 3000,
                        icon: 'success',
                        iconColor: '#140a62',
                        showConfirmButton: false,
                        text: response.data.message,
                    })

                    setTimeout(() => {
                        window.location = "{{ route('reports.index') }}";
                    }, 2000);
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
