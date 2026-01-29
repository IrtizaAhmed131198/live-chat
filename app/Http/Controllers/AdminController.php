<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{

    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function chat()
    {
        $user = User::where('role', 'User')->get();
        return view('admin.chat', compact('user'));
    }
}
