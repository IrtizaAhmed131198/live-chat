<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ])->onlyInput('email');
    }



    public function logout(Request $request)
    {
        $user = auth()->user();
        $user->update(['is_online' => 0]);
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        emit_pusher_notification(
            'agent-status',
            'agent-offline',
            [
                'agent_id' => $user->id,
                'brand_ids' => $user->auth_brands
                    ? $user->auth_brands->pluck('id')
                    : []
            ]
        );

        return redirect()->route('login');
    }
}
