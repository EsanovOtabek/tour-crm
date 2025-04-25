@extends('layouts.main')

@section('title', "Sign In - Tour")
@section('description', "")

@section('content')
    <div class="flex flex-col items-center justify-center px-6 pt-8 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900">
        <a href="{{ route('dashboard') }}"
           class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
            <img src="{{  asset('assets/images/logo.png') }}" class="mr-4 h-11 block dark:hidden" alt="EducIT">
            <img src="{{  asset('assets/images/logo_light.png') }}" class="mr-4 h-11 hidden dark:block" alt="EducIT">
        </a>

        <!-- Card -->
        <div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Tizimga kirish
            </h2>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 text-sm text-primary-600 dark:text-primary-400">
                    {{ session('status') }}
                </div>
            @endif

            <form class="mt-8 space-y-4" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="e-label">Email</label>
                    <input type="email" name="email" id="email"
                           class="e-input"
                           placeholder="mail@example.com"
                           value="{{ old('email') }}"
                           required autofocus autocomplete="username">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="e-label">Parol</label>
                    <input type="password" name="password" id="password"
                           class="e-input"
                           placeholder="••••••••"
                           required autocomplete="current-password">

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="ml-auto mt-2 text-sm block text-end text-primary-700 hover:underline dark:text-primary-500">
                            Parolni unutdingizmi?
                        </a>
                    @endif
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                           class="rounded border-gray-300 dark:bg-gray-900 dark:border-gray-700 text-primary-600 shadow-sm focus:ring-primary-500">
                    <label for="remember" class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                        Meni eslab qol
                    </label>
                </div>

                <button type="submit" class="auth-btn">Tizimga kirish</button>

                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Ro'yxatdan o'tmadingizmi?
                    <a class="text-primary-700 hover:underline dark:text-primary-500" href="{{ route('register') }}">
                        Ro'yxatdan o'tish
                    </a>
                </div>
            </form>

            <hr class="divide-primary-950">
        </div>
    </div>
@endsection
