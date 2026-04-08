<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Normalize role value for reliable routing
            $role = strtolower(trim($user->role));

            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'doctor' || $role === 'dr') {
                return redirect()->route('doctor.dashboard');
            } elseif ($role === 'staff') {
                return redirect()->route('staff.dashboard');
            }

            // Fallback to a shared dashboard route so unknown roles are handled safely.
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['username' => 'Invalid username or password.']);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
