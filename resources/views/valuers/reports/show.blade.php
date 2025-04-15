@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card mb-4 shadow">
            <div class="card-header d-flex align-items-center justify-content-between flex-row py-3">
                <h6 class="font-weight-bold text-primary m-0">View Report</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @include('includes.report-table')
                </div>
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
