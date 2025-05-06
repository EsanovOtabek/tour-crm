@extends('layouts.dashboard')
@section('title', "Buyurtma uchun Shablonlar")
@section('description', "Buyurtma uchun Shablonlar")

@section('content')
    <div class="px-4 pt-2 min-h-screen">
        <div class="p-4 rounded-lg shadow-sm ">
            <!-- Card header -->
            <div class="items-center justify-between lg:flex">
                <div class="mb-2 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Buyurtma uchun Shablonlar</h3>
                </div>
            </div>

            <!-- Bookings Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-3">
                @foreach($bookings as $booking)
                    <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 overflow-hidden">
                        <div class="flex flex-row">
                            <!-- Left section - Booking information (larger part) -->
                            <div class="p-3 w-3/5">
                                <div class="flex justify-between items-start flex-wrap gap-2">
                                    <div>
                                        <h5 class="mb-2 text-md font-bold tracking-tight text-gray-900 dark:text-white">
                                            {{ $booking->tour->name ?? 'No Tour' }}
                                        </h5>
                                        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                            {{ $booking->user->name ?? 'No User' }}
                                        </span>
                                    </div>
                                    <span class="text-[10px] font-semibold px-2.5 py-0.5 rounded
                                        bg-{{ $booking->status == 'confirmed' ? 'green' : ($booking->status == 'cancelled' ? 'red' : ($booking->status == 'completed' ? 'purple' : 'yellow')) }}-100
                                        text-{{ $booking->status == 'confirmed' ? 'green' : ($booking->status == 'cancelled' ? 'red' : ($booking->status == 'completed' ? 'purple' : 'yellow')) }}-800
                                        dark:bg-{{ $booking->status == 'confirmed' ? 'green' : ($booking->status == 'cancelled' ? 'red' : ($booking->status == 'completed' ? 'purple' : 'yellow')) }}-200
                                        dark:text-{{ $booking->status == 'confirmed' ? 'green' : ($booking->status == 'cancelled' ? 'red' : ($booking->status == 'completed' ? 'purple' : 'yellow')) }}-800">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </div>

                                <div class="mt-3 space-y-2 text-xs text-gray-800 dark:text-gray-100">
                                    <p><span class="font-semibold">Davomiyligi:</span> {{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}</p>
                                    <p><span class="font-semibold">Narxi:</span> {{ number_format($booking->price, 2) }}</p>
                                    <p><span class="font-semibold">Tan narxi:</span> {{ number_format($booking->cost_price, 2) }}</p>
                                    <p><span class="font-semibold">Ja'mi summa:</span> {{ number_format($booking->total_amount, 2) }}</p>
                                </div>
                            </div>

                            <!-- Right section - Actions (like sidebar menu) -->
                            <div class="bg-gray-50 dark:bg-gray-700 px-1 py-3 w-2/5 border-t md:border-t-0 md:border-l border-gray-200 dark:border-gray-600">
                                <div class="flex flex-col space-y-1">
                                    <!-- Group Members -->
                                    <a href="{{ route('bookings.group-members.index', $booking->id) }}" class="admin-add-btn text-xs">
                                        Guruh a'zolari ({{$booking->groupMembers()->count()}} ta)
                                    </a>

                                    <!-- Expenses -->
                                    <a href="{{ route('bookings.expenses.index', $booking->id) }}" class="admin-delete-btn text-xs">
                                        Xarajatlar
                                    </a>

                                    <!-- Details -->
                                    <a href="{{ route('details.index', $booking->id) }}" class="admin-info-btn text-xs">
                                        Detallar
                                    </a>

                                    <!-- Routes -->
                                    <a href="{{ route('mashruts.index', $booking->id) }}" class="admin-purple-btn text-xs">
                                        Mashrutlar
                                    </a>

                                    <!-- Gifts -->
                                    <a href="{{ route('booking-guides.index', $booking->id) }}" class="admin-pink-btn text-xs">
                                        Gitlar
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Bottom section - Edit/Delete buttons -->
                        <div class="bg-gray-100 dark:bg-gray-700 px-2 py-2 flex justify-start space-x-2 border-t border-gray-200 dark:border-gray-600">

                            @if($booking->recommendedPrice['recommendation'])
                                <!-- Notification Button -->
                                <button type="button"
                                        onclick="showRecommendationToast({{ $booking->recommendedPrice['member'] }}, {{ $booking->recommendedPrice['price'] }})"
                                        class="relative inline-flex items-center p-3 text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:outline-none animate-ring-pulse dark:bg-blue-600 dark:hover:bg-blue-700">
                                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                         fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                              d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm9.408-5.5a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2h-.01ZM10 10a1 1 0 1 0 0 2h1v3h-1a1 1 0 1 0 0 2h4a1 1 0 1 0 0-2h-1v-4a1 1 0 0 0-1-1h-2Z"
                                              clip-rule="evenodd" />
                                    </svg>
                                    <span class="sr-only">Notifications</span>
                                </button>

                            @endif

                            <!-- Edit Button -->
                            <button type="button" data-modal-target="editBookingModal-{{ $booking->id }}" data-modal-toggle="editBookingModal-{{ $booking->id }}" class="admin-edit-btn text-xs">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                </svg>
                                Tahrirlash
                            </button>

                        </div>
                    </div>
                    <!-- Edit Booking Modal -->
                    <div id="editBookingModal-{{ $booking->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                            <!-- Modal content -->
                            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                <!-- Modal header -->
                                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Edit Booking
                                    </h3>
                                    <button type="button" class="admin-close-modal-btn" data-modal-hide="editBookingModal-{{ $booking->id }}">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                        <div>
                                            <label for="edit-tour-{{ $booking->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tour</label>
                                            <select name="tour_id" id="edit-tour-{{ $booking->id }}" class="e-input" required>
                                                @foreach($tours as $tour)
                                                    <option value="{{ $tour->id }}" {{ $booking->tour_id == $tour->id ? 'selected' : '' }}>{{ $tour->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label for="edit-status-{{ $booking->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                            <select name="status" id="edit-status-{{ $booking->id }}" class="e-input" required>
                                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                                <option value="completed" {{ $booking->status == 'completed' ? 'selected' : '' }}>Completed</option>
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
                                            <label for="edit-cost-price-{{ $booking->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cost Price</label>
                                            <input type="number" step="0.01" name="cost_price" id="edit-cost-price-{{ $booking->id }}" value="{{ $booking->cost_price }}" class="e-input" required>
                                        </div>
                                        <div>
                                            <label for="edit-total-amount-{{ $booking->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Amount</label>
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
                @endforeach
            </div>
        </div>
    </div>


    <!-- Toast Notification -->
    <div id="toast-recommendation" class="fixed hidden top-20 left-1/2 transform -translate-x-1/2 flex items-center w-full max-w-md p-4 space-x-4 text-gray-500 bg-orange-50 rounded-lg shadow-lg border border-orange-200 animate-slideDown dark:bg-orange-800 dark:border-orange-700 dark:text-orange-100" role="alert">
        <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-lg dark:bg-orange-700 dark:text-orange-200">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
            </svg>
            <span class="sr-only">Warning icon</span>
        </div>
        <div class="text-sm font-medium" id="toast-message"></div>
        <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-orange-50 text-orange-500 rounded-lg focus:ring-2 focus:ring-orange-400 p-1.5 hover:bg-orange-200 inline-flex items-center justify-center h-8 w-8 dark:bg-orange-800 dark:text-orange-200 dark:hover:bg-orange-700" data-dismiss-target="#toast-recommendation" aria-label="Close">
            <span class="sr-only">Close</span>
            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
            </svg>
        </button>
    </div>
@endsection

@push('styles')
    <style>
        @keyframes slideDown {
            from {
                transform: translate(-50%, -100%);
                opacity: 0;
            }
            to {
                transform: translate(-50%, 0);
                opacity: 1;
            }
        }
        .animate-slideDown {
            animation: slideDown 0.5s ease-out forwards;
        }

        @keyframes ring-pulse {
            0% {
                box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.6);
            }
            50% {
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
            }
            100% {
                box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.6);
            }
        }

        .animate-ring-pulse {
            animation: ring-pulse 1.5s infinite;
        }

    </style>
@endpush


@push('scripts')
    <script>
        const priceSelect = document.getElementById('create-price-select');
        const priceInput = document.getElementById('create-price-input');
        const tourSelect = document.getElementById('create-tour');

        function handlePriceSelection() {
            const selectedValue = priceSelect.value;
            if (selectedValue === 'custom') {
                priceInput.classList.remove('hidden');
                priceInput.value = '';
            } else {
                priceInput.classList.add('hidden');
                priceInput.value = selectedValue;
            }
        }

        // Tour tanlanganda tegishli narxlar chiqsin
        tourSelect.addEventListener('change', function () {
            const selectedTour = tourSelect.value;

            Array.from(priceSelect.options).forEach(option => {
                const tourId = option.getAttribute('data-tour');
                // "Select Price" va "Boshqa" optionlarni doimo ko‘rsatamiz
                if (!tourId || option.value === 'custom' || option.value === '') {
                    option.hidden = false;
                } else {
                    option.hidden = tourId !== selectedTour;
                }
            });

            priceSelect.value = '';
            priceInput.classList.add('hidden');
            priceInput.value = '';
        });

        // Sahifa yuklanganda barcha tourga bog‘liq narxlarni yashirish
        window.addEventListener('DOMContentLoaded', function () {
            const selectedTour = tourSelect.value;

            Array.from(priceSelect.options).forEach(option => {
                const tourId = option.getAttribute('data-tour');
                if (!tourId || option.value === 'custom' || option.value === '') {
                    option.hidden = false;
                } else {
                    option.hidden = selectedTour !== tourId;
                }
            });
        });


        function showRecommendationToast(memberCount, recommendedPrice) {
            const toast = document.getElementById('toast-recommendation');
            const message = document.getElementById('toast-message');

            message.textContent = `Recommended price for ${memberCount} members: ${recommendedPrice}`;

            toast.classList.remove('hidden');
            toast.classList.add('flex');

            // Auto-hide after 5 seconds
            setTimeout(() => {
                toast.classList.add('hidden');
                toast.classList.remove('flex');
            }, 5000);
        }

        // Close button functionality
        document.querySelectorAll('[data-dismiss-target="#toast-recommendation"]').forEach(button => {
            button.addEventListener('click', () => {
                const toast = document.getElementById('toast-recommendation');
                toast.classList.add('hidden');
                toast.classList.remove('flex');
            });
        });

    </script>
@endpush
