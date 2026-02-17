<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\BrandUser;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index()
    {
        $brand = Brand::with('user')->get();
        foreach ($brand as $item) {
            $item->logo = asset($item->logo);
        }
        return view('admin.brand.index', compact('brand'));
    }

    public function getdata() // Changed from getUsers() to getdata()
    {
        $brand =  Brand::with('user')->select(['id', 'domain', 'url']);

        return DataTables::of($brand)
            ->addIndexColumn()
            ->addColumn('actions', function ($brand) {
                return view('admin.brand.partials.actions', compact('brand'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function create()
    {
        $users = User::where('role', 2)->get();
        return view('admin.brand.create', compact('users'));
    }

    public function store(Request $request)
    {
        // Validate - user_ids as array
        $validator = Validator::make($request->all(), [
            'url' => [
                'required',
                'string',
                'max:255',
                'url'
            ],
            'domain' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?!https?:\/\/)(?!www\.)([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/',
                'unique:brand,domain'
            ],
            'status' => 'required|in:0,1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        // Use database transaction
        DB::beginTransaction();

        try {
            // Create brand
            $brand = Brand::create($validated);

            DB::commit();

            // $userCount = count($request->user_ids);
            return redirect()->route('admin.brand')->with('success', "Brand created successfully!");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Error creating brand: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        $users = User::all();

        // Important: selectedUserIds ko view mein bhejna
        $selectedUserIds = DB::table('brand_users')
            ->where('brand_id', (string) $brand->id)
            ->pluck('user_id')
            ->toArray();
        return view('admin.brand.edit', compact('brand', 'users', 'selectedUserIds'));
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'user_ids' => 'required|array',
            'user_ids.*' => 'required|exists:users,id',
            'email' => 'required|email|max:255',
            'url' => [
                'required',
                'string',
                'max:255',
                'url'
            ],
            'domain' => [
                'required',
                'string',
                'max:255',
                'regex:/^(?!https?:\/\/)(?!www\.)([a-zA-Z0-9-]+\.)+[a-zA-Z]{2,}$/',
                Rule::unique('brand', 'domain')->ignore($brand->id)
            ],
            'status' => 'required|in:0,1',
        ]);

        DB::beginTransaction();

        try {
            // Update brand
            $brand->update($validated);

            // Delete existing user assignments
            BrandUser::where('brand_id', (string) $id)->delete();

            // Insert new user assignments
            foreach ($request->user_ids as $userId) {
                BrandUser::create([
                    'brand_id' => (string) $brand->id,
                    'user_id' => (string) $userId,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.brand')
                ->with('success', 'Brand updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Error updating brand: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brand')->with('success', 'Brand deleted successfully!');
    }
}
