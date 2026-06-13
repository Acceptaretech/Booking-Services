@extends('layouts.admin.app')

@section('title','General Settings')

@section('content')

@php
$getConfig = fn($key,$default=null)
=> $configs->get($key)?->value ?? $default;
@endphp

<div class="flex gap-6">

    @include('admin.settings.partials.sidebar')

    <div class="flex-1">

        @include('admin.settings.tabs.general')

    </div>

</div>

@endsection