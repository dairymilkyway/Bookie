@extends('layouts.teacher')

@section('title', 'Dashboard')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold">Dashboard</h1>
    <p class="text-base-content/60 mt-1">Welcome back, {{ auth()->user()->name }}!</p>
</div>

{{-- Stats Cards --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="stat bg-base-100 rounded-2xl shadow-sm border border-base-200">
        <div class="stat-figure text-primary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
        </div>
        <div class="stat-title">Total Books</div>
        <div class="stat-value text-primary">{{ $totalBooks }}</div>
        <div class="stat-desc">In your library</div>
    </div>
    <div class="stat bg-base-100 rounded-2xl shadow-sm border border-base-200">
        <div class="stat-figure text-secondary">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
        </div>
        <div class="stat-title">Assignments</div>
        <div class="stat-value text-secondary">{{ $totalAssignments }}</div>
        <div class="stat-desc">Books assigned to students</div>
    </div>
    <a href="{{ route('teacher.requests.index') }}" class="stat bg-base-100 rounded-2xl shadow-sm border border-base-200 hover:shadow-md transition-shadow cursor-pointer">
        <div class="stat-figure text-warning">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
        </div>
        <div class="stat-title">Pending Requests</div>
        <div class="stat-value text-warning">{{ $pendingRequests }}</div>
        <div class="stat-desc">Awaiting your review</div>
    </a>
    <div class="stat bg-base-100 rounded-2xl shadow-sm border border-base-200">
        <div class="stat-figure text-accent">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
        </div>
        <div class="stat-title">Activity</div>
        <div class="stat-value text-accent">Active</div>
        <div class="stat-desc">Your account is active</div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="card bg-base-100 shadow-sm border border-base-200">
    <div class="card-body flex flex-col items-center">
        <h2 class="card-title text-lg mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 gap-6 w-full max-w-sm">
            <a href="{{ route('teacher.books.create') }}" class="btn btn-primary flex flex-col items-center justify-center p-6 text-center gap-2 rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span class="font-medium">Add New Book</span>
            </a>

            <a href="{{ route('teacher.books.index') }}" class="btn btn-outline flex flex-col items-center justify-center p-6 text-center gap-2 rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                <span class="font-medium">View All Books</span>
            </a>
        </div>
    </div>
</div>


    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body">
            <h2 class="card-title text-lg">Recent Books</h2>
            @if($recentBooks->count() > 0)
            <ul class="space-y-2 mt-2">
                @foreach($recentBooks as $book)
                <li class="flex items-center gap-3 p-2 rounded-lg hover:bg-base-200/50">
                    @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" class="w-10 h-10 object-cover rounded-lg" />
                    @else
                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    @endif
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-sm truncate">{{ $book->title }}</p>
                        <p class="text-xs text-base-content/50">{{ $book->created_at->diffForHumans() }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <p class="text-base-content/50 text-sm mt-2">No books yet. Create your first book!</p>
            @endif
        </div>
    </div>
</div>
@endsection
