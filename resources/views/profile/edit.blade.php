@extends('layouts.dashboard')

@section('title', 'Profilni tahrirkasg')

@section('content')
    <div class="px-4 pt-6">
        <div class="grid gap-4 xl:grid-cols-2 2xl:grid-cols-3">
            <!-- Profile Information Card -->
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm 2xl:col-span-2 dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
                    <div class="w-full">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Profil ma'lumotlari</h3>


                        <form method="post" action="{{ route('profile.update') }}" class="space-y-6" enctype="multipart/form-data">
                            @csrf
                            @method('patch')

                            <div class="mb-4">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">To'liq ismi</label>
                                <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                @error('name')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                @error('email')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Telefon raqam --}}
                            <div class="mb-4">
                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telefon</label>
                                <input type="text" id="phone" name="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="+998(XX)0000000" value="{{ old('phone', $user->phone) }}" autocomplete="tel">
                                @error('phone')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Telegram ID --}}
                            <div class="mb-4">
                                <label for="telegram_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Telegram ID') }}</label>
                                <input type="text" id="telegram_id" name="telegram_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="telegram_id" value="{{ old('telegram_id', $user->telegram_id) }}">
                                @error('telegram_id')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Rasm yuklash (agar kerak bo‘lsa) --}}
                            <div class="mb-4">
                                <label for="picture" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Profil rasmi</label>
                                <input type="file" id="picture" name="picture" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 dark:bg-gray-700 dark:border-gray-600">
                                @error('picture')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                @enderror
                            </div>


                            <div class="flex items-center">
                                <button type="submit" class="admin-add-btn">
                                    {{ __('Save') }}
                                </button>

                                @if (session('status') === 'profile-updated')
                                    <p
                                        x-data="{ show: true }"
                                        x-show="show"
                                        x-transition
                                        x-init="setTimeout(() => show = false, 2000)"
                                        class="ml-4 text-sm text-gray-600 dark:text-gray-400"
                                    >Saqlandi</p>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Parolni yangilash</h3>
                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div class="mb-4">
                        <label for="current_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Current Password') }}</label>
                        <input type="password" id="current_password" name="current_password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" autocomplete="current-password">
                        @error('current_password', 'updatePassword')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('New Password') }}</label>
                        <input type="password" id="password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" autocomplete="new-password">
                        @error('password', 'updatePassword')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('Confirm Password') }}</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" autocomplete="new-password">
                        @error('password_confirmation', 'updatePassword')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center">
                        <button type="submit" class="admin-add-btn">
                            {{ __('Save') }}
                        </button>

                        @if (session('status') === 'password-updated')
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="ml-4 text-sm text-gray-600 dark:text-gray-400"
                            >Saqlandi</p>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Delete Account Card -->
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Akkauntni o'chirish</h3>
                <p class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                    Agar akkauntni o'chirsangiz siz qilgan barcha amallar yo'qoladi, va ULARNI QAYTA TIKLAB BO'LMAYDI
                </p>

                <button
                    type="button"
                    data-modal-target="delete-account-modal"
                    data-modal-toggle="delete-account-modal"
                    class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800"
                >
                    Akkauntni o'chirish
                </button>

                <!-- Delete Account Modal -->
                <div id="delete-account-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
                    <div class="relative w-full h-full max-w-md md:h-auto">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="delete-account-modal">
                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-6 text-center">
                                <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>

                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                                    Akkauntni o'chirganingizdan keyin uni qayta tiklab bo'lmaydi!!
                                </h3>

                                <form method="post" action="{{ route('profile.destroy') }}">
                                    @csrf
                                    @method('delete')

                                    <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                                        Agar akkauntni o'chirsangiz siz qilgan barcha amallar yo'qoladi, va ULARNI QAYTA TIKLAB BO'LMAYDI
                                    </p>

                                    <div class="mb-4">
                                        <label for="delete-account-password" class="sr-only">Parol</label>
                                        <input type="password" id="delete-account-password" name="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Parol">
                                        @error('password', 'userDeletion')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600" data-modal-hide="delete-account-modal">
                                        Bekor qilish
                                    </button>

                                    <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                                        Akkauntni o'chirish
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Initialize Flowbite components
        document.addEventListener('DOMContentLoaded', function() {
            // Modal initialization is handled by Flowbite's app.bundle.js
        });
    </script>
@endpush
