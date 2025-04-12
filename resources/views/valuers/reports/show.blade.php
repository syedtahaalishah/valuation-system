@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card mb-4 shadow">
            <div class="card-header d-flex align-items-center justify-content-between flex-row py-3">
                <h6 class="font-weight-bold text-primary m-0">View Report</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table-bordered table">
                        <tbody>
                            <tr>
                                <th>Serial Number</th>
                                <td>{{ $report->serial_number }}</td>
                            </tr>
                            <tr>
                                <th>Location</th>
                                <td>{{ $report->location }}</td>
                            </tr>
                            <tr>
                                <th>Suburb</th>
                                <td>{{ $report->suburb }}</td>
                            </tr>
                            <tr>
                                <th>Plot Number</th>
                                <td>{{ $report->plot_number }}</td>
                            </tr>
                            <tr>
                                <th>Valuation Date</th>
                                <td>{{ $report->valuation_date }}</td>
                            </tr>
                            <tr>
                                <th>Signing Valuer</th>
                                <td>{{ $report->signing_valuer }}</td>
                            </tr>
                            <tr>
                                <th>Market Value</th>
                                <td>{{ $report->market_value }}</td>
                            </tr>
                            <tr>
                                <th>Forced Sale Value</th>
                                <td>{{ $report->forced_sale_value }}</td>
                            </tr>
                            <tr>
                                <th>GPS Coordinates</th>
                                <td>{{ $report->gps_coordinates }}</td>
                            </tr>
                            <tr>
                                <th>QR Code</th>
                                <td><img src="{{ $report->qr_code_url }}" width="100"></td>
                            </tr>

                        </tbody>
                    </table>

                    {{-- Add any additional details or actions here --}}
                </div>

                {{-- Add any additional details or actions here --}}
                <div class="mt-4">
                    <a href="{{ route('reports.index') }}" class="btn btn-secondary">Back to Reports</a>
                    <a href="{{ route('reports.edit', $report->id) }}" class="btn btn-primary">Edit Report</a>
                    <form action="{{ route('reports.destroy', $report->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete Report</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
