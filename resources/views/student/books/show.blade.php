@extends('layouts.student')

@section('title', $book->title)

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ url()->previous() == route('student.books') ? route('student.books') : route('student.browse') }}" class="btn btn-ghost gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Cover Image --}}
        <div class="lg:col-span-1">
            <div class="card bg-base-100 shadow-xl overflow-hidden">
      <figure class="aspect-[2/3] relative flex items-center justify-center bg-gradient-to-br from-secondary/10 to-accent/10">
    @if($book->cover_image)
        <img src="{{ asset('storage/' . $book->cover_image) }}" 
             alt="{{ $book->title }}" 
             class="w-full h-full object-cover" />
    @else
        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-secondary/30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
    @endif

    @if($isAssigned)
        <div class="absolute top-4 right-4 badge badge-success gap-2 p-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
            Assigned
        </div>
    @elseif($isRequested)
        <div class="absolute top-4 right-4 badge badge-info gap-2 p-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Requested
        </div>
    @endif
</figure>

            </div>
        </div>

        {{-- Details --}}
        <div class="lg:col-span-2 space-y-6">
            <div>
                <div class="flex flex-wrap items-center gap-3 mb-2">
                    @if($book->category)
                        <div class="badge badge-outline">{{ $book->category }}</div>
                    @endif
                    <div class="text-sm text-base-content/60">By {{ $book->author ?? 'Unknown Author' }}</div>
                </div>
                <h1 class="text-4xl font-bold mb-4">{{ $book->title }}</h1>
                <div class="prose max-w-none">
                    <h3 class="text-lg font-semibold mb-2">Description</h3>
                    <p class="text-base-content/80 leading-relaxed">{{ $book->description }}</p>
                </div>
            </div>

            <div class="divider"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="card bg-base-200">
                    <div class="card-body p-4">
                        <div class="text-sm opacity-60">Teacher</div>
                        <div class="font-medium flex items-center gap-2">
                            <div class="avatar placeholder">
                                <div class="bg-neutral text-neutral-content rounded-full w-8">
                                    <span class="text-xs">{{ substr($book->teacher->name ?? 'T', 0, 1) }}</span>
                                </div>
                            </div>
                            {{ $book->teacher->name ?? 'Unknown' }}
                        </div>
                    </div>
                </div>
                <div class="card bg-base-200">
                    <div class="card-body p-4">
                        <div class="text-sm opacity-60">Status</div>
                        <div class="font-medium">
                            @if($isAssigned)
                                <span class="text-success">Assigned to you</span>
                            @elseif($isRequested)
                                <span class="text-info">Request Pending</span>
                            @else
                                <span class="text-base-content/60">Available to Request</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if(!$isAssigned && !$isRequested)
                <div class="mt-8">
                    <button onclick="requestBook({{ $book->id }})" class="btn btn-primary btn-lg gap-2 w-full sm:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        Request This Book
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

@if(!$isAssigned && !$isRequested)
<script>
    function requestBook(bookId) {
        showConfirm(
            'Are you sure you want to request this book?',
            function() {
                $.ajax({
                    url: '{{ route("student.request.store") }}',
                    method: 'POST',
                    data: {
                        book_id: bookId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        showSuccess(response.message, 'Success', function() {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        showError(xhr.responseJSON.message || 'Error processing request');
                    }
                });
            },
            'Confirm Request',
            'Request Book'
        );
    }
</script>
@endif
@endsection
