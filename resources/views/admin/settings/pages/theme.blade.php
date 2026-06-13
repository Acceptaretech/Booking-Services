@extends('layouts.admin.app')

@section('title','Theme Setup')

@section('content')

@php
$getConfig = fn($key,$default=null)
=> $configs->get($key)?->value ?? $default;
@endphp

<div class="flex gap-6">

    @include('admin.settings.partials.sidebar')

    <div class="flex-1">

        @include('admin.settings.tabs.theme')

    </div>

</div>

@endsection