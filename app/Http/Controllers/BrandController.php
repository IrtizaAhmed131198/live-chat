<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\BrandUser;
use App\Models\ChatSetting;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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
        $validator = Validator::make($request->all(), [
            'url' => ['required', 'string', 'max:255', 'url'],
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

        DB::beginTransaction();

        try {

            $verifyToken = Str::random(32);

            $brand = Brand::create(array_merge($validator->validated(), ['verify_token' => $verifyToken]));

            DB::commit();

            return redirect()->route('admin.brand.install', $brand->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function install($id)
    {
        $brand = Brand::findOrFail($id);

        $url = config('app.script_url');
        $script = '<!--Start of Live Chat -->
<script src="'.$url.'?brand='.$brand->id.'&token='.$brand->verify_token.'"></script>
<!-- End of Live Chat -->';

        return view('admin.brand.install', compact('brand', 'script'));
    }


    public function chatSettingsStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand_id' => 'required|integer|exists:brand,id',
            'chat_enabled' => 'required|in:0,1',
            'primary_color' => [
                'required',
                'string',
                'max:255',
                'regex:/^#[a-fA-F0-9]{6}$/'
            ],
            'popup_delay' => 'required|integer|min:0|max:3600',
            'sound_enabled' => 'required|in:0,1',
            'welcome_message' => 'nullable|string|max:500',
            'offline_message' => 'nullable|string|max:500',
            'chat_position' => 'required|string|in:left,right,top,bottom',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        ChatSetting::updateOrCreate(
            ['brand_id' => $request->brand_id],
            [
                'chat_enabled' => $request->chat_enabled,
                'primary_color' => $request->primary_color,
                'popup_delay' => $request->popup_delay,
                'sound_enabled' => $request->sound_enabled,
                'welcome_message' => $request->welcome_message,
                'offline_message' => $request->offline_message,
                'chat_position' => $request->chat_position,
            ]
        );

        return redirect()->route('admin.brand')->with('success', 'Chat settings saved successfully!');
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);

        // 🔥 Sirf visitor_id = 2 wale users
        $users = User::where('visitor_id', 2)->get();

        $selectedUserIds = DB::table('brand_users')
            ->where('brand_id', $brand->id)
            ->pluck('user_id')
            ->toArray();

        $chatSettings = ChatSetting::where('brand_id', $brand->id)->first();

        return view('admin.brand.edit', compact(
            'brand',
            'users',
            'selectedUserIds',
            'chatSettings'
        ));
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
        ChatSetting::where('brand_id', $brand->id)->delete();
        $brand->delete();

        return redirect()->route('admin.brand')->with('success', 'Brand deleted successfully!');
    }
}
