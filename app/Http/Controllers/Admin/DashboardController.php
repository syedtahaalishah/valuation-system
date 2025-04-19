<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $users = User::count();
        $reports = Report::count();
        return view('screens.admin.dashboard.index', get_defined_vars());
    }
}
