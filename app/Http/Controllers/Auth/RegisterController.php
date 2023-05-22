<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }


    public function showRegistrationForm() {

        $subscriptions = Subscription::all();

        $gateways = PaymentGateway::all();
        
        return view('auth.register', compact(['subscriptions','gateways']));
    }


    public function register(Request $request)
    {
        // validate data
        $this->validate($request, [
            'company' => ['required','unique:tenants'],
            'domain' => ['required','unique:domains'],
            'subscription_id' => ['required'],
            'password' => ['required','min:8','confirmed'],
            'payment_gateway_id' => [Rule::requiredIf(fn() => $request->subscription_type!='free')],
        ]);

        // new database
        $newDatabase = 'tenant'.$request->domain;

        // checks if the new database to be saved is already exist
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = ?";
        $result = DB::select($query, [$newDatabase]);
    
        if(count($result) == 0) {
            // new database did not exist 
            // storing new tenant
            $tenant = Tenant::create([
                'id' => $request->domain,
                'company' => $request->company,
                'payment_gateway_id' => $request->payment_gateway_id,
                'subscription_id' => $request->subscription_id,
            ]);

            $tenant->run(function($tenant) use ($request) {

                $this->validate($request, [
                    'name' => ['required','unique:users'],
                    'email' => ['required','unique:users'],
                    'subscription_id' => ['required'],
                    'payment_gateway_id' => [Rule::requiredIf(fn() => $request->subscription_type!='free')],
                    'mobile' => [Rule::requiredIf(fn() => !empty($request->payment_gateway_id),'unique:users','min:11','max:11')]
                ]);
    
                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile' => $request->mobile,
                    'role' => 'admin',
                    'remember_token' => Str::random(30),
                    'password' => $request->password,
                ]);

                $tenant->email = $request->email;
                $tenant->save();
            });


            $tenant->domains()->create(['domain' => $request->domain.'.'.str_replace('http://','', config('app.url')),]);

            // redirect to tenants dashboard
            return redirect('http://'.$tenant->domains[0]->domain.':8000/dashboard');
        } else {
            // new database is already exist, throw error back to the register tenant page 
            return redirect()->back()->with('error', 'Submission not permitted!. '.$newDatabase.' database is already exist!');
        }
    
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
