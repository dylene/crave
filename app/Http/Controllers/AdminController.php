<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function loginForm() {
        return view('auth.admin-login');
    }

    public function login(Request $request) {
        // validate credentials
        $this->validate($request, [
            'email' => ['required'],
            'password' => ['required']
        ]);

        // attempting to log
        if(Auth::guard('admin')->attempt($request->only('email','password'), $request->filled('rememberme'))) {
            // redirect to inteded dashoard
            $request->session()->regenerate();
            
            // regenerate session for new login
            return redirect()->route('admin.dashboard');
        }

        // redirect due to errors
        return redirect()->back()->with('error', 'Warning! Invalid email address or account did not exists!');
        
    }

    public function dashboard() {

        $tenants = Tenant::all();
        
        return view('admin.dashboard', compact('tenants'));
    
    }

    public function logout(Request $request) {

        // logging out admin by guard
        Auth::guard('admin')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login.form');
    }

}
