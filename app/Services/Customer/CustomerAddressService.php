<?php

namespace App\Services\Customer;

use App\Models\CustomerAddress;
use App\Services\Interfaces\CustomerAddressServiceInterface;
use Illuminate\Http\Request;
use Exception;

class CustomerAddressService implements CustomerAddressServiceInterface
{
    public function index($user)
    {
        try {
            return CustomerAddress::where('user_id', $user->id)
                ->latest()
                ->get();
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function store($user, Request $request)
    {
        try {
            $validated = $request->validate([
                'name'       => 'nullable|string|max:255',
                'phone'      => 'nullable|string|max:30',
                'address'    => 'required|string|max:1000',
                'city'       => 'nullable|string|max:255',
                'state'      => 'nullable|string|max:255',
                'pincode'    => 'nullable|string|max:20',
                'is_default' => 'nullable|boolean',
            ]);

            $validated['user_id'] = $user->id;
            $validated['is_default'] = $request->boolean('is_default');

            if ($validated['is_default']) {
                CustomerAddress::where('user_id', $user->id)
                    ->update(['is_default' => false]);
            }

            return CustomerAddress::create($validated);

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update($user, Request $request, $addressId)
    {
        try {
            $address = CustomerAddress::where('user_id', $user->id)
                ->findOrFail($addressId);

            $validated = $request->validate([
                'name'       => 'nullable|string|max:255',
                'phone'      => 'nullable|string|max:30',
                'address'    => 'required|string|max:1000',
                'city'       => 'nullable|string|max:255',
                'state'      => 'nullable|string|max:255',
                'pincode'    => 'nullable|string|max:20',
                'is_default' => 'nullable|boolean',
            ]);

            $validated['is_default'] = $request->boolean('is_default');

            if ($validated['is_default']) {
                CustomerAddress::where('user_id', $user->id)
                    ->update(['is_default' => false]);
            }

            $address->update($validated);

            return $address->fresh();

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function delete($user, $addressId)
    {
        try {
            $address = CustomerAddress::where('user_id', $user->id)
                ->findOrFail($addressId);

            $address->delete();

            return true;

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function makeDefault($user, $addressId)
    {
        try {
            $address = CustomerAddress::where('user_id', $user->id)
                ->findOrFail($addressId);

            CustomerAddress::where('user_id', $user->id)
                ->update(['is_default' => false]);

            $address->update(['is_default' => true]);

            return $address->fresh();

        } catch (Exception $e) {
            throw $e;
        }
    }
}