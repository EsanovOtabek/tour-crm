@extends('layouts.main')

@section('title', "Sign Up - TOUR APP")
@section('description', "")

@section('content')
    <div class="flex flex-col items-center justify-center px-6 pt-5 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900">
        <a href="{{ route('dashboard') }}"
           class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
            <img src="{{ asset('assets/images/logo.png') }}" class="mr-4 h-11 block dark:hidden" alt="Tour App">
            <img src="{{ asset('assets/images/logo_light.png') }}" class="mr-4 h-11 hidden dark:block" alt="Tour App">
        </a>

        <div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Ro'yxatdan o'tish
            </h2>

            <form class="mt-8 space-y-4" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="e-label">F.I.SH</label>
                    <input type="text" name="name" id="name"
                           class="e-input" placeholder="To‘liq ismingiz" value="{{ old('name') }}" required autofocus autocomplete="name">
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="e-label">Email</label>
                    <input type="email" name="email" id="email"
                           class="e-input" placeholder="mail@example.com" value="{{ old('email') }}" required autocomplete="username">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="e-label">Parol</label>
                    <input type="password" name="password" id="password"
                           class="e-input" placeholder="••••••••" required autocomplete="new-password">
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="e-label">Parolni tasdiqlang</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                           class="e-input" placeholder="••••••••" required autocomplete="new-password">
                </div>


                <button type="submit" class="auth-btn">Ro'yxatdan o'tish</button>

                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Oldin ro'yxatdan o'tganmisiz?
                    <a class="text-primary-700 hover:underline dark:text-primary-500" href="{{ route('login') }}">
                        Kirish
                    </a>
                </div>
            </form>

            <hr class="divide-primary-950">


        </div>
    </div>
@endsection
