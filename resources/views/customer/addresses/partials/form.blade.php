<div class="space-y-4">

    <div>
        <label class="block mb-1 font-medium">Name</label>
        <input type="text"
               name="name"
               value="{{ old('name', $address->name ?? auth()->user()->name) }}"
               class="w-full border rounded-xl px-4 py-3">
    </div>

    <div>
        <label class="block mb-1 font-medium">Phone</label>
        <input type="text"
               name="phone"
               value="{{ old('phone', $address->phone ?? auth()->user()->phone) }}"
               class="w-full border rounded-xl px-4 py-3">
    </div>

    <div>
        <label class="block mb-1 font-medium">Full Address</label>
        <textarea name="address"
                  rows="3"
                  required
                  class="w-full border rounded-xl px-4 py-3">{{ old('address', $address->address ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block mb-1 font-medium">City</label>
            <input name="city"
                   value="{{ old('city', $address->city ?? '') }}"
                   class="w-full border rounded-xl px-4 py-3">
        </div>

        <div>
            <label class="block mb-1 font-medium">State</label>
            <input name="state"
                   value="{{ old('state', $address->state ?? '') }}"
                   class="w-full border rounded-xl px-4 py-3">
        </div>

        <div>
            <label class="block mb-1 font-medium">Pincode</label>
            <input name="pincode"
                   value="{{ old('pincode', $address->pincode ?? '') }}"
                   class="w-full border rounded-xl px-4 py-3">
        </div>
    </div>

    <label class="flex items-center gap-2">
        <input type="checkbox"
               name="is_default"
               value="1"
               {{ old('is_default', $address->is_default ?? false) ? 'checked' : '' }}>
        Set as default address
    </label>

</div>