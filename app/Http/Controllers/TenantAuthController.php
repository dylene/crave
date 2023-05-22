<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class TenantAuthController extends Controller
{

    public function loginForm() {
        return view('auth.tenant-login');
    }

    public function login() {
        return view('auth.tenant-login');
    }

    public function registerForm() {

        $subscriptions = Subscription::all();

        return view('auth.tenant-register', compact('subscriptions'));
    }

    public function dashboard() {

        $users = tenant()->run(function() {
            return User::whereNot('role','admin')->get();
        });

        $products = tenant()->run(function() {
            return Product::all();
        });

        return view('tenant.dashboard', compact(['users','products']));
    }

    public function logout(Request $request) {
        try {
            $user = User::where('role','admin')->whereNot('remember_token', null)->first();
            if($user) {
                $user->remember_token = null;
                $user->save();

                return redirect()->route('login');
            }
        } catch (\Throwable $exception) {
            return $exception->getMessage();
        }
    }

}
