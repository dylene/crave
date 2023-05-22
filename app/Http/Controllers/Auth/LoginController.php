<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request) {
        // validate request
        $this->validate($request, [
            'email' => ['required','exists:tenants'],
            'password' => ['required'],
        ]);

        $tenant = Tenant::where('email', $request->email)->first();

        // establish new connection to tenant database
        $this->establishTenantDatabaseConnection($tenant);
        
        $user = User::where('email',$request->email)->where('role','admin')->first();

        if($tenant && $user) {
            // // authenticate current tenant
            // if(Auth::guard()->attempt($request->only(['email','password']), $request->filled('rememberme'))) {
                
                // $request->session()->regenerate();

                $user->remember_token = Str::random(30);
                $user->save();
                // redirect to intended domain
                return redirect('http://'.$tenant->domains->first()->domain.':8000/dashboard');
            // }
            // return redirect()->back()->with('error','Invalid credentials or account did not exists!');
        }
        return redirect()->back()->with('error','Invalid credentials or account did not exists!');
    }

    public function establishTenantDatabaseConnection($tenant) {
        // change the database based on the current tenant using the config helper of the laravel
        config(['database.connections.tenant.database' => $tenant->tenancy_db_name]);
        // make a fresh database connection
        DB::connection('tenant');
        // clear all previous databse activites for new database connection
        DB::purge('tenant');
    }

}
