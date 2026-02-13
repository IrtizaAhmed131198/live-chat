<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;

class BrandController extends Controller
{
    public function index()
    {
        $brand = DB::table('brand')->get();
        foreach ($brand as $item) {
            $item->logo = asset($item->logo);
        }
        return view('admin.brand.index', compact('brand'));
    }

    public function getdata() // Changed from getUsers() to getdata()
    {
        $brand = Brand::select(['id', 'logo', 'name', 'email', 'phone']);

        return DataTables::of($brand)
            ->addIndexColumn()
            ->addColumn('actions', function ($brand) {
                return view('admin.brand.partials.actions', compact('brand'))->render();
            })
            ->rawColumns(['actions', 'logo'])
            ->make(true);
    }

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
