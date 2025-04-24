@extends('layouts.dashboard')
@section('title', "Buyurtma Detallari")
@section('description', "Booking uchun ob'ektlar/itemlarni boshqarish")

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
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Buyurtma Detallari</h3>
                </div>
                <div class="items-center sm:flex">
                    <button data-modal-target="createDetailModal" data-modal-toggle="createDetailModal" class="admin-add-btn" type="button">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Detal qo'shish
                    </button>
                </div>
            </div>

            <!-- Details Table -->
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-primary-200 dark:bg-primary-900 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">#</th>
                        <th scope="col" class="py-3 px-6">Hamkor</th>
                        <th scope="col" class="py-3 px-6">Ob'ekt</th>
                        <th scope="col" class="py-3 px-6">Soni</th>
                        <th scope="col" class="py-3 px-6">Narx</th>
                        <th scope="col" class="py-3 px-6">Tannarx</th>
                        <th scope="col" class="py-3 px-6">Sana</th>
                        <th scope="col" class="py-3 px-6">Izoh</th>
                        <th scope="col" class="py-3 px-6 text-right">Amallar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($bookingDetails as $detail)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-4 px-6">
                                {{ $loop->index + 1 }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-medium text-gray-900 dark:text-white">
                                    {{ $detail->partner->name ?? 'Hamkor yo\'q' }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                {{ $detail->objectItem->name ?? 'Ob\'ekt yo\'q' }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $detail->quantity }}
                            </td>
                            <td class="py-4 px-6">
                                {{ number_format($detail->price, 2) }}
                            </td>
                            <td class="py-4 px-6">
                                {{ number_format($detail->cost_price, 2) }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $detail->sana ? $detail->sana->format('d.m.Y') : 'Sana yo\'q' }}
                            </td>
                            <td class="py-4 px-6">
                                {{ $detail->comment ?? 'Izoh yo\'q' }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <button data-modal-target="editDetailModal-{{ $detail->id }}" data-modal-toggle="editDetailModal-{{ $detail->id }}" class="admin-edit-btn">
                                    Tahrirlash
                                </button>
                                <button data-modal-target="deleteDetailModal-{{ $detail->id }}" data-modal-toggle="deleteDetailModal-{{ $detail->id }}" class="admin-delete-btn">
                                    O'chirish
                                </button>
                            </td>
                        </tr>

                        <!-- Edit Detail Modal -->
                        <div id="editDetailModal-{{ $detail->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            Detalni tahrirlash
                                        </h3>
                                        <button type="button" class="admin-close-modal-btn" data-modal-hide="editDetailModal-{{ $detail->id }}">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Yopish</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('details.update', [$booking->id, $detail->id]) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="grid gap-4 mb-4">
                                            <div>
                                                <label for="edit-partner-{{ $detail->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hamkor</label>
                                                <select name="partner_id" required id="edit-partner-{{ $detail->id }}" class="e-input">
                                                    <option value="">Hamkorni tanlang</option>
                                                    @foreach($partners as $partner)
                                                        <option value="{{ $partner->id }}" {{ $detail->partner_id == $partner->id ? 'selected' : '' }}>{{ $partner->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label for="edit-object-{{ $detail->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ob'ekt</label>
                                                <select name="object_item_id" required id="edit-object-{{ $detail->id }}" class="e-input object-select">
                                                    <option value="">Avval hamkorni tanlang</option>
                                                    <!-- Objects will be loaded via JavaScript -->
                                                </select>
                                            </div>
                                            <div>
                                                <label for="edit-quantity-{{ $detail->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Soni</label>
                                                <input type="number" name="quantity" id="edit-quantity-{{ $detail->id }}" value="{{ $detail->quantity }}" class="e-input" required min="1">
                                            </div>
                                            <div>
                                                <label for="edit-sana-{{ $detail->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sana</label>
                                                <input type="date" name="sana" id="edit-sana-{{ $detail->id }}" value="{{ $detail->sana ? $detail->sana->format('Y-m-d') : '' }}" class="e-input">
                                            </div>
                                            <div>
                                                <label for="edit-comment-{{ $detail->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Izoh</label>
                                                <textarea name="comment" id="edit-comment-{{ $detail->id }}" class="e-input">{{ $detail->comment }}</textarea>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <button type="submit" class="admin-add-btn">
                                                Saqlash
                                            </button>
                                            <button type="button" data-modal-hide="editDetailModal-{{ $detail->id }}" class="admin-cancel-btn">
                                                Bekor qilish
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Detail Modal -->
                        <div id="deleteDetailModal-{{ $detail->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteDetailModal-{{ $detail->id }}">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Yopish</span>
                                    </button>
                                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="mb-4 text-gray-500 dark:text-gray-300">{{ $detail->objectItem->name ?? 'Detal' }} ni rostdan ham o'chirmoqchimisiz?</p>
                                    <div class="flex justify-center items-center space-x-4">
                                        <form action="{{ route('details.destroy', [$booking->id, $detail->id]) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="py-2 px-3 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                Ha, o'chirish
                                            </button>
                                        </form>
                                        <button data-modal-toggle="deleteDetailModal-{{ $detail->id }}" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            Yo'q, bekor qilish
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td colspan="9" class="py-4 px-6 text-center text-gray-500 dark:text-gray-400">
                                Detallar topilmadi
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Detail Modal -->
    <div id="createDetailModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Detal qo'shish
                    </h3>
                    <button type="button" class="admin-close-modal-btn" data-modal-hide="createDetailModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Yopish</span>
                    </button>
                </div>
                <form action="{{ route('details.store', $booking->id) }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4">
                        <div>
                            <label for="create-partner" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hamkor</label>
                            <select name="partner_id" required id="create-partner" class="e-input">
                                <option value="">Hamkorni tanlang</option>
                                @foreach($partners as $partner)
                                    <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="create-object" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ob'ekt</label>
                            <select name="object_item_id" required id="create-object" class="e-input object-select">
                                <option value="">Avval hamkorni tanlang</option>
                                <!-- Objects will be loaded via JavaScript -->
                            </select>
                        </div>
                        <div>
                            <label for="create-quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Soni</label>
                            <input type="number" name="quantity" id="create-quantity" class="e-input" required min="1" value="1">
                        </div>
                        <div>
                            <label for="create-sana" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sana</label>
                            <input type="date" name="sana" id="create-sana" class="e-input">
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
                        <button type="button" data-modal-hide="createDetailModal" class="admin-cancel-btn">
                            Bekor qilish
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to load objects for a partner
            function loadObjects(partnerId, objectSelect, selectedObjectId = null) {
                if (!partnerId) {
                    objectSelect.innerHTML = '<option value="">Avval hamkorni tanlang</option>';
                    return;
                }

                fetch(`/api/partners/${partnerId}/objects`)
                    .then(response => response.json())
                    .then(data => {
                        objectSelect.innerHTML = '<option value="">Ob\'ektni tanlang</option>';
                        data.forEach(object => {
                            const option = new Option(object.name, object.id);
                            option.dataset.salePrice = object.sale_price;
                            option.dataset.price = object.price;
                            if (selectedObjectId && object.id == selectedObjectId) {
                                option.selected = true;
                            }
                            objectSelect.add(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading objects:', error);
                        objectSelect.innerHTML = '<option value="">Yuklashda xatolik</option>';
                    });
            }

            // Create modal event listeners
            const createPartnerSelect = document.getElementById('create-partner');
            const createObjectSelect = document.getElementById('create-object');

            if (createPartnerSelect && createObjectSelect) {
                createPartnerSelect.addEventListener('change', function() {
                    loadObjects(this.value, createObjectSelect);
                });
            }

            // Edit modals event listeners
            document.querySelectorAll('[id^="edit-partner-"]').forEach(partnerSelect => {
                const detailId = partnerSelect.id.replace('edit-partner-', '');
                const objectSelect = document.getElementById(`edit-object-${detailId}`);

                if (objectSelect) {
                    // Add change event listener
                    partnerSelect.addEventListener('change', function() {
                        loadObjects(this.value, objectSelect);
                    });

                    // Initialize with current values when modal opens
                    const modalToggle = document.querySelector(`[data-modal-toggle="editDetailModal-${detailId}"]`);
                    if (modalToggle) {
                        modalToggle.addEventListener('click', function() {
                            // Load objects when modal is opened
                            loadObjects(partnerSelect.value, objectSelect, objectSelect.dataset.selectedObjectId);
                        });
                    }

                    // Store the current object_item_id value for later use
                    if (objectSelect.value) {
                        objectSelect.dataset.selectedObjectId = objectSelect.value;
                    }
                }
            });

            // Initially load objects for edit modals that are already populated
            document.querySelectorAll('[id^="edit-partner-"]').forEach(partnerSelect => {
                if (partnerSelect.value) {
                    const detailId = partnerSelect.id.replace('edit-partner-', '');
                    const objectSelect = document.getElementById(`edit-object-${detailId}`);
                    if (objectSelect && objectSelect.value) {
                        objectSelect.dataset.selectedObjectId = objectSelect.value;
                        loadObjects(partnerSelect.value, objectSelect, objectSelect.value);
                    }
                }
            });
        });
    </script>
@endpush
