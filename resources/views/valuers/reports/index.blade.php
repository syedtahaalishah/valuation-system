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
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="font-weight-bold text-primary m-0">All Reports</h6>
                <a href="{{ route('reports.create') }}" class="btn btn-primary btn-icon-split">
                    <span class="icon text-white-50">
                        <i class="fas fa-pen"></i>
                    </span>
                    <span class="text">Add Report</span>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-bordered table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                {{-- <th>Serial</th> --}}
                                <th>Location</th>
                                {{-- <th>Suburb</th>
                                <th>Plot Number</th>
                                <th>Valuation Date</th>
                                <th>Signing Valuer</th>
                                <th>Market Value</th>
                                <th>Forced Sale Value</th>
                                <th>GPS Coordinates</th> --}}
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
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('reports.index') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    // { data: 'serial_number', name: 'serial_number' },
                    { data: 'location', name: 'location' },
                    // { data: 'suburb', name: 'suburb' },
                    // { data: 'plot_number', name: 'plot_number' },
                    // { data: 'valuation_date', name: 'valuation_date' },
                    // { data: 'signing_valuer', name: 'signing_valuer' },
                    // { data: 'market_value', name: 'market_value' },
                    // { data: 'forced_sale_value', name: 'forced_sale_value' },
                    // { data: 'gps_coordinates', name: 'gps_coordinates' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush
