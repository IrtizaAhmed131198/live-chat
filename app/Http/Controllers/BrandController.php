<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $brands = Brand::with('user')->select('brands.*');
            return DataTables::of($brands)
                ->addColumn('user', fn($row) => $row->user->name ?? '')
                ->addColumn('actions', function ($row) {
                    $edit = route('admin.brand.edit', $row->id);
                    $delete = route('admin.brand.destroy', $row->id);
                    return '
                    <div class="dropdown">
                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end m-0">
                            <a class="dropdown-item" href="' . $edit . '"><i class="bx bx-edit me-2"></i>Edit</a>
                            <form action="' . $delete . '" method="POST" style="display:inline;">
                                ' . csrf_field() . method_field('DELETE') . '
                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm(\'Are you sure?\')">
                                    <i class="bx bx-trash me-2"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                ';
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        // Pass brands to Blade view
        $brand = DB::table('brand')->get();
        return view('admin.brand.index', compact('brand'));
    }

    // public function getUsers()
    // {
    //     $users = User::select(['id', 'name', 'email', 'phone', 'address']);

    //     return DataTables::of($users)
    //         ->addIndexColumn()
    //         ->addColumn('actions', function ($user) {
    //             return view('admin.user.partials.actions', compact('user'))->render();
    //         })
    //         ->rawColumns(['actions'])
    //         ->make(true);
    // }
    public function create()
    {
        $users = User::where('role', 2)->get(); // Only role=2 users
        return view('admin.brand.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'email' => 'nullable|email|max:255',
            'url' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
            'logo' => 'nullable|file',
        ]);

        $validated['url'] = $request->url;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/logo'), $filename);
            $validated['logo'] = 'upload/logo/' . $filename;
        }

        Brand::create($validated);

        return redirect()->route('admin.brand')->with('success', 'Brand created successfully!');
    }

    public function edit(Brand $brand)
    {
        $users = User::where('role', 2)->get();
        return view('admin.brand.edit', compact('brand', 'users'));
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'email' => 'nullable|email|max:255',
            'url' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'status' => 'required|in:0,1',
            'logo' => 'nullable|file',
        ]);

        $data = $validated;

        if ($request->hasFile('logo')) {
            // Old logo delete karo
            if ($brand->logo && file_exists(public_path($brand->logo))) {
                unlink(public_path($brand->logo));
            }

            // New logo upload - MOVE method (consistent with store)
            $file = $request->file('logo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/logo'), $filename);
            $data['logo'] = 'upload/logo/' . $filename;
        }

        $brand->update($data);

        return redirect()->route('admin.brand')->with('success', 'Brand updated successfully!');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brand')->with('success', 'Brand deleted successfully!');
    }
}
