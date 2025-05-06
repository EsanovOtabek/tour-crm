@extends('layouts.dashboard')
@section('title', "Gidlar Boshqaruvi")
@section('description', "Booking uchun gidlarni boshqarish")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 rounded-lg shadow-sm sm:p-6">
            <!-- Booking Info Card -->
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-6">
                <div class="p-5 flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Booking #{{ $booking->id }} - {{ $booking->tour->name ?? 'Tur yo\'q' }}
                        </h5>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                {{ $booking->user->name ?? 'Foydalanuvchi yo\'q' }}
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
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                            <p><span class="font-semibold">Sana:</span>
                                {{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}
                            </p>
                            <p><span class="font-semibold">Umumiy summa:</span> {{ number_format($booking->total_amount, 2) }}</p>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('bookings.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-gray-600 rounded-lg hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Bookinglarga qaytish
                        </a>
                    </div>
                </div>
            </div>
            <hr class="mb-3">

            <!-- Card header -->
            <div class="items-center justify-between lg:flex mb-6">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Gidlar</h3>
                </div>
                <div class="items-center sm:flex">
                    <button data-modal-target="createGuideModal" data-modal-toggle="createGuideModal" class="admin-add-btn" type="button">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Gid biriktirish
                    </button>
                </div>
            </div>

            <!-- Guides Table -->
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-primary-200 dark:bg-primary-900 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">#</th>
                        <th scope="col" class="py-3 px-6">Gid</th>
                        <th scope="col" class="py-3 px-6">Shahar</th>
                        <th scope="col" class="py-3 px-6">Summa</th>
                        <th scope="col" class="py-3 px-6">Boshlash sanasi</th>
                        <th scope="col" class="py-3 px-6">Tugash sanasi</th>
                        <th scope="col" class="py-3 px-6">Izoh</th>
                        <th scope="col" class="py-3 px-6 text-right">Amallar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($bookingGuides as $guide)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-4 px-6">
                                {{ $loop->index + 1 }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-medium text-gray-900 dark:text-white">
                                    {{ $guide->guide->name ?? 'Gid yo\'q' }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                {{ $guide->tourCity->name ?? 'Shahar yo\'q' }}
                            </td>
                            <td class="py-4 px-6">
                                {{ number_format($guide->summa, 2) }} {{ $guide->guide->currency->code ?? '' }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $guide->start_date ? $guide->start_date->format('d.m.Y') : 'Sana yo\'q' }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $guide->end_date ? $guide->end_date->format('d.m.Y') : 'Sana yo\'q' }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $guide->comment ?? 'Izoh yo\'q' }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <button data-modal-target="editGuideModal-{{ $guide->id }}" data-modal-toggle="editGuideModal-{{ $guide->id }}" class="admin-edit-btn">
                                    Tahrirlash
                                </button>
                                <button data-modal-target="deleteGuideModal-{{ $guide->id }}" data-modal-toggle="deleteGuideModal-{{ $guide->id }}" class="admin-delete-btn">
                                    O'chirish
                                </button>
                            </td>
                        </tr>

                        <!-- Edit Guide Modal -->
                        <div id="editGuideModal-{{ $guide->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            Gidni tahrirlash
                                        </h3>
                                        <button type="button" class="admin-close-modal-btn" data-modal-hide="editGuideModal-{{ $guide->id }}">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Yopish</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('booking-guides.update', [$booking->id, $guide->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="grid gap-4 mb-4">
                                            <div>
                                                <label for="edit-city-{{ $guide->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Shahar</label>
                                                <select name="tour_city_id" id="edit-city-{{ $guide->id }}" class="e-input city-select">
                                                    <option value="">Shaharni tanlang</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{ $city->id }}" {{ $guide->tour_city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label for="edit-category-{{ $guide->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Shahar</label>
                                                <select name="category_id" id="edit-category-{{ $guide->id }}" class="e-input">
                                                    <option value="">Gid Kategoriyasi</option>
                                                    @foreach($categories as $cat)
                                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label for="edit-guide-{{ $guide->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gid</label>
                                                <select name="guide_id" required id="edit-guide-{{ $guide->id }}" class="e-input guide-select">
                                                    <option value="" selected disabled>Gidni tanlang</option>
                                                    <!-- Gidlar JavaScript orqali yuklanadi -->
                                                </select>
                                            </div>
                                            <div>
                                                <label for="edit-summa-{{ $guide->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                    Summa ({{ $guide->guide->currency->code ?? 'USD' }})
                                                </label>
                                                <div class="relative">
                                                    <input type="number" name="summa" id="edit-summa-{{ $guide->id }}" value="{{ $guide->summa }}" class="e-input" required>
                                                    <span class="absolute right-3 top-2 text-gray-500 text-sm">{{ $guide->guide->currency->code ?? 'USD' }}</span>
                                                </div>
                                            </div>
                                            <div>
                                                <label for="edit-start_date-{{ $guide->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Boshlash sanasi</label>
                                                <input type="date" name="start_date" id="edit-start_date-{{ $guide->id }}"
                                                       value="{{ $guide->start_date ? $guide->start_date->format('Y-m-d') : '' }}" class="e-input" required
                                                       min="{{ $booking->start_date->format('Y-m-d') }}"
                                                       max="{{ $booking->end_date->format('Y-m-d') }}">
                                            </div>
                                            <div>
                                                <label for="edit-end_date-{{ $guide->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tugash sanasi</label>
                                                <input type="date" name="end_date" id="edit-end_date-{{ $guide->id }}"
                                                       value="{{ $guide->end_date ? $guide->end_date->format('Y-m-d') : '' }}" class="e-input" required
                                                       min="{{ $booking->start_date->format('Y-m-d') }}"
                                                       max="{{ $booking->end_date->format('Y-m-d') }}">
                                            </div>
                                            <div>
                                                <label for="edit-comment-{{ $guide->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Izoh</label>
                                                <textarea name="comment" id="edit-comment-{{ $guide->id }}" class="e-input">{{ $guide->comment }}</textarea>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <button type="submit" class="admin-add-btn">
                                                Saqlash
                                            </button>
                                            <button type="button" data-modal-hide="editGuideModal-{{ $guide->id }}" class="admin-cancel-btn">
                                                Bekor qilish
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Guide Modal -->
                        <div id="deleteGuideModal-{{ $guide->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteGuideModal-{{ $guide->id }}">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Yopish</span>
                                    </button>
                                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="mb-4 text-gray-500 dark:text-gray-300">{{ $guide->guide->name ?? 'Gid' }} ni rostdan ham o'chirmoqchimisiz?</p>
                                    <div class="flex justify-center items-center space-x-4">
                                        <form action="{{ route('booking-guides.destroy', [$booking->id, $guide->id]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="py-2 px-3 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                Ha, o'chirish
                                            </button>
                                        </form>
                                        <button data-modal-toggle="deleteGuideModal-{{ $guide->id }}" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            Yo'q, bekor qilish
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td colspan="7" class="py-4 px-6 text-center text-gray-500 dark:text-gray-400">
                                Gidlar topilmadi
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Guide Modal -->
    <div id="createGuideModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Gid biriktirish
                    </h3>
                    <button type="button" class="admin-close-modal-btn" data-modal-hide="createGuideModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Yopish</span>
                    </button>
                </div>
                <form action="{{ route('booking-guides.store', $booking->id) }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4">
                        <!-- Shahar tanlash -->
                        <div>
                            <label for="create-city" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Shahar</label>
                            <select name="tour_city_id" id="create-city" class="e-input">
                                <option value="">Shaharni tanlang</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Kategoriya tanlash -->
                        <div>
                            <label for="create-category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gid Kategoriyasi</label>
                            <select name="guide_category_id" id="create-category" class="e-input category-select">
                                <option value="">Kategoriyani tanlang</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Gid tanlash -->
                        <div>
                            <label for="create-guide" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gid</label>
                            <select name="guide_id" required id="create-guide" class="e-input guide-select">
                                <option value="" selected disabled>Gidni tanlang</option>
                            </select>
                        </div>

                        <div>
                            <label for="create-summa" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Summa (<span id="currency-code">USD</span>)</label>
                            <div class="relative">
                                <input type="number" name="summa" id="create-summa" class="e-input" required>
                                <span class="absolute right-3 top-2 text-gray-500 text-sm" id="currency-symbol">USD</span>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Gid tanlanganda uning narxi avtomatik ravishda kiritiladi</p>
                        </div>
                        <div>
                            <label for="create-start_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Boshlash sanasi</label>
                            <input type="date" name="start_date"
                                   id="create-start_date" class="e-input" required
                                   min="{{ $booking->start_date->format('Y-m-d') }}"
                                   max="{{ $booking->end_date->format('Y-m-d') }}">
                        </div>
                        <div>
                            <label for="create-end_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tugash sanasi</label>
                            <input type="date" name="end_date"
                                   id="create-end_date" class="e-input" required
                                   min="{{ $booking->start_date->format('Y-m-d') }}"
                                   max="{{ $booking->end_date->format('Y-m-d') }}">
                        </div>
                        <div>
                            <label for="create-comment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Izoh</label>
                            <textarea name="comment" id="create-comment" class="e-input"></textarea>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="admin-add-btn">
                            Qo'shish
                        </button>
                        <button type="button" data-modal-hide="createGuideModal" class="admin-cancel-btn">
                            Bekor qilish
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @php
        $mappedGuides = $guides->map(function($guide) {
            return [
                'id' => $guide->id,
                'name' => $guide->name,
                'price' => $guide->price ?? 0,
                'city_name' => $guide->tourCity->name ?? '',
                'category_id' => $guide->guide_category_id,
                'currency_code' => $guide->currency->code ?? 'USD',
                'currency_symbol' => $guide->currency->symbol ?? '$'
            ];
        });
    @endphp

    <script>
        $(function () {
            const allGuides = @json($mappedGuides);

            function loadGuides($categorySelect, $guideSelect, selectedGuideId = null) {
                const categoryId = parseInt($categorySelect.val());
                $slct = `<option value="" selected disabled>Gidni tanlang</option>`;

                if (!categoryId) return;

                allGuides
                    .filter(g => g.category_id == categoryId)
                    .forEach(g => {
                        $slct += `<option value="${g.id}" data-price="${g.price}" data-currency="${g.currency_code}" data-symbol="${g.currency_symbol}">${g.name}</option>`;

                    });
                $guideSelect.empty().append($slct);
            }


            // Create modal
            $('#create-category').on('change', function () {
                loadGuides($(this), $('#create-guide'));
            });

            $('#create-guide').on('change', function () {
                const $selected = $(this).find(':selected');

                $('#create-summa').val($selected.data('price'));
                $('#currency-code').text($selected.data('currency'));
                $('#currency-symbol').text($selected.data('symbol'));
            });

            $('#createGuideModal').on('shown.bs.modal', function () {
                loadGuides($('#create-category'), $('#create-guide'));
            });

            // Edit modallar
            $('[id^="edit-category-"]').each(function () {
                const guideId = this.id.replace('edit-category-', '');
                const $categorySelect = $(this);
                const $guideSelect = $(`#edit-guide-${guideId}`);
                const $summaInput = $(`#edit-summa-${guideId}`);

                $categorySelect.on('change', function () {
                    loadGuides($categorySelect, $guideSelect);
                });

                $guideSelect.on('change', function () {
                    const $selected = $(this).find(':selected');
                    $summaInput.val($selected.data('price'));
                });

                $(`#editGuideModal-${guideId}`).on('shown.bs.modal', function () {
                    loadGuides($categorySelect, $guideSelect, $guideSelect.val());
                });
            });
        });
    </script>
@endpush
