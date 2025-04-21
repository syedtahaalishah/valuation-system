<?php

namespace App\Http\Controllers\Admin;

use App\Models\Activity;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Activity::with('user')->latest()->get();

            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('valuer', function ($row) {
                return $row->user->name;
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('m/d/Y h:i A');
            })
            ->rawColumns(['valuer'])
            ->make(true);
        }

        return view('screens.admin.activities.index');
    }
}
