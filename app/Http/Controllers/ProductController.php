<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Product;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
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
        // make a fresh database connection
        $this->establishTenantDatabaseConnection($tenant);
        $products = Product::all();

        return view('admin.tenant.product.create', compact(['tenant','products']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Tenant $tenant)
    {
     
        // make a fresh database connection
        $this->establishTenantDatabaseConnection($tenant);

        // validate request
        $this->validate($request, [
            'name' => ['required','unique:tenant.products'],
            'max_products' => ['required'],
            'uploaded_products' => ['required','lt:max_products'],
            'price' => ['required'],
            'quantity' => ['required'],
        ], ['uploaded_products.lt' => 'Opps! You can only upload :value products based on your subscription. Consider upgrading your subscription.']);
        // store new products
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('admin.tenants.show', $tenant->id)->with('success','New product successfully added!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Tenant $tenant, $product)
    {
        // make a fresh database connection
        $this->establishTenantDatabaseConnection($tenant);

        $product = Product::findOrFail($product);

        return view('admin.tenant.product.show',compact(['tenant','product']));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tenant $tenant, $product)
    {
        // make a fresh database connection
        $this->establishTenantDatabaseConnection($tenant);

        $product = Product::findOrFail($product);

        return view('admin.tenant.product.edit',compact(['tenant','product']));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tenant $tenant, $product)
    {
             
        // make a fresh database connection
        $this->establishTenantDatabaseConnection($tenant);

        // validate request
        $this->validate($request, [
            'name' => ['required','unique:tenant.products'],
            'price' => ['required'],
            'quantity' => ['required'],
        ]);

        $product = Product::findOrFail($product);

        // store new products
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->save();

        return redirect()->route('admin.tenants.show', $tenant->id)->with('success','Product successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tenant $tenant, $product)
    {
        // make a fresh database connection
        $this->establishTenantDatabaseConnection($tenant);
        Product::findOrFail($product)->delete();

        return redirect()->route('admin.tenants.show', $tenant->id)->with('success','Product successfully removed!');

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
