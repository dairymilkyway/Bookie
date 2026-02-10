{{-- Teacher Sidebar Component — used inside DaisyUI drawer --}}
<aside class="menu bg-base-100 text-base-content min-h-full w-72 p-0 border-r border-base-200">
    {{-- Brand --}}
    <div class="p-6 border-b border-base-200">
        <a href="{{ route('teacher.dashboard') }}" class="flex items-center gap-3 text-xl font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
            <span class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Bookie</span>
        </a>
        <p class="text-xs text-base-content/50 mt-1">Teacher Panel</p>
    </div>

    {{-- Navigation --}}
    <div class="p-4 flex-1">
        <ul class="menu gap-1">
            <li class="menu-title text-xs uppercase tracking-wider text-base-content/40 mb-1">Main</li>
            <li>
                <a href="{{ route('teacher.dashboard') }}" class="{{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    Dashboard
                </a>
            </li>

            <li class="menu-title text-xs uppercase tracking-wider text-base-content/40 mt-4 mb-1">Library</li>
            <li>
                <a href="{{ route('teacher.books.index') }}" class="{{ request()->routeIs('teacher.books.index') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    My Books
                </a>
            </li>
            <li>
                <a href="{{ route('teacher.requests.index') }}" class="{{ request()->routeIs('teacher.requests.index') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" /></svg>
                    Requests
                    @php
                        $pendingCount = \App\Models\BookRequest::whereHas('book', fn($q) => $q->where('created_by', auth()->id()))->where('status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="badge badge-warning badge-sm">{{ $pendingCount }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('teacher.assignments.all') }}" class="{{ request()->routeIs('teacher.assignments.all') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    Assigned Students
                </a>
            </li>
        </ul>
    </div>

    {{-- User Section --}}
    <div class="p-4 border-t border-base-200">
        <div class="flex items-center gap-3 p-3 rounded-lg bg-base-200/50">
            <div class="avatar placeholder">
                <div class="bg-primary text-primary-content rounded-full w-10">
                    <span class="text-sm font-medium">{{ substr(auth()->user()->name, 0, 1) }}</span>
                </div>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-medium text-sm truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-base-content/50">Teacher</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-ghost btn-sm btn-square" title="Logout">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                </button>
            </form>
        </div>
    </div>
</aside>
