<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptions = Subscription::all();

        return view('admin.subscription.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subscription.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate data
        $this->validate($request, [
            'name' => ['required','unique:subscriptions'],
            'price' => ['required'],
            'duration_in_days' => ['required'],
            'max_products' => ['required'],
        ]);

        // store date
        Subscription::create([
            'name' => $request->name,
            'price' => $request->price,
            'type' => $request->name=='free'? 'free' : 'premium',
            'duration_in_days' => $request->duration_in_days,
            'max_products' => $request->max_products,
        ]);

        // redirect to subscription dashboard
        return redirect()->route('admin.subscriptions.index')->with('success', 'New subscription successfully added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription)
    {
        return view('admin.subscription.show', compact('subscription'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription)
    {
        return view('admin.subscription.edit', compact('subscription'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subscription $subscription)
    {
        // validate data
        $this->validate($request, [
            'name' => ['required','unique:subscriptions'],
            'price' => ['required'],
            'duration_in_days' => ['required'],
            'max_products' => ['required'],
        ]);

        // store date
        $subscription->name = $request->name;
        $subscription->price = $request->price;
        $subscription->duration_in_days = $request->duration_in_days;
        $subscription->max_products = $request->max_products;
        $subscription->save();

        // redirect to subscription dashboard
        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription)
    {
        //  delete subscription
        $subscription->delete();

        // redirect to subscription dashboard
        return redirect()->route('admin.subscriptions.index')->with('success', 'Subscription successfully removed!');

    }
}
