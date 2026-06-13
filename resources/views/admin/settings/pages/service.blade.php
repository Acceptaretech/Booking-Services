@extends('layouts.admin.app')

@section('title', 'Service Configuration')

@section('content')

@php
$getConfig = fn($key, $default = null)
=> $configs->get($key)?->value ?? $default;

$services = [
    'advanced_payment_services' => 'Advanced Payment for Services',
    'slot_services'             => 'Slot Services',
    'digital_services'          => 'Digital Services',
    'service_packages'          => 'Service Packages',
    'service_addons'            => 'Service Add-ons',
    'job_request'               => 'Job Request',
    'shop'                      => 'Shop',
    'default_advance_payment'   => 'Default Advance Payment',
    'cancellation_charge'       => 'Cancellation Charge',
];
@endphp

<div class="flex gap-6">

    {{-- Sidebar --}}
    @include('admin.settings.partials.sidebar')

    {{-- Content --}}
    <div class="flex-1">

        <div class="bg-white rounded-xl shadow-sm p-6">

            <div class="mb-6">
                <h2 class="text-xl font-semibold">
                    Service Configuration
                </h2>
            </div>

            <form method="POST"
                  action="{{ route('admin.settings.service.update') }}">

                @csrf

                <div class="space-y-4">

                    @foreach($services as $key => $label)

                        <div class="border rounded-lg px-5 py-4 flex items-center justify-between">

                            <span class="text-gray-800 font-medium">
                                {{ $label }}
                            </span>

                            <label class="relative inline-flex items-center cursor-pointer">

                                <input type="hidden"
                                       name="{{ $key }}"
                                       value="0">

                                <input type="checkbox"
                                       name="{{ $key }}"
                                       value="1"
                                       class="sr-only peer"
                                       {{ $getConfig($key,'1') == '1' ? 'checked' : '' }}>

                                <div
                                    class="w-11 h-6 bg-gray-300 rounded-full peer
                                    peer-checked:bg-indigo-600
                                    after:content-['']
                                    after:absolute
                                    after:top-[2px]
                                    after:left-[2px]
                                    after:bg-white
                                    after:border-gray-300
                                    after:border
                                    after:rounded-full
                                    after:h-5
                                    after:w-5
                                    after:transition-all
                                    peer-checked:after:translate-x-full">
                                </div>

                            </label>

                        </div>

                    @endforeach

                </div>

                <div class="mt-8 text-right">

                    <button type="submit"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg">

                        Save Settings

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection