<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Product;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TenantProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = tenant()->run(function($tenant) {
        
            return Product::all();
        
        });

        return view('tenant.product.index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tenant.product.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
     
        try {
            tenant()->run(function($tenant) use ($request) {

                Validator::make($request->all(), [
                    'name' => ['required','unique:products'],
                    'price' => ['required'],
                    'quantity' => ['required'],
                ])->validate();
        
                    // store new products
                Product::create([
                    'name' => $request->name,
                    'price' => $request->price,
                    'quantity' => $request->quantity,
                ]);

                return true;

            });
            return redirect()->route('tenant.products.index', tenant()->id)->with('success','New product successfully added!');
        } catch (\Throwable $exception) {
            return redirect()->route('tenant.products.create')->with('error', $exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant, $product)
    {
        $product = tenant()->run(function() use ($product) {
            return Product::findOrFail($product);
        });

        return view('tenant.product.show', compact('product'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($product)
    {
        $product = tenant()->run(function() use ($product) {
            return Product::findOrFail($product);
        });

        return view('tenant.product.edit', ['product' => $product]);
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $product)
    {
             
        try {
            tenant()->run(function() use ($request, $product) {

                Validator::make($request->all(), [
                    'name' => ['required','unique:products'],
                    'price' => ['required'],
                    'quantity' => ['required'],
                ])->validate();
        
                    // store new products
                $product = Product::findOrFail($product);
                $product->name = $request->name;
                $product->price = $request->price;
                $product->quantity = $request->quantity;
                $product->save();

                return true;

            });
            return redirect()->route('tenant.products.index', tenant()->id)->with('success','New product successfully added!');
        } catch (\Throwable $exception) {
            return redirect()->route('tenant.products.create')->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($product)
    {
        try {
            tenant()->run(function() use ($product) {

                Product::findOrFail($product)->delete();

                return true;

            });
            return redirect()->route('tenant.products.index', tenant()->id)->with('success','Product successfully removeds!');
        } catch (\Throwable $exception) {
            return redirect()->route('tenant.products.create')->with('error', $exception->getMessage());
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
