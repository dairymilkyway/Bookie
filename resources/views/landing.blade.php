@extends('layouts.landing')

@section('content')
{{-- Navbar --}}
<x-navbar-guest />

{{-- Hero Section --}}
<section class="hero min-h-[85vh] bg-gradient-to-br from-primary/5 via-base-100 to-secondary/5">
    <div class="hero-content text-center py-20">
        <div class="max-w-3xl">
            <div class="badge badge-primary badge-outline mb-6 gap-2 py-3 px-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                Streamlined Book Management
            </div>
            <h1 class="text-5xl lg:text-7xl font-black leading-tight">
                Assign Books.
                <br>
                <span class="bg-gradient-to-r from-primary to-secondary bg-clip-text text-transparent">Empower Learning.</span>
            </h1>
            <p class="py-8 text-lg lg:text-xl text-base-content/70 max-w-2xl mx-auto leading-relaxed">
                A modern platform that connects teachers and students through seamless book assignments. Manage your library, assign resources, and track learning — all in one place.
            </p>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg gap-2 shadow-lg shadow-primary/25 hover:shadow-primary/40 transition-all">
                    Get Started
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                </a>
                <a href="#features" class="btn btn-ghost btn-lg gap-2">
                    Learn More
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                </a>
            </div>
</section>

{{-- Features Section --}}
<section id="features" class="py-24 bg-base-200/50">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl lg:text-5xl font-bold mb-4">Everything You Need</h2>
            <p class="text-base-content/60 text-lg max-w-2xl mx-auto">A complete toolkit for managing educational resources.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            {{-- Feature 1 --}}
            <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border border-base-200">
                <div class="card-body items-center text-center">
                    <div class="w-14 h-14 rounded-2xl bg-primary/10 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    <h3 class="card-title text-lg mb-2">Classroom Management</h3>
                    <p class="text-base-content/60 text-sm">Teachers can easily create book records and assign them to specific students in just a few clicks.</p>
                </div>
            </div>

            {{-- Feature 2 --}}
            <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border border-base-200">
                <div class="card-body items-center text-center">
                    <div class="w-14 h-14 rounded-2xl bg-secondary/10 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                    </div>
                    <h3 class="card-title text-lg mb-2">Student Requests</h3>
                    <p class="text-base-content/60 text-sm">Students can browse the full library and request books they need, streamlining the distribution process.</p>
                </div>
            </div>

            {{-- Feature 3 --}}
            <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border border-base-200">
                <div class="card-body items-center text-center">
                    <div class="w-14 h-14 rounded-2xl bg-accent/10 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <h3 class="card-title text-lg mb-2">Smart Discovery</h3>
                    <p class="text-base-content/60 text-sm">Powerful search and category filtering help users find exactly what they're looking for instantly.</p>
                </div>
            </div>

            {{-- Feature 4 --}}
            <div class="card bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border border-base-200">
                <div class="card-body items-center text-center">
                    <div class="w-14 h-14 rounded-2xl bg-info/10 flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-info" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <h3 class="card-title text-lg mb-2">Role-Based Views</h3>
                    <p class="text-base-content/60 text-sm">Dedicated dashboards for teachers and students ensure everyone stays focused on their tasks.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-24">
    <div class="container mx-auto px-6">
        <div class="card bg-gradient-to-r from-primary to-secondary text-primary-content shadow-2xl">
            <div class="card-body items-center text-center py-16">
                <h2 class="text-3xl lg:text-4xl font-bold mb-4">Ready to Get Started?</h2>
                <p class="text-lg opacity-90 max-w-xl mb-8">Create your account today and start managing or browsing books. It's quick, easy, and secure.</p>
                <div class="flex gap-4 flex-wrap justify-center">
                    <a href="{{ route('register') }}" class="btn btn-lg bg-white text-primary hover:bg-base-200 border-0 gap-2 shadow-lg">
                        Create Account
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-lg btn-outline border-white text-white hover:bg-white/10 hover:border-white gap-2">
                        Sign In
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Footer --}}
<footer class="footer footer-center p-10 bg-base-200 text-base-content">
    <aside>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
        <p class="font-bold text-lg">Bookie</p>
        <p class="text-base-content/60">A modern book assignment platform for education.</p>
    </aside>
</footer>
@endsection
