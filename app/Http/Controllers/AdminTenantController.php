<?php

namespace App\Http\Controllers;

use App\Models\PaymentGateway;
use App\Models\Product;
use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AdminTenantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenants = Tenant::all();
        
        return view('admin.tenant.index', compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subscriptions = Subscription::all();
        $gateways = PaymentGateway::all();
        return view('admin.tenant.create', compact(['subscriptions','gateways']));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
                    'password' => $request->password,
                ]);

                $tenant->email = $request->email;
                $tenant->save();
            });


            $tenant->domains()->create(['domain' => $request->domain.'.'.str_replace('http://','', config('app.url')),]);

            // redirect to tenants dashboard
            return redirect()->route('admin.tenants.index')->with('success','New tenant successfully added!');
        } else {
            // new database is already exist, throw error back to the register tenant page 
            return redirect()->back()->with('error', 'Submission not permitted!. '.$newDatabase.' database is already exist!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant)
    {

        $this->establishTenantDatabaseConnection($tenant);
        $users = User::all();
        $products = Product::all();
                
        return view('admin.tenant.show', compact(['tenant','users','products']));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant)
    {

        $subscriptions = Subscription::all();
        $gateways = PaymentGateway::all();

        return view('admin.tenant.edit', compact(['tenant','subscriptions','gateways']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant)
    {
        // validate data
        Validator::make($request->all(), [
            'company' => ['required','unique:tenants'],
            'subscription_id' => ['required'],
            'payment_gateway_id' => [Rule::requiredIf(fn() => $request->subscription_type!='free')],
        ])->validate();

        // updating new tenant
        $tenant->company = $request->company;
        $tenant->payment_gateway_id = $request->payment_gateway_id;
        $tenant->subscription_id = $request->subscription_id;
        $tenant->save();

        // redirect to tenants dashboard
        return redirect()->route('admin.tenants.index')->with('success','Tenant successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant)
    {
        // deleting tenant
        $tenant->delete();

        // redirect to tenants dashboard
        return redirect()->route('admin.tenants.index')->with('success','Tenant successfully removed!');
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
