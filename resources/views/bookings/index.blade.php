@extends('layouts.dashboard')
@section('title', "Bookings Management")
@section('description', "Manage tour bookings")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 rounded-lg shadow-sm sm:p-6">
            <!-- Card header -->
            <div class="items-center justify-between lg:flex">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Tour Bookings</h3>
                </div>

                <div class="items-center sm:flex space-x-3">
                    <!-- Filter dropdown -->
                    <form action="" method="GET" class="mb-4 lg:mb-0">
                        <select name="filter" id="filter"
                                class="w-96 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                           focus:ring-primary-500 focus:border-primary-500 p-2.5
                           dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                           dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                onchange="this.form.submit()">

                            <option value="" {{ request('filter') === null ? 'selected' : '' }}>Amaldagi (barchasi)</option>
                            <option value="confirmed" {{ request('filter') === 'confirmed' ? 'selected' : '' }}>Tasdiqlangan (Confirmed)</option>
                            <option value="cancelled" {{ request('filter') === 'cancelled' ? 'selected' : '' }}>Bekor qilingan (Cancelled)</option>
                            <option value="completed" {{ request('filter') === 'completed' ? 'selected' : '' }}>Yakunlangan (Completed)</option>
                            <option value="archive" {{ request('filter') === 'archive' ? 'selected' : '' }}>Arxiv (Tugagan)</option>

                        </select>
                    </form>
                    <button data-modal-target="createBookingModal" data-modal-toggle="createBookingModal" class="admin-add-btn" type="button">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Add New Booking
                    </button>
                </div>
            </div>

            <!-- Bookings Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                @foreach($bookings as $booking)
                    <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                        {{ $booking->tour->name ?? 'No Tour' }}
                                    </h5>
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                        {{ $booking->user->name ?? 'No User' }}
                                    </span>
                                </div>
                                <span class="bg-{{
                                    $booking->status == 'confirmed' ? 'green' :
                                    ($booking->status == 'cancelled' ? 'red' :
                                    ($booking->status == 'completed' ? 'purple' : 'yellow'))
                                }}-100 text-{{
                                    $booking->status == 'confirmed' ? 'green' :
                                    ($booking->status == 'cancelled' ? 'red' :
                                    ($booking->status == 'completed' ? 'purple' : 'yellow'))
                                }}-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-{{
                                    $booking->status == 'confirmed' ? 'green' :
                                    ($booking->status == 'cancelled' ? 'red' :
                                    ($booking->status == 'completed' ? 'purple' : 'yellow'))
                                }}-200 dark:text-{{
                                    $booking->status == 'confirmed' ? 'green' :
                                    ($booking->status == 'cancelled' ? 'red' :
                                    ($booking->status == 'completed' ? 'purple' : 'yellow'))
                                }}-800">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>

                            <div class="mt-4 space-y-2">
                                <p class="text text-gray-600 dark:text-gray-300">
                                    <span class="font-semibold">Dates:</span>
                                    {{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}
                                </p>
                                <p class="text text-gray-600 dark:text-gray-300">
                                    <span class="font-semibold">Price:</span> ${{ number_format($booking->price, 2) }}
                                </p>
                                <p class="text text-gray-600 dark:text-gray-300">
                                    <span class="font-semibold">Cost Price:</span> ${{ number_format($booking->cost_price, 2) }}
                                </p>
                                <p class="text text-gray-600 dark:text-gray-300">
                                    <span class="font-semibold">Total Amount:</span> ${{ number_format($booking->total_amount, 2) }}
                                </p>
                            </div>

                            <div class="mt-4 flex space-x-2">
                                <a href="{{ route('bookings.group-members.index', $booking->id) }}"  class="admin-add-btn">
                                    <x-s-v-g-s.users class="w-4 h-4 mr-2"></x-s-v-g-s.users>
                                    Members
                                </a>
                                <button type="button" data-modal-target="editBookingModal-{{ $booking->id }}" data-modal-toggle="editBookingModal-{{ $booking->id }}" class="admin-edit-btn">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Edit
                                </button>
                                <button type="button" data-modal-target="deleteBookingModal-{{ $booking->id }}" data-modal-toggle="deleteBookingModal-{{ $booking->id }}" class="admin-delete-btn">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </button>
                            </div>
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
                                            <label for="edit-start-date-{{ $booking->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Date</label>
                                            <input type="date" name="start_date" id="edit-start-date-{{ $booking->id }}" value="{{ $booking->start_date->format('Y-m-d') }}" class="e-input" required>
                                        </div>
                                        <div>
                                            <label for="edit-end-date-{{ $booking->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Date</label>
                                            <input type="date" name="end_date" id="edit-end-date-{{ $booking->id }}" value="{{ $booking->end_date->format('Y-m-d') }}" class="e-input" required>
                                        </div>
                                        <div>
                                            <label for="edit-price-{{ $booking->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
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
                                            Update Booking
                                        </button>
                                        <button type="button" data-modal-hide="editBookingModal-{{ $booking->id }}" class="admin-cancel-btn">
                                            Cancel
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
                                    <span class="sr-only">Close modal</span>
                                </button>
                                <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this booking?</p>
                                <div class="flex justify-center items-center space-x-4">
                                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="py-2 px-3 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                            Yes, I'm sure
                                        </button>
                                    </form>
                                    <button data-modal-toggle="deleteBookingModal-{{ $booking->id }}" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        No, cancel
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
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
                        Add New Booking
                    </h3>
                    <button type="button" class="admin-close-modal-btn" data-modal-hide="createBookingModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('bookings.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div>
                            <label for="create-tour" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tour</label>
                            <select name="tour_id" id="create-tour" class="e-input" required>
                                <option selected disabled>Select Tour</option>
                                @foreach($tours as $tour)
                                    <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="create-status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select name="status" id="create-status" class="e-input" required>
                                <option value="confirmed">Confirmed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <div>
                            <label for="create-start-date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Start Date</label>
                            <input type="date" name="start_date" id="create-start-date" class="e-input" required>
                        </div>
                        <div>
                            <label for="create-end-date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Date</label>
                            <input type="date" name="end_date" id="create-end-date" class="e-input" required>
                        </div>
                        <!-- PriceList va Custom Price tanlash -->
                        <div>
                            <label for="create-price-select" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>

                            <select id="create-price-select" class="e-input" onchange="handlePriceSelection()" required>
                                <option selected disabled value="">-- Select Price --</option>
                                @foreach ($priceList as $price)
                                    <option value="{{ $price->price }}" data-tour="{{ $price->tour_id }}">
                                        ({{ $price->quantity }} kishilik): {{ $price->price }} so'm
                                    </option>
                                @endforeach
                                <option value="custom">Boshqa</option>
                            </select>

                            <input type="number" step="0.01" name="price" id="create-price-input" class="e-input mt-2 hidden" placeholder="Enter custom price">
                        </div>

                        <div>
                            <label for="create-cost-price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cost Price</label>
                            <input type="number" step="0.01" name="cost_price" id="create-cost-price" class="e-input" required>
                        </div>
                        <div>
                            <label for="create-total-amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Amount</label>
                            <input type="number" step="0.01" name="total_amount" id="create-total-amount" class="e-input" required>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="admin-add-btn">
                            Create Booking
                        </button>
                        <button type="button" data-modal-hide="createBookingModal" class="admin-cancel-btn">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


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
    </script>
@endpush
