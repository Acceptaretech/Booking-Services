@extends('layouts.admin.app')
@section('title','New Ticket')
@section('page_title','Create Ticket')
@section('content')
<a href="{{ route('admin.help-desk.index') }}" class="btn-secondary text-xs py-2 mb-5 inline-flex"><i class="fas fa-arrow-left"></i>Back</a>
<div class="card p-6 max-w-lg">
  <form method="POST" action="{{ route('admin.help-desk.store') }}" enctype="multipart/form-data">@csrf
  <div class="mb-4"><label class="form-label">Subject <span class="text-red-500">*</span></label><input name="subject" required placeholder="Brief description of the issue" class="form-input"></div>
  <div class="mb-4"><label class="form-label">Description <span class="text-red-500">*</span></label><textarea name="description" rows="5" required placeholder="Describe your issue in detail…" class="form-input resize-none"></textarea></div>
  <div class="mb-5"><label class="form-label">Attachment (optional)</label><input type="file" name="image" accept="image/*" class="form-input py-2"></div>
  <div class="flex gap-3"><button type="submit" class="btn-primary"><i class="fas fa-paper-plane"></i>Submit Ticket</button><a href="{{ route('admin.help-desk.index') }}" class="btn-secondary">Cancel</a></div>
  </form>
</div>
@endsection
