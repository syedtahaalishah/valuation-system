<?php

namespace App\Http\Controllers\Web;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VerifyController extends Controller
{
    public function index(Request $request)
    {
        return view('web.index');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string',
        ]);

        $report = Report::where('serial_number', $request->serial_number)->first();

        if (!$report) {
            return response()->json([
                'message' => 'Serial number not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'This report is genuine.',
        ], 200);
    }
}
