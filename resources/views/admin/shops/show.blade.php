@extends('layouts.admin.app')

@section('title', 'Shop Detail')
@section('page_title', 'Shop Detail')

@section('content')

<div class="flex items-center gap-3 mb-5">
    <a href="{{ route('admin.shops.index') }}" class="btn-secondary">
        <i class="fas fa-arrow-left"></i> Back
    </a>

    <a href="{{ route('admin.shops.edit', $shop->id) }}" class="btn-primary">
        <i class="fas fa-edit"></i> Edit
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

    <div class="card p-6 text-center">
        <img src="{{ $shop->image_url }}"
             class="w-24 h-24 rounded-2xl object-cover mx-auto mb-4">

        <h2 class="text-xl font-bold text-gray-900 dark:text-white">
            {{ $shop->name }}
        </h2>

        <p class="text-sm text-gray-400 mt-1">
            {{ $shop->email }}
        </p>

        <span class="badge {{ $shop->status === 'active' ? 'badge-success' : 'badge-pending' }} mt-4">
            {{ ucfirst($shop->status) }}
        </span>
    </div>

    <div class="lg:col-span-2 card p-6">
        <h3 class="font-semibold text-gray-900 dark:text-white mb-5">
            Shop Information
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-sm">

            <div>
                <p class="text-gray-400">Provider</p>
                <p class="font-semibold">
                    {{ $shop->provider->full_name ?? $shop->provider->name ?? 'No Provider' }}
                </p>
            </div>

            <div>
                <p class="text-gray-400">Registration Number</p>
                <p class="font-semibold">{{ $shop->registration_number ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-400">Phone</p>
                <p class="font-semibold">{{ $shop->country_code ?? '+91' }} {{ $shop->phone ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-400">City</p>
                <p class="font-semibold">{{ $shop->city ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-400">State</p>
                <p class="font-semibold">{{ $shop->state ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-400">Country</p>
                <p class="font-semibold">{{ $shop->country ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-400">Latitude</p>
                <p class="font-semibold">{{ $shop->latitude ?? '-' }}</p>
            </div>

            <div>
                <p class="text-gray-400">Longitude</p>
                <p class="font-semibold">{{ $shop->longitude ?? '-' }}</p>
            </div>

            <div class="md:col-span-2">
                <p class="text-gray-400">Address</p>
                <p class="font-semibold">{{ $shop->address ?? '-' }}</p>
            </div>

        </div>
    </div>

</div>

@endsection