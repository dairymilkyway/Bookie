{{-- Guest Navbar Component — used on landing, login, register --}}
<div class="navbar bg-base-100/80 backdrop-blur-lg sticky top-0 z-50 shadow-sm border-b border-base-200">
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
                    <li class="mt-2 border-t border-base-200 pt-2">
                        <a href="{{ route('login') }}" class="font-medium">Sign In</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}" class="font-medium text-primary">Register</a>
                    </li>
                </ul>
            </div>

            {{-- Logo --}}
            <a href="{{ route('landing') }}" class="btn btn-ghost text-xl font-bold gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Bookie</span>
            </a>
        </div>

        {{-- Navbar Center: Menu (hidden on mobile) --}}
        <div class="navbar-center hidden lg:flex">
            <ul class="menu menu-horizontal px-1 gap-1">
            </ul>
        </div>

        {{-- Navbar End: Sign In / Register buttons --}}
        <div class="navbar-end flex gap-2">
            <a href="{{ route('login') }}" class="btn btn-ghost btn-sm lg:btn-md font-medium">Sign In</a>
            <a href="{{ route('register') }}" class="btn btn-primary btn-sm lg:btn-md font-medium">Register</a>
        </div>
    </div>
</div>
