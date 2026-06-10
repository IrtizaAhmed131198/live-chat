<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FormSubmission;
use App\Models\Brand;
use Yajra\DataTables\Facades\DataTables;

class FormSubmissionsController extends Controller
{
    /**
     * Show the Form Submissions page.
     */
    public function index()
    {
        // Brand dropdown for filter UI – data fetched via AJAX for the table.
        $brands = Brand::pluck('name', 'id');
        return view('admin.form-submissions.index', compact('brands'));
    }

    /**
     * DataTables endpoint – returns JSON for the submissions table.
     */
    public function getFormSubmissions(Request $request)
    {
        $query = FormSubmission::with('brand')->latest();

        // Filters (same as previous implementation)
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }
        if ($request->filled('form_action')) {
            $query->where('form_action', 'like', '%' . $request->form_action . '%');
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('brand', function (FormSubmission $row) {
                return optional($row->brand)->name ?? '-';
            })
            ->addColumn('actions', function (FormSubmission $row) {
                return view('admin.form-submissions.partials.actions', ['submission' => $row])->render();
            })
            ->editColumn('created_at', function (FormSubmission $row) {
                return $row->created_at->format('Y-m-d H:i');
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    /**
     * Show a single form submission.
     */
    public function show($id)
    {
        $submission = FormSubmission::with('brand')->findOrFail($id);
        return view('admin.form-submissions.show', compact('submission'));
    }
}

