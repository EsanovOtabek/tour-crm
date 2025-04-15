@extends('components.layouts.main')

@section('title', "Parolni tasdiqlang")
@section('description', "")

@section('content')
    <div class="flex flex-col items-center justify-center px-6 pt-5 mx-auto md:h-screen pt:mt-0 dark:bg-gray-900">
        <a href="{{ route('dashboard') }}"
           class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 dark:text-white">
            <img src="{{ Vite::asset('resources/images/logo.png') }}" class="mr-4 h-11" alt="EducIT logo">
        </a>

        <!-- Card -->
        <div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow dark:bg-gray-800">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                Parolni tasdiqlang
            </h2>

            <p class="text-sm text-gray-600 dark:text-gray-400">
                Bu xavfsiz hudud. Davom etishdan oldin iltimos, parolingizni tasdiqlang.
            </p>

            <form class="mt-8 space-y-4" method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div>
                    <label for="password" class="e-label">Parol</label>
                    <input type="password" name="password" id="password"
                           class="e-input"
                           placeholder="••••••••"
                           required autocomplete="current-password">
                </div>

                <button type="submit" class="auth-btn">Tasdiqlash</button>

                <div class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    Parolni unutdingizmi? <a class="text-green-700 hover:underline dark:text-green-500"
                                             href="{{ route('password.request') }}">Yangi parol so'rash</a>
                </div>
            </form>

            <hr class="divide-green-950">

        </div>
    </div>
@endsection
