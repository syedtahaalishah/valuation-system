<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class ValuerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = User::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<form action="' . route('admin.valuers.destroy', $row->id) . '" method="POST" style="display:inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')"><i class="fas fa-trash"></i></button>
                        </form>';
                    return $btn;
                })
                ->addColumn('valuer', function ($row) {
                    return $row->name;
                })
                ->addColumn('status', function ($row) {
                    $active = $row->status ? "selected" : "";
                    $inactive = !$row->status ? "selected" : "";

                    return '
                    <select class="form-control status" data-action="' . route('admin.valuers.status') . '" data-id="' . $row->id . '">
                        <option value="1" ' . $active . '>Active</option>
                        <option value="0" ' . $inactive . '>Inactive</option>
                    </select>';
                })
                ->rawColumns(['valuer', 'status', 'action'])
                ->make(true);
        }

        return view('screens.admin.valuers.index');
    }

    public function valuerStatus(Request $request)
    {
        User::where('id', $request->id)->update([
            'status' => $request->status
        ]);

        return response()->json([
            'message' => 'Status successfully updated'
        ]);
    }

    public function destroy(User $valuer)
    {
        $valuer->delete();
        return redirect()->route('admin.valuers.index')->with('success', 'Valuer deleted successfully');
    }
}
