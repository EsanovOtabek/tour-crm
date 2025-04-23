@extends('layouts.dashboard')
@section('title', "Mashrutlar Boshqaruvi")
@section('description', "Tur mashrutlarini boshqarish")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 rounded-lg shadow-sm sm:p-6">
            <!-- Booking Info Card -->
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-6">
                <div class="p-5 flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Booking #{{ $booking->id }} - {{ $booking->tour->name ?? 'No Tour' }}
                        </h5>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                {{ $booking->user->name ?? 'No User' }}
                            </span>
                            <span class="bg-{{
                                $booking->status == 'confirmed' ? 'green' :
                                ($booking->status == 'cancelled' ? 'red' : 'yellow')
                            }}-100 text-{{
                                $booking->status == 'confirmed' ? 'green' :
                                ($booking->status == 'cancelled' ? 'red' : 'yellow')
                            }}-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-{{
                                $booking->status == 'confirmed' ? 'green' :
                                ($booking->status == 'cancelled' ? 'red' : 'yellow')
                            }}-200 dark:text-{{
                                $booking->status == 'confirmed' ? 'green' :
                                ($booking->status == 'cancelled' ? 'red' : 'yellow')
                            }}-800">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('bookings.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-gray-600 rounded-lg hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Orqaga
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">

                <!-- Card header -->
                <div class="items-center justify-between lg:flex">
                    <div class="mb-4 lg:mb-0">
                        <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Mashrutlar</h3>
                        <p class="text-gray-600 dark:text-gray-400">Tur mashrutlari va dasturlari</p>
                    </div>
                    <div class="items-center sm:flex">
                        <button data-modal-target="createMashrutModal" data-modal-toggle="createMashrutModal" class="admin-add-btn" type="button">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Mashrut qo'shish
                        </button>
                        <a href="{{ route('bookings.mashruts.pdf', $booking->id) }}" target="_blank" class="admin-info-btn ml-3 inline-flex items-center">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 12h6a1 1 0 100-2H9a1 1 0 100 2zM9 16h6a1 1 0 100-2H9a1 1 0 100 2z"></path>
                                <path fill-rule="evenodd" d="M5 3a2 2 0 00-2 2v10a2 2 0 002 2h3v-2H5V5h10v10h-3v2h3a2 2 0 002-2V5a2 2 0 00-2-2H5z" clip-rule="evenodd"></path>
                            </svg>
                            Yuklab olish (PDF)
                        </a>

                    </div>
                </div>

                <!-- Mashrutlar Table -->
                <div class="flex flex-col mt-6">
                    <div class="overflow-x-auto rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">#</th>
                                <th scope="col" class="px-6 py-3">Shahar</th>
                                <th scope="col" class="px-6 py-3">Sana va Vaqt</th>
                                <th scope="col" class="px-6 py-3">Dastur</th>
                                <th scope="col" class="px-6 py-3">Tartib raqami</th>
                                <th scope="col" class="px-6 py-3">Harakatlar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($mashruts as $mashrut)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">{{ $mashrut->tourCity->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $mashrut->date_time->format('Y-m-d H:i') }}</td>
                                    <td class="px-6 py-4">{{ $mashrut->program ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $mashrut->order_no }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <button data-modal-target="editMashrutModal-{{ $mashrut->id }}" data-modal-toggle="editMashrutModal-{{ $mashrut->id }}" class="admin-edit-btn">
                                                Tahrirlash
                                            </button>
                                            <button data-modal-target="deleteMashrutModal-{{ $mashrut->id }}" data-modal-toggle="deleteMashrutModal-{{ $mashrut->id }}" class="admin-delete-btn">
                                                O'chirish
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Mashrut Modal -->
                                <div id="editMashrutModal-{{ $mashrut->id }}" tabindex="-1" class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full h-modal md:h-full">
                                    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5">
                                            <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-600">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    Mashrutni tahrirlash
                                                </h3>
                                                <button type="button" class="admin-close-modal-btn" data-modal-hide="editMashrutModal-{{ $mashrut->id }}">
                                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('mashruts.update', [$booking->id, $mashrut->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">Shahar</label>
                                                    <select name="tour_city_id" class="e-input" required>
                                                        @foreach($tourCities as $city)
                                                            <option value="{{ $city->id }}" {{ $mashrut->tour_city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">Sana va Vaqt</label>
                                                    <input type="datetime-local" name="date_time" value="{{ $mashrut->date_time->format('Y-m-d\TH:i') }}" class="e-input" required>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">Dastur</label>
                                                    <textarea name="program" class="e-input">{{ $mashrut->program }}</textarea>
                                                </div>
                                                <div class="flex justify-end space-x-2">
                                                    <button type="submit" class="admin-add-btn">Saqlash</button>
                                                    <button type="button" data-modal-hide="editMashrutModal-{{ $mashrut->id }}" class="admin-cancel-btn">Bekor qilish</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Mashrut Modal -->
                                <div id="deleteMashrutModal-{{ $mashrut->id }}" tabindex="-1" class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full h-modal md:h-full">
                                    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5 text-center">
                                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white" data-modal-hide="deleteMashrutModal-{{ $mashrut->id }}">
                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <svg class="mx-auto mb-4 w-12 h-12 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Haqiqatan ham ushbu mashrutni o'chirmoqchimisiz?</h3>
                                            <div class="flex justify-center space-x-4">
                                                <form action="{{ route('mashruts.destroy', [$booking->id, $mashrut->id] ) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="admin-delete-btn">
                                                        Ha, o'chirish
                                                    </button>
                                                </form>
                                                <button type="button" data-modal-hide="deleteMashrutModal-{{ $mashrut->id }}" class="admin-cancel-btn">
                                                    Yo'q, bekor qilish
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        Mashrutlar topilmadi
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Mashrut Modal -->
    <div id="createMashrutModal" tabindex="-1" class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5">
                <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Yangi mashrut qo'shish
                    </h3>
                    <button type="button" class="admin-close-modal-btn" data-modal-hide="createMashrutModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>

                </div>
                <form action="{{ route('mashruts.store', $booking->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Shahar</label>
                        <select name="tour_city_id" class="e-input" required>
                            <option value="">Shaharni tanlang</option>
                            @foreach($tourCities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Sana va Vaqt</label>
                        <input type="datetime-local" name="date_time" class="e-input" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Dastur</label>
                        <textarea name="program" class="e-input"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="submit" class="admin-add-btn">Qo'shish</button>
                        <button type="button" data-modal-hide="createMashrutModal" class="admin-cancel-btn">Bekor qilish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
