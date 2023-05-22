<?php

namespace App\Http\Controllers;

use App\Models\Tenant;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TenantUserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = tenant()->run(function() {
            return User::whereNot('role','admin')->get();
        });

        return view('tenant.user.index', compact('users'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Tenant $tenant)
    {
        return view('tenant.user.create', compact('tenant'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            tenant()->run(function($tenant) use ($request) {

                Validator::make($request->all(), [
                    'name' => ['required', 'unique:users'],
                    'email' => ['required', 'unique:users'],
                    'password' => ['required','confirmed','min:8']
                ])->validate();

                User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'role' => 'client',
                    'password' => Hash::make($request->password),
                ]);

                return true;

            });
            return redirect()->route('tenant.users.index', tenant()->id)->with('success','New tenant user successfully added!');
        } catch (\Throwable $exception) {
            return redirect()->route('tenant.users.create')->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant, $user)
    {

        $userData = tenant()->run(function() use ($user) {
            return User::findOrFail($user);
        });

        return view('tenant.user.show', ['user' => $userData]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($user)
    {

        $userData = tenant()->run(function() use ($user) {
            return User::findOrFail($user);
        });

        return view('tenant.user.edit', ['user' => $userData]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user)
    {
        try {
            tenant()->run(function() use ($request, $user) {

                Validator::make($request->all(), [
                    'name' => ['required', 'unique:users'],
                    'email' => ['required', 'unique:users'],
                    'password' => ['required','confirmed','min:8']
                ])->validate();

                $userModel = User::findOrFail($user);
                $userModel->name = $request->name;
                $userModel->email = $request->email;
                $userModel->role = 'client';
                $userModel->password = Hash::make($request->password);
                $userModel->save();

                return true;
                
            });

            return redirect()->route('tenant.users.index', tenant()->id)->with('success','User successfully updated!');
        
        } catch (\Throwable $exception) {
        
            return redirect()->back()->with('error', $exception->getMessage());
        
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($user)
    {
        try {
            tenant()->run(function() use ($user) {

                User::findOrFail($user)->delete();
                return true;

            });
            
            return redirect()->route('tenant.users.index')->with('success','User successfully removed!');

        } catch (\Throwable $exception) {

            return redirect()->back()->with('error', $exception->getMessage());

        }
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
