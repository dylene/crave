<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminTenantUserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Tenant $tenant)
    {
        return view('admin.tenant.user.create', compact('tenant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Tenant $tenant)
    {
        //  make new tenant connection
        $this->establishTenantDatabaseConnection($tenant);

        // validating request
        Validator::make($request->all(), [
            'name' => ['required', 'unique:tenant.users'],
            'email' => ['required', 'unique:tenant.users'],
            'password' => ['required','confirmed','min:8']
        ])->validate();

        // store new user to tenant
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'client',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.tenants.show', $tenant->id)->with('success','New tenant user successfully added!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant, $user)
    {
        //  make new tenant connection
        $this->establishTenantDatabaseConnection($tenant);

        $user = User::findOrFail($user);

        return view('admin.tenant.user.show', compact(['tenant','user']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant, $user)
    {
        //  make new tenant connection
        $this->establishTenantDatabaseConnection($tenant);

        $user = User::findOrFail($user);
        return view('admin.tenant.user.edit', compact(['tenant','user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant, $user)
    {

        //  make new tenant connection
        $this->establishTenantDatabaseConnection($tenant);

        $user = User::findOrFail($user);

       // validating request
       Validator::make($request->all(), [
           'name' => ['required', 'unique:tenant.users'],
           'email' => ['required', 'unique:tenant.users'],
           'password' => ['required','confirmed','min:8']
       ])->validate();

       // store new user to tenant
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

       return redirect()->route('admin.tenants.show', $tenant->id)->with('success','User successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant, $user)
    {
        //  make new tenant connection
        $this->establishTenantDatabaseConnection($tenant);

        User::findOrFail($user)->delete();

        return redirect()->route('admin.tenants.show', $tenant->id)->with('success','User successfully removed!');
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
