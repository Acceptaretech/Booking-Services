@extends('layouts.admin.app')

@section('title','Settings')

@section('content')

@php
$getConfig = fn($key,$default=null)
=> $configs->get($key)?->value ?? $default;
@endphp

<div
    x-data="{ tab: 'general' }"
    class="flex gap-6">

    @include('admin.settings.partials.sidebar')

    <div class="flex-1">

        {{-- General --}}
        <div x-show="tab==='general'" x-cloak>
            @include('admin.settings.tabs.general')
        </div>

        {{-- Theme --}}
        <div x-show="tab==='theme'" x-cloak>
            @include('admin.settings.tabs.theme')
        </div>
       
      {{-- Site 
        <div x-show="tab==='site'" x-cloak>
            @include('admin.settings.tabs.site')
        </div> --}}

        {{-- Service 
        <div x-show="tab==='service'" x-cloak>
            @include('admin.settings.tabs.service')
        </div>

        {{-- App 
        <div x-show="tab==='app'" x-cloak>
            @include('admin.settings.tabs.app')
        </div>

        {{-- Notification 
        <div x-show="tab==='notification'" x-cloak>
            @include('admin.settings.tabs.notification')
        </div>

        {{-- Social 
        <div x-show="tab==='social'" x-cloak>
            @include('admin.settings.tabs.social')
        </div>

        {{-- Cookie 
        <div x-show="tab==='cookie'" x-cloak>
            @include('admin.settings.tabs.cookie')
        </div>

        {{-- Roles 
        <div x-show="tab==='roles'" x-cloak>
            @include('admin.settings.tabs.roles')
        </div>

        {{-- Mail 
        <div x-show="tab==='mail'" x-cloak>
            @include('admin.settings.tabs.mail')
        </div>

        {{-- Payment 
        <div x-show="tab==='payment'" x-cloak>
            @include('admin.settings.tabs.payment')
        </div>

        {{-- Earning 
        <div x-show="tab==='earning'" x-cloak>
            @include('admin.settings.tabs.earning')
        </div>

        {{-- Language
        <div x-show="tab==='language'" x-cloak>
            @include('admin.settings.tabs.language')
        </div>

        {{-- Banner 
        <div x-show="tab==='banner'" x-cloak>
            @include('admin.settings.tabs.banner')
        </div>

        {{-- SEO 
        <div x-show="tab==='seo'" x-cloak>
            @include('admin.settings.tabs.seo')
        </div> --}}
        
    </div>

</div>

@endsection