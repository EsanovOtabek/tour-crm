@extends('layouts.dashboard')
@section('title', "Buyurtmalarni boshqarish")
@section('description', "Yangi buyurtmalarni boshqarish")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 rounded-lg shadow-sm sm:p-6 bg-white dark:bg-gray-800">
            <!-- Card header -->
            <div class="items-center justify-between lg:flex">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Buyurtmalar</h3>
                </div>

                <div class="items-center sm:flex space-x-3">
                    <!-- Filter dropdown -->
                    <form action="" method="GET" class="mb-4 lg:mb-0">
                        <select name="filter" id="filter"
                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                           focus:ring-primary-500 focus:border-primary-500 p-2.5
                           dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                           dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                onchange="this.form.submit()">
                            <option value="" {{ request('filter') === null ? 'selected' : '' }}>Amaldagi (barchasi)</option>
                            <option value="confirmed" {{ request('filter') === 'confirmed' ? 'selected' : '' }}>Tasdiqlangan</option>
                            <option value="cancelled" {{ request('filter') === 'cancelled' ? 'selected' : '' }}>Bekor qilingan</option>
                            <option value="completed" {{ request('filter') === 'completed' ? 'selected' : '' }}>Yakunlangan</option>
                            <option value="archive" {{ request('filter') === 'archive' ? 'selected' : '' }}>Arxiv (Tugagan)</option>
                        </select>
                    </form>
                    <button data-modal-target="createBookingModal" data-modal-toggle="createBookingModal" class="admin-add-btn" type="button">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Qo'shish
                    </button>

                    <button data-modal-target="copy_template" data-modal-toggle="copy_template" class="admin-add-btn" type="button">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Shablondan Nusxalash
                    </button>
                </div>
            </div>

            <!-- Bookings Table -->
            <div class="mt-5 z-0">
                <table id="bookings-table" class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-3 py-2">#</th>
                        <th scope="col" class="px-3 py-2">Buyurtma Kodi</th>
                        <th scope="col" class="px-3 py-2">Tur Kodi</th>
                        <th scope="col" class="px-3 py-2">Tur</th>
                        <th scope="col" class="px-3 py-2">Boshlanish</th>
                        <th scope="col" class="px-3 py-2">Tugash</th>
                        <th scope="col" class="px-3 py-2">Summa</th>
                        <th scope="col" class="px-3 py-2">Holati</th>
                        <th scope="col" class="px-3 py-2">
                            <span class="sr-only">Amallar</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bookings as $booking)
                        <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="px-3 py-2">{{ $loop->iteration }}</td>
                            <td class="px-3 py-2">
                                <span class="font-bold bg-green-100 dark:bg-green-950 text-black dark:text-white p-1 rounded">
                                    {{ $booking->unique_code ?? 'NULL' }}
                                </span>
                            </td>
                            <td class="px-3 py-2">
                                <span class="font-bold bg-primary-100 dark:bg-primary-950 text-black dark:text-white p-1 rounded">
                                    {{ $booking->tour->{'unique-code'} ?? 'NULL' }}
                                </span>
                            </td>
                            <td class="px-3 py-2">
                                <div class="font-medium text-gray-900 dark:text-white">
                                    {{ $booking->tour->name ?? 'Tur yo\'q' }}
                                </div>
                            </td>
                            <td class="px-3 py-2">
                                {{ $booking->start_date->format('d.m.Y') }}
                            </td>
                            <td class="px-3 py-2">
                                {{ $booking->end_date->format('d.m.Y') }}
                            </td>
                            <td class="px-3 py-2">
                                {{ number_format($booking->total_amount, 2) }}
                            </td>
                            <td class="px-3 py-2">
                                <span class="text-xs font-semibold px-2.5 py-0.5 rounded
                                    bg-{{ $booking->status == 'confirmed' ? 'green' : ($booking->status == 'cancelled' ? 'red' : ($booking->status == 'completed' ? 'purple' : 'yellow')) }}-100
                                    text-{{ $booking->status == 'confirmed' ? 'green' : ($booking->status == 'cancelled' ? 'red' : ($booking->status == 'completed' ? 'purple' : 'yellow')) }}-800
                                    dark:bg-{{ $booking->status == 'confirmed' ? 'green' : ($booking->status == 'cancelled' ? 'red' : ($booking->status == 'completed' ? 'purple' : 'yellow')) }}-200
                                    dark:text-{{ $booking->status == 'confirmed' ? 'green' : ($booking->status == 'cancelled' ? 'red' : ($booking->status == 'completed' ? 'purple' : 'yellow')) }}-800">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </td>
                            <td class="px-3 py-2 flex items-center justify-end">
                                <button id="dropdown-button-{{$booking->id}}" data-dropdown-toggle="dropdown-{{ $booking->id }}" class="inline-flex items-center text-sm font-medium hover:bg-gray-100 dark:hover:bg-gray-700 p-1.5 dark:hover-bg-gray-800 text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                                <div id="dropdown-{{ $booking->id }}" class="hidden z-20 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-1 text-sm" aria-labelledby="dropdown-button-{{$booking->id}}">

                                        <li>
                                            <!-- Group Members -->
                                            <a href="{{ route('bookings.group-members.index', $booking->id) }}" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                <x-s-v-g-s.users class="w-4 h-4 mr-2" />
                                                Guruh a'zolari
                                            </a>
                                        </li>

                                        <li>
                                            <!-- Expenses -->
                                            <a href="{{ route('bookings.expenses.index', $booking->id) }}" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                <x-s-v-g-s.coins class="w-4 h-4 mr-2" />
                                                Xarajatlar
                                            </a>
                                        </li>

                                        <li>
                                            <!-- Details -->
                                            <a href="{{ route('details.index', $booking->id) }}" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                <x-s-v-g-s.eye class="w-4 h-4 mr-2" />
                                                Detallar
                                            </a>
                                        </li>

                                        <li>
                                            <!-- Routes -->
                                            <a href="{{ route('mashruts.index', $booking->id) }}" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12v4m0 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4ZM8 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 0v2a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V8m0 0a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z"/>
                                                </svg>
                                                Mashrutlar
                                            </a>
                                        </li>

                                        <li>
                                            <!-- Gifts -->
                                            <a href="{{ route('booking-guides.index', $booking->id) }}" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                <svg class="w-4 h-4 mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M6 2c-1.10457 0-2 .89543-2 2v4c0 .55228.44772 1 1 1s1-.44772 1-1V4h12v7h-2c-.5523 0-1 .4477-1 1v2h-1c-.5523 0-1 .4477-1 1s.4477 1 1 1h5c.5523 0 1-.4477 1-1V3.85714C20 2.98529 19.3667 2 18.268 2H6Z"/>
                                                    <path d="M6 11.5C6 9.567 7.567 8 9.5 8S13 9.567 13 11.5 11.433 15 9.5 15 6 13.433 6 11.5ZM4 20c0-2.2091 1.79086-4 4-4h3c2.2091 0 4 1.7909 4 4 0 1.1046-.8954 2-2 2H6c-1.10457 0-2-.8954-2-2Z"/>
                                                </svg>
                                                Gitlar
                                            </a>
                                        </li>
                                        <li>
                                            <!-- Group Members -->
                                            <a href="{{ route('bookings.copy.from.booking', $booking) }}" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                <svg class="w-4 h-4 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd" d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z" clip-rule="evenodd"/>
                                                </svg>

                                                Nusxalash
                                            </a>
                                        </li>
                                        <li>
                                            <!-- Change -->
                                            <a href="{{ route('bookings.changeMarked', $booking->id) }}" class="flex w-full items-center py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white text-gray-700 dark:text-gray-200">
                                                (*)
                                                @if(!$booking->is_marked)
                                                    Shablonga qo'shish
                                                @else
                                                    Shablondan olib tashlash
                                                @endif
                                            </a>
                                        </li>
                                        <li>
                                            <!-- Edit -->
                                            <button data-modal-target="editBookingModal-{{ $booking->id }}" data-modal-toggle="editBookingModal-{{ $booking->id }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 w-full text-left">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                                </svg>
                                                Tahrirlash
                                            </button>
                                        </li>
                                        <li>
                                            <!-- Delete -->
                                            <button data-modal-target="deleteBookingModal-{{ $booking->id }}" data-modal-toggle="deleteBookingModal-{{ $booking->id }}" class="flex items-center px-4 py-2 text-sm text-red-700 hover:bg-red-100 dark:text-red-300 dark:hover:bg-red-600 w-full text-left">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                O'chirish
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Booking Modal -->
                        <div id="editBookingModal-{{ $booking->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                <!-- Modal content -->
                                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <!-- Modal header -->
                                    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            Buyurtmani tahrirlash
                                        </h3>
                                        <button type="button" class="admin-close-modal-btn" data-modal-hide="editBookingModal-{{ $booking->id }}">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Yopish</span>
                                        </button>
                                    </div>
                                    <!-- Modal body -->
                                    <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                            <div>
                                                <label for="edit-tour-{{ $booking->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tur</label>
                                                <select name="tour_id" id="edit-tour-{{ $booking->id }}" class="e-input" required>
                                                    @foreach($tours as $tour)
                                                        <option value="{{ $tour->id }}" {{ $booking->tour_id == $tour->id ? 'selected' : '' }}>{{ $tour->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div>
                                                <label for="{{ $booking->id }}-unique_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unique Code</label>
                                                <input type="text" name="unique_code" id="{{ $booking->id }}-unique_code" class="e-input" required placeholder="UNIQUE CODE" value="{{ $booking->unique_code }}">
                                            </div>

                                            <div>
                                                <label for="edit-status-{{ $booking->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Holati</label>
                                                <select name="status" id="edit-status-{{ $booking->id }}" class="e-input" required>
                                                    <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Tasdiqlangan</option>
                                                    <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Bekor qilingan</option>
                                                    <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Yakunlangan</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="edit-start-date-{{ $booking->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Boshlanish sanasi</label>
                                                <input type="date" name="start_date" id="edit-start-date-{{ $booking->id }}" value="{{ $booking->start_date->format('Y-m-d') }}" class="e-input" required>
                                            </div>
                                            <div>
                                                <label for="edit-end-date-{{ $booking->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tugash sanasi</label>
                                                <input type="date" name="end_date" id="edit-end-date-{{ $booking->id }}" value="{{ $booking->end_date->format('Y-m-d') }}" class="e-input" required>
                                            </div>
                                            <div>
                                                <label for="edit-price-{{ $booking->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Narxi</label>
                                                <input type="number" step="0.01" name="price" id="edit-price-{{ $booking->id }}" value="{{ $booking->price }}" class="e-input" required>
                                            </div>
                                            <div>
                                                <label for="edit-cost-price-{{ $booking->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tan narxi</label>
                                                <input type="number" step="0.01" name="cost_price" id="edit-cost-price-{{ $booking->id }}" value="{{ $booking->cost_price }}" class="e-input" required>
                                            </div>
                                            <div>
                                                <label for="edit-total-amount-{{ $booking->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ja'mi summa</label>
                                                <input type="number" step="0.01" name="total_amount" id="edit-total-amount-{{ $booking->id }}" value="{{ $booking->total_amount }}" class="e-input" required>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <button type="submit" class="admin-add-btn">
                                                Yangilash
                                            </button>
                                            <button type="button" data-modal-hide="editBookingModal-{{ $booking->id }}" class="admin-cancel-btn">
                                                Bekor qilish
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Booking Modal -->
                        <div id="deleteBookingModal-{{ $booking->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteBookingModal-{{ $booking->id }}">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Yopish</span>
                                    </button>
                                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="mb-4 text-gray-500 dark:text-gray-300">O'chirganingizdan keyin uni qayta tiklab bo'lmaydi</p>
                                    <div class="flex justify-center items-center space-x-4">
                                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="py-2 px-3 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                Ha, o'chirish
                                            </button>
                                        </form>
                                        <button data-modal-toggle="deleteBookingModal-{{ $booking->id }}" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            Bekor qilish
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Booking Modal -->
    <div id="createBookingModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Yangi buyurtma
                    </h3>
                    <button type="button" class="admin-close-modal-btn" data-modal-hide="createBookingModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Yopish</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div>
                            <label for="create-tour" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tur</label>
                            <div class="select2-purple">
                                <select name="tour_id" id="create-tour" class="e-input select-tour" required
                                        data-placeholder="Turni tanlang" data-dropdown-css-class="select2-purple"
                                        style="width: 100%;">
                                    <option selected disabled>Turni tanlang</option>
                                    @foreach($tours as $tour)
                                        <option value="{{ $tour->id }}">{{ $tour->{'unique-code'} }}  -  {{ $tour->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div>
                            <label for="create-unique_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unique Code</label>
                            <input type="text" name="unique_code" id="create-unique_code" class="e-input" required placeholder="UNIQUE CODE">
                        </div>

                        <div>
                            <label for="create-status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Holati</label>
                            <select name="status" id="create-status" class="e-input" required>
                                <option value="confirmed">Tasdiqlangan</option>
                                <option value="cancelled">Bekor qilingan</option>
                                <option value="completed">Yakunlangan</option>
                            </select>
                        </div>
                        <div>
                            <label for="create-start-date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Boshlanish sanasi</label>
                            <input type="date" name="start_date" id="create-start-date" class="e-input" required>
                        </div>
                        <div>
                            <label for="create-end-date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tugash sanasi</label>
                            <input type="date" name="end_date" id="create-end-date" class="e-input" required>
                        </div>
                        <!-- PriceList va Custom Price tanlash -->
                        <div>
                            <label for="create-price-select" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Narxi</label>
                            <select id="create-price-select" class="e-input" required>
                                <option selected disabled value="">-- Narxni tanlang --</option>
                                @foreach ($priceList as $price)
                                    <option value="{{ $price->price }}" data-tour="{{ $price->tour_id }}">
                                        ({{ $price->quantity }} kishilik): {{ number_format($price->price, 2) }} so'm
                                    </option>
                                @endforeach
                                <option value="custom">Boshqa</option>
                            </select>
                            <input type="number" step="0.01" name="price" id="create-price-input" class="e-input mt-2 hidden" placeholder="Boshqa narx kiriting">
                        </div>

                        <div>
                            <label for="create-cost-price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tan narxi</label>
                            <input type="number" step="0.01" name="cost_price" id="create-cost-price" class="e-input" required>
                        </div>
                        <div>
                            <label for="create-total-amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ja'mi summa</label>
                            <input type="number" step="0.01" name="total_amount" id="create-total-amount" class="e-input" required>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="admin-add-btn">
                            Saqlash
                        </button>
                        <button type="button" data-modal-hide="createBookingModal" class="admin-cancel-btn">
                            Bekor qilish
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.tailwindcss.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <style>
        .select-tour{
            @apply shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500;
        }
        .dataTables_wrapper .dataTables_length select {
            @apply bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500;
        }

        .dataTables_wrapper .dataTables_filter input {
            @apply bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500;
        }

        .dataTables_wrapper.dark {
            @apply text-gray-300;
        }

        .dataTables_wrapper.dark .dataTables_info {
            @apply text-gray-400;
        }

        .dataTables_wrapper.dark .dataTables_paginate .paginate_button {
            @apply text-gray-300 hover:text-white hover:bg-gray-700;
        }

        .dataTables_wrapper.dark .dataTables_paginate .paginate_button.current {
            @apply text-white bg-gray-700 border-gray-700;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Select2 ni ishga tushirish
            $('.select-tour').select2({
                placeholder: "Turni tanlang",
                width: '100%'
            });

            // Initialize DataTable
            var table = $('#bookings-table').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Qidirish...",
                    lengthMenu: "_MENU_ ta yozuvni ko'rsatish",
                    info: "_START_ dan _END_ gacha _TOTAL_ ta yozuvdan",
                    infoEmpty: "0 dan 0 gacha 0 ta yozuvdan",
                    infoFiltered: "(jami _MAX_ ta yozuvdan filtrlangan)",
                    paginate: {
                        first: "Birinchi",
                        last: "Oxirgi",
                        next: "Keyingi",
                        previous: "Oldingi"
                    }
                },
                columnDefs: [
                    { orderable: false, targets: -1 }
                ]
            });

            // Dark mode toggle support
            document.addEventListener('dark-mode', function(e) {
                if (e.detail.dark) {
                    $('.dataTables_wrapper').addClass('dark');
                } else {
                    $('.dataTables_wrapper').removeClass('dark');
                }
            });

            if (document.documentElement.classList.contains('dark')) {
                $('.dataTables_wrapper').addClass('dark');
            }

            // Price selection handlers
            function handlePriceSelection() {
                const selectedValue = $('#create-price-select').val();
                if (selectedValue === 'custom') {
                    $('#create-price-input').removeClass('hidden').val('').focus();
                } else {
                    $('#create-price-input').addClass('hidden').val(selectedValue);
                }
            }

            // Filter price options based on selected tour
            function filterPriceOptions(tourId) {
                $('#create-price-select option').each(function() {
                    const optionTourId = $(this).data('tour');
                    if (!optionTourId || $(this).val() === 'custom' || $(this).val() === '') {
                        $(this).show();
                    } else {
                        $(this).toggle(optionTourId == tourId);
                    }
                });
                $('#create-price-select').val('').trigger('change');
                $('#create-price-input').addClass('hidden').val('');
            }

            // Tour selection change handler
            $('#create-tour').on('change', function() {
                const selectedTour = $(this).val();
                filterPriceOptions(selectedTour);
            });

            // Price select change handler
            $('#create-price-select').on('change', handlePriceSelection);

            // Initialize price options on page load
            const initialTour = $('#create-tour').val();
            if (initialTour) {
                filterPriceOptions(initialTour);
            }
        });
    </script>
@endpush
