@extends('layouts.auth')

@section('title', 'Create Account')

@section('content')
<div class="min-h-[calc(100vh-68px)] flex items-center justify-center bg-gradient-to-br from-primary/5 via-base-100 to-secondary/5 px-4 py-12">
    <div class="card w-full max-w-md bg-base-100 shadow-2xl border border-base-200">
        <div class="card-body p-8">
            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-secondary/10 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-secondary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                </div>
                <h1 class="text-2xl font-bold">Create Account</h1>
                <p class="text-base-content/60 mt-1">Join Bookie as a student</p>
            </div>

            {{-- Error Alert --}}
            @if ($errors->any())
            <div class="alert alert-error mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <div>
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            {{-- Register Form --}}
            <form method="POST" action="{{ route('register') }}">
                @csrf

 <div class="form-control mb-5">
    <label class="label" for="name">
        <span class="label-text font-medium">Full Name</span>
    </label>
    <div class="input input-bordered flex items-center gap-3 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <input type="text" name="name" id="name" placeholder="Enter your full name" class="grow w-full" value="{{ old('name') }}" required autofocus />
    </div>
</div>

<div class="form-control mb-5">
    <label class="label" for="username">
        <span class="label-text font-medium">Username</span>
    </label>
    <div class="input input-bordered flex items-center gap-3 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
        </svg>
        <input type="text" name="username" id="username" placeholder="Choose a username" class="grow w-full" value="{{ old('username') }}" required />
    </div>
</div>

<div class="form-control mb-5">
    <label class="label" for="email">
        <span class="label-text font-medium">Email</span>
    </label>
    <div class="input input-bordered flex items-center gap-3 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
        </svg>
        <input type="email" name="email" id="email" placeholder="Enter your email" class="grow w-full" value="{{ old('email') }}" required />
    </div>
</div>

<div class="form-control mb-5">
    <label class="label" for="password">
        <span class="label-text font-medium">Password</span>
    </label>
    <div class="input input-bordered flex items-center gap-3 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
        </svg>
        <input type="password" name="password" id="password" placeholder="Create a password" class="grow w-full" required />
    </div>
</div>

<div class="form-control mb-6">
    <label class="label" for="password_confirmation">
        <span class="label-text font-medium">Confirm Password</span>
    </label>
    <div class="input input-bordered flex items-center gap-3 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
        </svg>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm your password" class="grow w-full" required />
    </div>
</div>

                <button type="submit" class="btn btn-primary w-full gap-2 text-base">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                    Create Account
                </button>
            </form>

            {{-- Login Link --}}
            <p class="text-center text-sm text-base-content/60 mt-6">
                Already have an account?
                <a href="{{ route('login') }}" class="link link-primary font-medium">Sign in here</a>
            </p>
        </div>
    </div>
</div>
@endsection
