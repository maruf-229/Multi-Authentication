<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AdminController extends Controller
{
    // Show the auth login form
    public function loginForm()
    {
        if (auth()->guard('admin')->user()) {
            return redirect()->route('admin.dashboard');
        }
        return Inertia::render('Auth/AdminLogin');
        //return view('auth.login');
    }

    // Handle auth login
    public function adminLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        //$admin = $this->findAdminByEmail($credentials['email']);
        $admin = Admin::where('email', $credentials['email'])->first();

        if (!$admin || !Hash::check($credentials['password'], $admin->password)) {
            return redirect()->route('login')->withErrors(['email' => 'These credentials do not match our records.'])->withInput();
        }

        if ($remember) {
            $admin->setRememberToken(Str::random(60));
            $admin->save();
        }

        Auth::guard('admin')->login($admin, $remember);

        return redirect()->route('admin.dashboard');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Find auth by email
    private function findAdminByEmail($email)
    {
        // Implement your logic to retrieve the auth by email
        // For example, if you're using Eloquent, you can do:
        return \App\Models\Admin::where('email', $email)->first();
    }

    // Handle auth logout
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        if ($request->user('admin')) {
            $request->user('admin')->setRememberToken(null);
            $request->user('admin')->save();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
