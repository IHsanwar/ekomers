<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingOption;
class ShippingOptionController extends Controller
{
    public function index()
    {
        $shippingOptions = ShippingOption::all();
        return view('admin.shipping_options.index', compact('shippingOptions'));
    }

    public function create()
    {
        return view('admin.shipping_options.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric',
            'delivery_type' => 'required|in:standard,express,same_day',
            'estimated_delivery_time' => 'required|string|max:255',
        ]);

        ShippingOption::create($request->all());

        return redirect()->route('admin.shipping-options.index')->with('success', 'Shipping option created successfully.');
    }

    public function update(Request $request, $id)
    {
        $shippingOption = ShippingOption::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'cost' => 'required|numeric',
            'delivery_type' => 'required|in:standard,express,same_day',
            'estimated_delivery_time' => 'required|string|max:255',
        ]);

        $shippingOption->update($request->all());

        return redirect()->route('admin.shipping-options.index')->with('success', 'Shipping option updated successfully.');
    }

    public function destroy($id)
    {
        $shippingOption = ShippingOption::findOrFail($id);
        $shippingOption->delete();

        return redirect()->route('admin.shipping-options.index')->with('success', 'Shipping option deleted successfully.');
    }
}
