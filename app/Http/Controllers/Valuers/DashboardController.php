<?php

namespace App\Http\Controllers\Valuers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('screens.valuers.dashboard.index');
    }
}
