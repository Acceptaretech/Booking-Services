<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = CustomerAddress::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('customer.addresses.index', compact('addresses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'nullable|string|max:255',
            'phone'      => 'nullable|string|max:30',
            'address'    => 'required|string|max:1000',
            'city'       => 'nullable|string|max:255',
            'state'      => 'nullable|string|max:255',
            'pincode'    => 'nullable|string|max:20',
            'is_default' => 'nullable|boolean',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_default'] = $request->has('is_default');

        if ($validated['is_default']) {
            CustomerAddress::where('user_id', auth()->id())->update(['is_default' => false]);
        }

        CustomerAddress::create($validated);

        return back()->with('success', 'Address added successfully.');
    }

    public function update(Request $request, CustomerAddress $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'name'       => 'nullable|string|max:255',
            'phone'      => 'nullable|string|max:30',
            'address'    => 'required|string|max:1000',
            'city'       => 'nullable|string|max:255',
            'state'      => 'nullable|string|max:255',
            'pincode'    => 'nullable|string|max:20',
            'is_default' => 'nullable|boolean',
        ]);

        $validated['is_default'] = $request->has('is_default');

        if ($validated['is_default']) {
            CustomerAddress::where('user_id', auth()->id())->update(['is_default' => false]);
        }

        $address->update($validated);

        return back()->with('success', 'Address updated successfully.');
    }

    public function destroy(CustomerAddress $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);

        $address->delete();

        return back()->with('success', 'Address deleted successfully.');
    }

    public function makeDefault(CustomerAddress $address)
    {
        abort_if($address->user_id !== auth()->id(), 403);

        CustomerAddress::where('user_id', auth()->id())->update(['is_default' => false]);

        $address->update(['is_default' => true]);

        return back()->with('success', 'Default address updated.');
    }
}