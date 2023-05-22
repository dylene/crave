<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TenantController extends Controller
{
    public function myaccount() {

        $user = tenant()->run(function() {

             return User::where('role','admin')->first();

        });
         
        $tenant = tenant();

        return view('tenant.myaccount', compact(['user','tenant']));
    }

    public function subscription() {
        
        $tenant = tenant();

        return view('tenant.subscription.index',compact(['tenant']));
    }

    public function upgradeForm(Tenant $tenant) {
        return view('tenant.subscription.upgrade', compact(['tenant']));

    }



        /**
     * Update the specified resource in storage.
     */
    public function upgrade(Request $request)
    {
        try {
            tenant()->run(function($tenant) use ($request) {

                Validator::make($request->all(), [
                    'mobile' => ['required'],
                    'subscription_id' => ['required'],
                    'payment_gateway_id' => ['required'],
                ])->validate();
        
                    // store new products
                $tenant->mobile = $request->mobile;
                $tenant->subscription_id = $request->subscription_id;
                $tenant->payment_gateway_id = $request->payment_gateway_id;
                $tenant->save();
              
                return true;

            });
            return redirect()->route('tenant.subscription', tenant()->id)->with('success','Subscription successfully updated!');
        } catch (\Throwable $exception) {
            return redirect()->route('tenant.subscription')->with('error', $exception->getMessage());
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
