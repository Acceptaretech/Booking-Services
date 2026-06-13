<div class="space-y-6">

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6 flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $title }}</h2>

        <a href="{{ route('admin.blogs.index') }}"
           class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
            <i class="fas fa-angle-double-left mr-1"></i> Back
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-6">
        <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
            @csrf

            @if($method == 'PUT')
                @method('PUT')
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title"
                           value="{{ old('title', $blog->title ?? '') }}"
                           class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white"
                           placeholder="Enter blog title">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                        Author <span class="text-red-500">*</span>
                    </label>
                    <select name="author_id"
                            class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white">
                        <option value="">Select Author</option>
                        @foreach($authors as $author)
                        <option value="{{ $author->id }}"
                            {{ old('author_id', $blog->author_id ?? '') == $author->id ? 'selected' : '' }}>
                            {{ trim(($author->first_name ?? '') . ' ' . ($author->last_name ?? '')) ?: $author->email }}
                        </option>
                        @endforeach
                    </select>
                    @error('author_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status"
                            class="w-fullborder-gray-300 dark:bg-gray-900 dark:text-white">
                        <option value="published" {{ old('status', $blog->status ?? '') == 'published' ? 'selected' : '' }}>
                            Published
                        </option>
                        <option value="draft" {{ old('status', $blog->status ?? '') == 'draft' ? 'selected' : '' }}>
                            Draft
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                        Image
                    </label>
                    <input type="file" name="image"
                           class="w-full  border border-gray-300 p-2 dark:bg-gray-900 dark:text-white">

                    @if(!empty($blog?->image))
                        <img src="{{ asset('storage/'.$blog->image) }}"
                             class="w-24 h-24 object-cover mt-3">
                    @endif
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                        Read Time
                    </label>
                    <input type="number" name="read_time"
                           value="{{ old('read_time', $blog->read_time ?? '') }}"
                           class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white"
                           placeholder="5">
                </div>

                <div>
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                        Meta Title
                    </label>
                    <input type="text" name="meta_title"
                           value="{{ old('meta_title', $blog->meta_title ?? '') }}"
                           class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white"
                           placeholder="SEO title">
                </div>

                <div class="lg:col-span-3">
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                        Meta Description
                    </label>
                    <textarea name="meta_description" rows="3"
                              class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white"
                              placeholder="SEO description">{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>
                </div>

                <div class="lg:col-span-3">
                    <label class="block mb-2 font-semibold text-gray-700 dark:text-gray-200">
                        Content <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" id="editor" rows="10"
                              class="w-full rounded-xl border-gray-300 dark:bg-gray-900 dark:text-white"
                              placeholder="Write blog content">{{ old('content', $blog->content ?? '') }}</textarea>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="flex justify-end gap-3 mt-8">
                <a href="{{ route('admin.blogs.index') }}"
                   class="px-5 py-2.5 rounded-xl bg-gray-200 text-gray-700 font-semibold hover:bg-gray-300">
                    Cancel
                </a>

                <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-indigo-700">
                    <i class="fas fa-save mr-1"></i>
                    {{ $blog ? 'Update Blog' : 'Save Blog' }}
                </button>
            </div>

        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
ClassicEditor.create(document.querySelector('#editor')).catch(error => console.error(error));
</script>