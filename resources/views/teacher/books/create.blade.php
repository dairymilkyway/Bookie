@extends('layouts.teacher')

@section('title', 'Add New Book')

@section('content')
<div class="mb-6">
    <div class="flex items-center gap-2 text-sm breadcrumbs">
        <ul>
            <li><a href="{{ route('teacher.books.index') }}">My Books</a></li>
            <li>Add New Book</li>
        </ul>
    </div>
    <h1 class="text-3xl font-bold mt-2">Add New Book</h1>
</div>

<div class="card bg-base-100 shadow-sm border border-base-200 max-w-2xl mx-auto">
    <div class="card-body">
        <form method="POST" action="{{ route('teacher.books.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Title --}}
            <div class="form-control w-full mb-4">
                <label class="label">
                    <span class="label-text font-medium">Title <span class="text-error">*</span></span>
                </label>
                <input type="text" 
                       name="title" 
                       class="input input-bordered w-full @error('title') input-error @enderror" 
                       value="{{ old('title') }}" 
                       placeholder="Enter book title" 
                       required />
                @error('title')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            {{-- Description --}}
            <div class="form-control w-full mb-4">
                <label class="label">
                    <span class="label-text font-medium">Description <span class="text-error">*</span></span>
                </label>
                <textarea name="description" 
                          class="textarea textarea-bordered w-full h-32 @error('description') textarea-error @enderror" 
                          placeholder="Enter book description" 
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            {{-- Cover Image --}}
            <div class="form-control w-full mb-6">
                <label class="label">
                    <span class="label-text font-medium">Cover Image</span>
                </label>
                <input type="file" 
                       name="cover_image" 
                       class="file-input file-input-bordered w-full @error('cover_image') file-input-error @enderror" 
                       accept="image/*" />
                <label class="label">
                    <span class="label-text-alt text-base-content/50">JPG, PNG, GIF, WEBP. Max 2MB.</span>
                </label>
                @error('cover_image')
                    <label class="label">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex gap-3">
                <button type="submit" class="btn btn-primary gap-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Create Book
                </button>
                <a href="{{ route('teacher.books.index') }}" class="btn btn-ghost">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
