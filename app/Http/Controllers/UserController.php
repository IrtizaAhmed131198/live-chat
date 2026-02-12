<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{

    public function index()
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }
    public function getUsers()
    {
        $users = User::select(['id', 'name', 'email', 'phone', 'address']);

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('actions', function ($user) {
                return view('admin.user.partials.actions', compact('user'))->render();
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    public function create()
    {
        return view('admin.user.create');
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'image' => 'nullable|file',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'about' => 'nullable|string',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/profile_image'), $filename);
            $validated['image'] = 'upload/profile_image/' . $filename;
        }

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);
        // dd($validated);
        return redirect()->route('admin.users')->with('success', 'User created successfully!');
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'image' => 'nullable|file',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'about' => 'nullable|string',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string',
        ]);

        // Image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/profile_image'), $filename);
            $user->image = 'upload/profile_image/' . $filename;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);
        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }
}
