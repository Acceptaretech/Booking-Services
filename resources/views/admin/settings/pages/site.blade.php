@extends('layouts.admin.app')

@section('title','Site Setup')

@section('content')

@php
$getConfig = fn($key,$default=null)
=> $configs->get($key)?->value ?? $default;
@endphp

<div class="flex gap-6">

    @include('admin.settings.partials.sidebar')

    <div class="flex-1">

        <form method="POST"
              action="{{ route('admin.settings.update') }}"
              class="bg-white rounded-xl shadow-sm p-8">

            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Date Format --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Date Format
                    </label>

                    <select name="date_format"
                            class="w-full border rounded-lg px-4 py-3">
                        <option value="F j, Y">June 5, 2026</option>
                        <option value="d-m-Y">05-06-2026</option>
                        <option value="Y-m-d">2026-06-05</option>
                    </select>
                </div>

                {{-- Longitude --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Longitude
                    </label>

                    <input type="text"
                           name="longitude"
                           value="{{ $getConfig('longitude','-74.0060') }}"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                {{-- Time Format --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Time Format
                    </label>

                    <select name="time_format"
                            class="w-full border rounded-lg px-4 py-3">
                        <option value="h:i A">1:47 AM</option>
                        <option value="H:i">13:47</option>
                    </select>
                </div>

                {{-- Distance Type --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Distance Type
                    </label>

                    <select name="distance_type"
                            class="w-full border rounded-lg px-4 py-3">
                        <option value="km">km</option>
                        <option value="mile">mile</option>
                    </select>
                </div>

                {{-- Timezone --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Timezone
                    </label>

                    <select name="timezone"
                            class="w-full border rounded-lg px-4 py-3">
                        @foreach(timezone_identifiers_list() as $timezone)
                            <option value="{{ $timezone }}"
                                {{ $getConfig('timezone') == $timezone ? 'selected' : '' }}>
                                {{ $timezone }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Radius --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Radius
                    </label>

                    <input type="number"
                           name="radius"
                           value="{{ $getConfig('radius',100) }}"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                {{-- Default Language --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Default Language
                    </label>

                    <input type="text"
                           name="default_language"
                           value="{{ $getConfig('default_language','English') }}"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                {{-- Decimal Point --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Decimal Point
                    </label>

                    <input type="number"
                           name="decimal_point"
                           value="{{ $getConfig('decimal_point',2) }}"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                {{-- Currency --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Default Currency
                    </label>

                    <input type="text"
                           name="currency"
                           value="{{ $getConfig('currency','USD') }}"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                {{-- Copyright --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Copyright Text
                    </label>

                    <input type="text"
                           name="copyright_text"
                           value="{{ $getConfig('copyright_text') }}"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

                {{-- Currency Position --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Currency Position
                    </label>

                    <select name="currency_position"
                            class="w-full border rounded-lg px-4 py-3">
                        <option value="left">Left</option>
                        <option value="right">Right</option>
                    </select>
                </div>

                {{-- Latitude --}}
                <div>
                    <label class="block mb-2 font-medium">
                        Latitude
                    </label>

                    <input type="text"
                           name="latitude"
                           value="{{ $getConfig('latitude','40.7128') }}"
                           class="w-full border rounded-lg px-4 py-3">
                </div>

            </div>

            {{-- Android --}}
            <div class="mt-8 bg-gray-100 rounded-lg p-5">

                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold">
                        Android App Links
                    </h3>

                    <input type="checkbox"
                           name="android_status"
                           value="1">
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <input type="text"
                           name="playstore_url"
                           placeholder="Play Store Url"
                           class="border rounded-lg px-4 py-3">

                    <input type="text"
                           name="provider_playstore_url"
                           placeholder="Provider Play Store Url"
                           class="border rounded-lg px-4 py-3">

                </div>

            </div>

            {{-- IOS --}}
            <div class="mt-6 bg-gray-100 rounded-lg p-5">

                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold">
                        IOS App Links
                    </h3>

                    <input type="checkbox"
                           name="ios_status"
                           value="1">
                </div>

                <div class="grid grid-cols-2 gap-4">

                    <input type="text"
                           name="appstore_url"
                           placeholder="App Store Url"
                           class="border rounded-lg px-4 py-3">

                    <input type="text"
                           name="provider_appstore_url"
                           placeholder="Provider App Store Url"
                           class="border rounded-lg px-4 py-3">

                </div>

            </div>

            <div class="text-right mt-8">

                <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg">
                    Save
                </button>

            </div>

        </form>

    </div>

</div>

@endsection