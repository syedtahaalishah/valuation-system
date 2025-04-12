@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card mb-4 shadow">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="font-weight-bold text-primary m-0">Profile</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}" class="user" id="ajaxform">
                    @csrf

                    <div class="form-group row">
                        <div class="col-sm-6 mb-sm-0 mb-3">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" name="first_name" id="first_name" class="form-control form-control-user"
                                placeholder="e.g., John">
                        </div>
                        <div class="col-sm-6">
                            <label for="plot_number" class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="last_name" class="form-control form-control-user"
                                placeholder="e.g., Doe">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-6 mb-sm-0 mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" name="email" id="email" class="form-control form-control-user"
                                placeholder="e.g., john@example.com">
                        </div>
                        <div class="col-sm-6">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control form-control-user"
                                placeholder="e.g., 123-456-7890" value="{{ auth()->user()->phone_number }}">
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
    </div>
@endsection
