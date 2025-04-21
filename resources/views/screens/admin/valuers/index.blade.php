@extends('layouts.app')
@push('styles')
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    <div class="container-fluid">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card mb-4 shadow">
            <div class="card-header py-3">
                <h6 class="font-weight-bold text-primary m-0">All Valuers</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-bordered table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>REAC No</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.8/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.7/dist/loadingoverlay.min.js">
    </script>
    <script>
        $(document).ready(function() {
            $.LoadingOverlaySetup({
                background: "rgba(0, 0, 0, 0.5)",
                imageColor: "#140a62"
            });

            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.valuers.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'valuer',
                        name: 'valuer'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'phone_number',
                        name: 'phone_number'
                    },
                    {
                        data: 'reac_number',
                        name: 'reac_number'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });
        });

        $(document).on("change", ".status", function() {

            swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: 'Do you confirm your intention to change the status?',
                showCancelButton: true,
                confirmButtonColor: '#4e73df',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: 'No, cancel it!',
            }).then(success => {
                if (success.value) {

                    $.LoadingOverlay("show");

                    axios({
                            method: "POST",
                            url: $(this).data("action"),
                            data: {
                                id: $(this).data("id"),
                                status: $(this).find(":selected").val(),
                            },
                        })
                        .then(function(response) {

                            Swal.fire({
                                timer: 3000,
                                icon: 'success',
                                iconColor: '#1cc88a',
                                showConfirmButton: false,
                                text: response.data.message,
                            })

                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        })
                        .catch(function(error) {

                            Swal.fire({
                                timer: 3000,
                                icon: 'error',
                                iconColor: '#e02d1b',
                                showConfirmButton: false,
                                text: error.response.data.message,
                            })

                        })
                        .finally(() => {
                            $.LoadingOverlay("hide");
                        });
                }
            });
        });
    </script>
@endpush
