@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
<div class="min-h-[calc(100vh-68px)] flex items-center justify-center bg-gradient-to-br from-primary/5 via-base-100 to-secondary/5 px-4 py-12">
    <div class="card w-full max-w-md bg-base-100 shadow-2xl border border-base-200">
        <div class="card-body p-8">
            {{-- Header --}}
            <div class="text-center mb-8">
                <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                </div>
                <h1 class="text-2xl font-bold">Welcome Back</h1>
                <p class="text-base-content/60 mt-1">Sign in to your account</p>
            </div>

            {{-- Error Alert --}}
            @if ($errors->any())
            <div class="alert alert-error mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-5 w-5" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

        <div class="form-control mb-5">
    <label class="label" for="username">
        <span class="label-text font-medium">Username</span>
    </label>
    <div class="input input-bordered flex items-center gap-3 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
        <input type="text" name="username" id="username" placeholder="Enter your username" class="grow w-full" value="{{ old('username') }}" required autofocus />
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
        <input type="password" name="password" id="password" placeholder="Enter your password" class="grow w-full" required />
    </div>
</div>


                <div class="form-control mb-6">
                    <label class="label cursor-pointer justify-start gap-3">
                        <input type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-sm" />
                        <span class="label-text">Remember me</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-full gap-2 text-base">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" /></svg>
                    Sign In
                </button>
            </form>

            {{-- Register Link --}}
            <p class="text-center text-sm text-base-content/60 mt-6">
                Don't have an account?
                <a href="{{ route('register') }}" class="link link-primary font-medium">Create one here</a>
            </p>

        </div>
    </div>
</div>
@endsection
