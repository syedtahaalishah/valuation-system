<?php

namespace App\Http\Controllers\Admin;

use App\Models\Report;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Report::latest()->with('user')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="' . route('admin.reports.show', $row->serial_number) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>';
                    $btn .= '<form action="' . route('admin.reports.destroy', $row->serial_number) . '" method="POST" style="display:inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></button>
                        </form>';
                    return $btn;
                })
                ->addColumn('valuer', function ($row) {
                    return $row->user->name;
                })
                ->rawColumns(['valuer', 'action'])
                ->make(true);
        }

        return view('screens.admin.reports.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        return view('screens.admin.reports.show', get_defined_vars());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('admin.reports.index')->with('success', 'Report deleted successfully');
    }
}
