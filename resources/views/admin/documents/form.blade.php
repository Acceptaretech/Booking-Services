<div class="space-y-6">

    <div>
        <label class="block mb-2 font-medium">
            Name <span class="text-red-500">*</span>
        </label>

        <input type="text"
               name="name"
               value="{{ old('name', $document->name ?? '') }}"
               placeholder="Name"
               class="form-input w-full">

        @error('name')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Document Type <span class="text-red-500">*</span>
        </label>

        <select name="document_type" class="form-input w-full">
            <option value="">Select Type</option>
            <option value="provider" {{ old('document_type', $document->document_type ?? '') == 'provider' ? 'selected' : '' }}>
                Provider Document
            </option>
            <option value="shop" {{ old('document_type', $document->document_type ?? '') == 'shop' ? 'selected' : '' }}>
                Shop Document
            </option>
        </select>

        @error('document_type')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block mb-2 font-medium">
            Status <span class="text-red-500">*</span>
        </label>

        <select name="status" class="form-input w-full">
            <option value="active" {{ old('status', $document->status ?? 'active') == 'active' ? 'selected' : '' }}>
                Active
            </option>
            <option value="inactive" {{ old('status', $document->status ?? '') == 'inactive' ? 'selected' : '' }}>
                Inactive
            </option>
        </select>

        @error('status')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
        @enderror
    </div>

    <label class="inline-flex items-center gap-2">
        <input type="checkbox"
               name="is_required"
               value="1"
               class="rounded"
               {{ old('is_required', $document->is_required ?? false) ? 'checked' : '' }}>

        <span>Required</span>
    </label>
</div>