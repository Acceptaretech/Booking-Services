@extends('layouts.admin.app')

@section('title', 'Mail Settings')

@section('content')

@php
$getConfig = fn($key, $default = null) => $configs->get($key)?->value ?? $default;
@endphp

<div class="flex gap-6">

    @include('admin.settings.partials.sidebar')

    <div class="flex-1">

        <div class="bg-white rounded-xl shadow-sm p-8">

            <form method="POST"
                  action="{{ route('admin.settings.mail.update') }}">

                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block mb-2 font-medium">Mail Mailer</label>
                        <input type="text"
                               name="mail_mailer"
                               value="{{ $getConfig('mail_mailer', 'smtp') }}"
                               placeholder="smtp"
                               class="w-full border rounded-lg px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Mail Host</label>
                        <input type="text"
                               name="mail_host"
                               value="{{ $getConfig('mail_host', 'smtp.gmail.com') }}"
                               placeholder="smtp.gmail.com"
                               class="w-full border rounded-lg px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Mail Port</label>
                        <input type="text"
                               name="mail_port"
                               value="{{ $getConfig('mail_port', '587') }}"
                               placeholder="587"
                               class="w-full border rounded-lg px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Mail Encryption</label>
                        <input type="text"
                               name="mail_encryption"
                               value="{{ $getConfig('mail_encryption', 'tls') }}"
                               placeholder="tls"
                               class="w-full border rounded-lg px-4 py-3">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Mail Username</label>
                        <input type="text"
                               name="mail_username"
                               value="{{ $getConfig('mail_username') }}"
                               placeholder="demo@admin.com"
                               class="w-full border rounded-lg px-4 py-3 bg-blue-50">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Mail Password</label>
                        <input type="password"
                               name="mail_password"
                               value="{{ $getConfig('mail_password') }}"
                               placeholder="********"
                               class="w-full border rounded-lg px-4 py-3 bg-blue-50">
                    </div>

                    <div>
                        <label class="block mb-2 font-medium">Mail From Address</label>
                        <input type="email"
                               name="mail_from_address"
                               value="{{ $getConfig('mail_from_address') }}"
                               placeholder="youremail@gmail.com"
                               class="w-full border rounded-lg px-4 py-3">
                    </div>

                </div>

                <div class="flex justify-end mt-8">
                    <button type="submit"
                            class="bg-[#5B5FC7] hover:bg-[#4b4fb3] text-white px-8 py-3 rounded-lg">
                        Save
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

@endsection