@extends('layouts.admin.app')

@section('page_title', 'Add New Document')

@section('content')
<div class="space-y-8">

    <div class="card flex items-center justify-between p-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Add New Document</h2>

        <a href="{{ route('admin.documents.index') }}" class="btn-primary">
            <i class="fas fa-angle-double-left mr-1"></i> Back
        </a>
    </div>

    <div class="max-w-4xl mx-auto card p-8">
        <form method="POST" action="{{ route('admin.documents.store') }}">
            @csrf

            @include('admin.documents.form')

            <div class="flex justify-end mt-8">
                <button class="btn-primary px-8">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection