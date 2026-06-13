@extends('layouts.admin.app')

@section('title','Social Media')

@section('content')

@php
$getConfig = fn($key,$default=null)
=> $configs->get($key)?->value ?? $default;
@endphp

<div class="flex gap-6">

    @include('admin.settings.partials.sidebar')

    <div class="flex-1">

        <div class="bg-white rounded-xl shadow-sm p-6">

            <h2 class="text-xl font-semibold mb-6">
                Social Media Settings
            </h2>

            <form method="POST"
                  action="{{ route('admin.settings.social.update') }}">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Facebook --}}
                    <div>
                        <label class="block mb-2 font-medium">
                            Facebook URL
                        </label>

                        <input
                            type="url"
                            name="social_facebook"
                            value="{{ $getConfig('social_facebook') }}"
                            class="w-full border rounded-lg px-4 py-3"
                            placeholder="https://facebook.com/yourpage">
                    </div>

                    {{-- Instagram --}}
                    <div>
                        <label class="block mb-2 font-medium">
                            Instagram URL
                        </label>

                        <input
                            type="url"
                            name="social_instagram"
                            value="{{ $getConfig('social_instagram') }}"
                            class="w-full border rounded-lg px-4 py-3"
                            placeholder="https://instagram.com/yourpage">
                    </div>

                    {{-- Twitter --}}
                    <div>
                        <label class="block mb-2 font-medium">
                            Twitter URL
                        </label>

                        <input
                            type="url"
                            name="social_twitter"
                            value="{{ $getConfig('social_twitter') }}"
                            class="w-full border rounded-lg px-4 py-3"
                            placeholder="https://twitter.com/yourpage">
                    </div>

                    {{-- YouTube --}}
                    <div>
                        <label class="block mb-2 font-medium">
                            YouTube URL
                        </label>

                        <input
                            type="url"
                            name="social_youtube"
                            value="{{ $getConfig('social_youtube') }}"
                            class="w-full border rounded-lg px-4 py-3"
                            placeholder="https://youtube.com/@yourchannel">
                    </div>

                    {{-- LinkedIn --}}
                    <div>
                        <label class="block mb-2 font-medium">
                            LinkedIn URL
                        </label>

                        <input
                            type="url"
                            name="social_linkedin"
                            value="{{ $getConfig('social_linkedin') }}"
                            class="w-full border rounded-lg px-4 py-3"
                            placeholder="https://linkedin.com/company/yourcompany">
                    </div>

                </div>

                <div class="flex justify-end mt-8">

                    <button
                        type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg">

                        Save

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection