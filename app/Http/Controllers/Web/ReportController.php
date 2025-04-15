<?php

namespace App\Http\Controllers\Web;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        return view('web.index');
    }

    public function report(Report $report)
    {
        return view('web.report', get_defined_vars());
    }

    public function verify(Request $request)
    {
        $request->validate([
            'serial_number' => 'required|string',
        ]);

        $report = Report::where('serial_number', $request->serial_number)->first();

        if (!$report) {
            return response()->json([
                'message' => 'Report not found with this serial number.',
            ], 404);
        }

        return response()->json([
            'message' => 'This valuation report is authentic.',
            'html' => view('includes.report-table', ['report' => $report])->render(),
        ], 200);
    }
}
