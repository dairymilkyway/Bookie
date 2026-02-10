{{-- Student Navbar Component --}}
<div class="navbar bg-base-100 shadow-sm border-b border-base-200 sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center">
        {{-- Navbar Start: Mobile menu & Logo --}}
        <div class="navbar-start flex items-center gap-2">
            {{-- Mobile menu --}}
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-200">
                    <li>
                        <a href="{{ route('student.books') }}" class="{{ request()->routeIs('student.books') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Assigned Books
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('student.browse') }}" class="{{ request()->routeIs('student.browse') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Browse Books
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('student.requests.index') }}" class="{{ request()->routeIs('student.requests.index') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            My Requests
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Logo --}}
            <a href="{{ route('student.books') }}" class="btn btn-ghost text-xl font-bold gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span class="bg-gradient-to-r from-secondary to-accent bg-clip-text text-transparent">Bookie</span>
            </a>
        </div>

        {{-- Navbar Center: Menu & Badge (hidden on mobile) --}}
        <div class="navbar-center hidden lg:flex items-center gap-2">
            <ul class="menu menu-horizontal px-1 gap-1">
                <li>
                    <a href="{{ route('student.books') }}" class="{{ request()->routeIs('student.books') ? 'active font-semibold' : '' }} font-medium gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                        Assigned Books
                    </a>
                </li>
                <li>
                    <a href="{{ route('student.browse') }}" class="{{ request()->routeIs('student.browse') ? 'active font-semibold' : '' }} font-medium gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        Browse Books
                    </a>
                </li>
                <li>
                    <a href="{{ route('student.requests.index') }}" class="{{ request()->routeIs('student.requests.index') ? 'active font-semibold' : '' }} font-medium gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        My Requests
                    </a>
                </li>
            </ul>
        </div>

        {{-- Navbar End: User dropdown --}}
        <div class="navbar-end flex items-center">
            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost gap-2 flex items-center">
                    <div class="avatar placeholder">
                        <div class="bg-secondary text-secondary-content rounded-full w-8">
                            <span class="text-xs">{{ substr(auth()->user()->name, 0, 1) }}</span>
                        </div>
                    </div>
                    <span class="hidden sm:inline text-sm font-medium">{{ auth()->user()->name }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-200">
                    <li class="w-full">
                        <form method="POST" action="{{ route('logout') }}" class="w-full flex justify-center">
                            @csrf
                            <button type="submit" class="w-full text-red-600 font-medium text-center hover:text-red-700 transition py-2">
                                Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
