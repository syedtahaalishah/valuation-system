<?php

namespace App\Http\Controllers\Valuers;

use Carbon\Carbon;
use App\Models\Report;
use Illuminate\Http\Request;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use chillerlan\QRCode\Output\QRImageOutput;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = auth()->user()->valuationReports()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('reports.show', $row->serial_number) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>';
                    $btn .= '<a href="' . route('reports.edit', $row->serial_number) . '" class="btn btn-warning btn-sm mx-2"><i class="fas fa-pen"></i></a>';
                    $btn .= '<form action="' . route('reports.destroy', $row->serial_number) . '" method="POST" style="display:inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></button>
                        </form>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('screens.valuers.reports.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('screens.valuers.reports.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'location' => 'required|string',
            'suburb' => 'required|string',
            'plot_number' => 'required|string',
            'valuation_date' => 'required|date',
            'signing_valuer' => 'required|string',
            'market_value' => 'required|numeric',
            'forced_sale_value' => 'required|numeric',
            'gps_coordinates' => 'required|string',
            'valuing_company' => 'required|string',
            'insurance_replacement_value' => 'required|string',
        ]);

        $report = auth()->user()->valuationReports()->create($validated);

        auth()->user()->activities()->create([
            'activity' => auth()->user()->name.' created an report which serial number is #'.$report->serial_number,
        ]);

        $directory = public_path('qrcodes');
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $options = new QROptions([
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'scale' => 10,
        ]);

        $qrCode = new QRCode($options);
        $filename = $report->serial_number . '.png';
        $path = 'qrcodes/' . $filename;

        $qrCode->render(
            route('web.report', $report->serial_number),
            public_path($path)
        );

        $report->update(attributes: [
            'qr_code' => $filename,
        ]);

        return response()->json([
            'message' => 'Report created successfully',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return view('screens.valuers.reports.show', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        return view('screens.valuers.reports.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'location' => 'required|string',
            'suburb' => 'required|string',
            'plot_number' => 'required|string',
            'valuation_date' => 'required|date',
            'signing_valuer' => 'required|string',
            'market_value' => 'required|numeric',
            'forced_sale_value' => 'required|numeric',
            'gps_coordinates' => 'required|string',
        ]);

        $report->update($validated);

        auth()->user()->activities()->create([
            'activity' => auth()->user()->name.' updated an report which serial number is #'.$report->serial_number,
        ]);

        return response()->json([
            'message' => 'Report updated successfully',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('reports.index')->with('success', 'Report deleted successfully');
    }
}
