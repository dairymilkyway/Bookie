<!DOCTYPE html>
<html lang="en" data-theme="emerald">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Teacher Dashboard') - {{ config('app.name', 'Bookie') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-base-200">
    <div class="drawer lg:drawer-open">
        <input id="teacher-drawer" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col">
            {{-- Top Navbar (mobile only) --}}
            <div class="navbar bg-base-100 shadow-sm border-b border-base-200 lg:hidden">
                <div class="flex-none">
                    <label for="teacher-drawer" class="btn btn-square btn-ghost drawer-button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </label>
                </div>
                <div class="flex-1">
                    <span class="text-lg font-bold">Teacher Panel</span>
                </div>
                <div class="flex-none">
                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar placeholder">
                            <div class="bg-primary text-primary-content rounded-full w-10">
                                <span class="text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
                            </div>
                        </div>
                        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-lg bg-base-100 rounded-box w-52 border border-base-200">
                            <li class="menu-title"><span>{{ auth()->user()->name }}</span></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="text-error">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Main Content --}}
            <main class="flex-1 p-4 lg:p-8">
                {{-- Flash Messages --}}
                @if(session('success'))
                <div class="alert alert-success mb-6 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-error mb-6 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                @yield('content')
            </main>
        </div>

        {{-- Sidebar Component --}}
        <div class="drawer-side z-40">
            <label for="teacher-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
            <x-sidebar-teacher />
        </div>
    </div>
    {{-- Global Modals --}}
    @include('components.modals.feedback')
    @include('components.modals.confirm')
</body>
</html>
