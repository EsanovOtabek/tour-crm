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
                    <p class="text-sm text-gray-500 dark:text-gray-400">Detallar booking boshlanish sanasiga qarab tartiblangan</p>
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
                        <th scope="col" class="py-2 px-3 border">#</th>
                        <th scope="col" class="py-2 px-3 border">Hamkor turi</th>
                        <th scope="col" class="py-2 px-3 border">Hamkor</th>
                        <th scope="col" class="py-2 px-3 border">Obyekt</th>
                        <th scope="col" class="py-2 px-3 border">Obyekt mahsuloti</th>
                        <th scope="col" class="py-2 px-3 border">Soni</th>
                        <th scope="col" class="py-2 px-3 border">Narx</th>
                        <th scope="col" class="py-2 px-3 border">Tannarx</th>
                        <th scope="col" class="py-2 px-3 border">Boshlanish sanasi</th>
                        <th scope="col" class="py-2 px-3 border">Tugash sanasi</th>
                        <th scope="col" class="py-2 px-3 border">Izoh</th>
                        <th scope="col" class="py-2 px-3 border text-right">Amallar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($bookingDetails->sortBy('start_date') as $detail)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-2 px-4 border">
                                {{ $loop->index + 1 }}
                            </td>
                            <td class="py-2 px-4 border">
                                {{ $detail->objectItem->partnerObject->partner->type->name ?? 'Tur yo\'q' }}
                            </td>
                            <td class="py-2 px-4 border">
                                <div class="font-medium text-gray-900 dark:text-white">
                                    {{ $detail->objectItem->partnerObject->partner->name ?? 'Hamkor yo\'q' }}
                                </div>
                            </td>
                            <td class="py-2 px-4 border">
                                <div class="font-medium text-gray-900 dark:text-white">
                                    {{ $detail->objectItem->partnerObject->name ?? 'Hamkor yo\'q' }}
                                </div>
                            </td>
                            <td class="py-2 px-4 border">
                                {{ $detail->objectItem->name ?? 'Ob\'ekt yo\'q' }}
                            </td>
                            <td class="py-2 px-4 border">
                                {{ $detail->quantity }}
                            </td>
                            <td class="py-2 px-4 border">
                                {{ number_format($detail->price, 2) }}
                            </td>
                            <td class="py-2 px-4 border">
                                {{ number_format($detail->cost_price, 2) }}
                            </td>
                            <td class="py-2 px-4 border">
                                {{ $detail->start_date ? $detail->start_date->format('d.m.Y') : '-' }}
                            </td>
                            <td class="py-2 px-4 border">
                                {{ $detail->end_date ? $detail->end_date->format('d.m.Y') : '-' }}
                            </td>
                            <td class="py-2 px-4 border">
                                {{ $detail->comment ?? 'Izoh yo\'q' }}
                            </td>
                            <td class="py-2 px-4 border text-right">
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
                            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
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
                                        <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                            <!-- Partner Type -->
                                            <div class="sm:col-span-2">
                                                <label for="edit-partner-type-{{ $detail->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hamkor turi</label>
                                                <select name="type_id" required id="edit-partner-type-{{ $detail->id }}"
                                                        class="e-input partner-type-select" data-detail-id="{{ $detail->id }}">
                                                    <option value="">Hamkor turini tanlang</option>
                                                    @foreach($partnerTypes as $type)
                                                        <option value="{{ $type->id }}"
                                                                @if($detail->objectItem->partnerObject->partner->type_id == $type->id) selected @endif>
                                                            {{ $type->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Partner -->
                                            <div class="sm:col-span-2">
                                                <label for="edit-partner-{{ $detail->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hamkor</label>
                                                <select name="partner_id" required id="edit-partner-{{ $detail->id }}"
                                                        class="e-input partner-select" data-detail-id="{{ $detail->id }}">
                                                    <option value="">Hamkorni tanlang</option>
                                                    @foreach($partners->where('type_id', $detail->objectItem->partnerObject->partner->type_id) as $partner)
                                                        <option value="{{ $partner->id }}"
                                                                @if($detail->objectItem->partnerObject->partner_id == $partner->id) selected @endif>
                                                            {{ $partner->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Partner Object -->
                                            <div class="sm:col-span-2">
                                                <label for="edit-partner-object-{{ $detail->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hamkor ob'ekti</label>
                                                <select name="partner_object_id" id="edit-partner-object-{{ $detail->id }}"
                                                        class="e-input partner-object-select" data-detail-id="{{ $detail->id }}">
                                                    <option value="">Hamkor ob'ektini tanlang</option>
                                                    @foreach($partnerObjects->where('partner_id', $detail->objectItem->partnerObject->partner_id) as $pObject)
                                                        <option value="{{ $pObject->id }}"
                                                                @if($detail->objectItem->partner_object_id == $pObject->id) selected @endif>
                                                            {{ $pObject->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Object Item -->
                                            <div>
                                                <label for="edit-object-item-{{ $detail->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Xizmat/Obyekt</label>
                                                <select name="object_item_id" required id="edit-object-item-{{ $detail->id }}"
                                                        class="e-input object-item-select" data-detail-id="{{ $detail->id }}">
                                                    <option value="">Xizmat/Obyektni tanlang</option>
                                                    @foreach($objectItems->where('partner_object_id', $detail->objectItem->partner_object_id) as $item)
                                                        <option value="{{ $item->id }}"
                                                                @if($detail->object_item_id == $item->id) selected @endif
                                                                data-price="{{ $item->sale_price }}"
                                                                data-cost="{{ $item->price }}">
                                                            {{ $item->name }} ({{ number_format($item->sale_price, 2) }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <!-- Quantity -->
                                            <div>
                                                <label for="edit-quantity-{{ $detail->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Soni</label>
                                                <input type="number" name="quantity" id="edit-quantity-{{ $detail->id }}"
                                                       value="{{ $detail->quantity }}" class="e-input calculate-price"
                                                       required min="1" data-detail-id="{{ $detail->id }}">
                                            </div>

                                            <!-- Dates -->
                                            <div>
                                                <label for="edit-start-date-{{ $detail->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Boshlanish sanasi</label>
                                                <input type="date" name="start_date" id="edit-start-date-{{ $detail->id }}"
                                                       value="{{ $detail->start_date->format('Y-m-d') }}" class="e-input" required>
                                            </div>

                                            <div>
                                                <label for="edit-end-date-{{ $detail->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tugash sanasi</label>
                                                <input type="date" name="end_date" id="edit-end-date-{{ $detail->id }}"
                                                       value="{{ $detail->end_date->format('Y-m-d') }}" class="e-input" required>
                                            </div>

                                            <!-- Comment -->
                                            <div class="sm:col-span-2">
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
                            <td colspan="11" class="py-2 px-4 border text-center text-gray-500 dark:text-gray-400">
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
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
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
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <!-- Partner Type -->
                        <div class="sm:col-span-2">
                            <label for="create-partner-type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hamkor turi</label>
                            <select name="type_id" required id="create-partner-type" class="e-input">
                                <option value="">Hamkor turini tanlang</option>
                                @foreach($partnerTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Partner -->
                        <div class="sm:col-span-2">
                            <label for="create-partner" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hamkor</label>
                            <select name="partner_id" required id="create-partner" class="e-input" disabled>
                                <option value="" selected disabled>Avval hamkor turini tanlang</option>
                            </select>
                        </div>

                        <!-- Partner Object -->
                        <div class="sm:col-span-2">
                            <label for="create-partner-object" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hamkor ob'ekti</label>
                            <select name="partner_object_id" id="create-partner-object" class="e-input" disabled>
                                <option value="" selected disabled>Avval hamkorni tanlang</option>
                            </select>
                        </div>

                        <!-- Object Item -->
                        <div>
                            <label for="create-object-item" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Xizmat/Obyekt</label>
                            <select name="object_item_id" required id="create-object-item" class="e-input" disabled>
                                <option value="" selected disabled>Avval hamkor ob'ektini tanlang</option>
                            </select>
                        </div>

                        <!-- Quantity -->
                        <div>
                            <label for="create-quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Soni</label>
                            <input type="number" name="quantity" id="create-quantity" class="e-input calculate-price" required min="1" value="1" disabled>
                        </div>

                        <!-- Dates -->
                        <div>
                            <label for="create-start-date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Boshlanish sanasi</label>
                            <input type="date" name="start_date" id="create-start-date" class="e-input" required
                                   min="{{ $booking->start_date->format('Y-m-d') }}"
                                   max="{{ $booking->end_date->format('Y-m-d') }}">
                        </div>

                        <div>
                            <label for="create-end-date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tugash sanasi</label>
                            <input type="date" name="end_date" id="create-end-date" class="e-input" required
                                   min="{{ $booking->start_date->format('Y-m-d') }}"
                                   max="{{ $booking->end_date->format('Y-m-d') }}">
                        </div>

                        <!-- Comment -->
                        <div class="sm:col-span-2">
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
            // Store all data from PHP
            const allPartnerTypes = @json($partnerTypes);
            const allPartners = @json($partners);
            const allPartnerObjects = @json($partnerObjects);
            const allObjectItems = @json($objectItems);
            const bookingStartDate = "{{ $booking->start_date->format('Y-m-d') }}";
            const bookingEndDate = "{{ $booking->end_date->format('Y-m-d') }}";

            // ============= COMMON FUNCTIONS =============

            function enableSelect(selectId) {
                const select = document.getElementById(selectId);
                if (select) {
                    select.disabled = false;
                    select.required = true;
                }
            }

            function disableSelect(selectId) {
                const select = document.getElementById(selectId);
                if (select) {
                    select.disabled = true;
                    select.required = false;
                    select.innerHTML = `<option value=""  selected disabled>Avval kerakli maydonni tanlang</option>`;
                }
            }

            function updateDropdown(dropdownId, options, selectedValue = null) {
                const dropdown = document.getElementById(dropdownId);
                if (!dropdown) return;

                // Save current value if needed
                const currentValue = dropdown.value;

                // Clear and repopulate options
                dropdown.innerHTML = '';
                const defaultOption = document.createElement('option');
                defaultOption.value = '';
                defaultOption.textContent = dropdownId.includes('create') ? 'Avval kerakli maydonni tanlang' : 'Tanlang';
                dropdown.appendChild(defaultOption);

                options.forEach(option => {
                    const optElement = document.createElement('option');
                    optElement.value = option.id;
                    optElement.textContent = option.name;
                    if (option.sale_price) {
                        optElement.textContent += ` (${option.sale_price.toLocaleString()})`;
                        optElement.dataset.price = option.sale_price;
                        optElement.dataset.cost = option.price;
                    }
                    dropdown.appendChild(optElement);
                });

                // Restore selected value if provided
                if (selectedValue) {
                    dropdown.value = selectedValue;
                } else if (currentValue && options.some(opt => opt.id == currentValue)) {
                    dropdown.value = currentValue;
                }
            }

            function calculatePrice(objectItemSelect, quantityInput, priceInput, costInput) {
                const selectedOption = objectItemSelect?.options[objectItemSelect.selectedIndex];
                const quantity = parseInt(quantityInput?.value) || 1;

                if (selectedOption && selectedOption.value && priceInput && costInput) {
                    const price = parseFloat(selectedOption.dataset.price) * quantity;
                    const cost = parseFloat(selectedOption.dataset.cost) * quantity;

                    priceInput.value = price.toFixed(2);
                    costInput.value = cost.toFixed(2);
                }
            }

            // ============= CREATE MODAL HANDLERS =============

            // Partner Type change handler
            const createPartnerType = document.getElementById('create-partner-type');
            if (createPartnerType) {
                createPartnerType.addEventListener('change', function() {
                    const typeId = this.value;
                    const partners = allPartners.filter(p => p.type_id == typeId);

                    updateDropdown('create-partner', partners);
                    enableSelect('create-partner');

                    // Disable and reset dependent fields
                    disableSelect('create-partner-object');
                    disableSelect('create-object-item');
                    document.getElementById('create-quantity').disabled = true;
                    document.getElementById('create-price').value = '';
                    document.getElementById('create-cost-price').value = '';
                });
            }

            // Partner change handler
            const createPartner = document.getElementById('create-partner');
            if (createPartner) {
                createPartner.addEventListener('change', function() {
                    const partnerId = this.value;
                    const partnerObjects = allPartnerObjects.filter(po => po.partner_id == partnerId);

                    updateDropdown('create-partner-object', partnerObjects);
                    enableSelect('create-partner-object');

                    // Disable and reset dependent fields
                    disableSelect('create-object-item');
                    document.getElementById('create-quantity').disabled = true;
                    document.getElementById('create-price').value = '';
                    document.getElementById('create-cost-price').value = '';
                });
            }

            // Partner Object change handler
            const createPartnerObject = document.getElementById('create-partner-object');
            if (createPartnerObject) {
                createPartnerObject.addEventListener('change', function() {
                    const partnerObjectId = this.value;
                    const items = allObjectItems.filter(oi => oi.partner_object_id == partnerObjectId);

                    updateDropdown('create-object-item', items);
                    enableSelect('create-object-item');

                    // Enable quantity field
                    document.getElementById('create-quantity').disabled = false;
                });
            }

            // Object Item and Quantity change handler
            const createObjectItem = document.getElementById('create-object-item');
            const createQuantity = document.getElementById('create-quantity');
            const createPrice = document.getElementById('create-price');
            const createCostPrice = document.getElementById('create-cost-price');

            if (createObjectItem && createQuantity) {
                createObjectItem.addEventListener('change', function() {
                    calculatePrice(this, createQuantity, createPrice, createCostPrice);
                });

                createQuantity.addEventListener('input', function() {
                    calculatePrice(createObjectItem, this, createPrice, createCostPrice);
                });
            }

            // ============= EDIT MODAL HANDLERS =============

            // Initialize all edit modals with proper chained selects
            document.querySelectorAll('[data-modal-toggle^="editDetailModal-"]').forEach(button => {
                button.addEventListener('click', function() {
                    const modalId = this.getAttribute('data-modal-target');
                    const modal = document.querySelector(modalId);
                    if (!modal) return;

                    const detailId = modalId.split('-').pop();
                    const partnerTypeSelect = modal.querySelector('.partner-type-select');
                    const partnerSelect = modal.querySelector('.partner-select');
                    const partnerObjectSelect = modal.querySelector('.partner-object-select');
                    const objectItemSelect = modal.querySelector('.object-item-select');
                    const quantityInput = modal.querySelector('.calculate-price');
                    const priceInput = modal.getElementById(`edit-price-${detailId}`);
                    const costPriceInput = modal.getElementById(`edit-cost-price-${detailId}`);

                    // Setup change handlers for this modal
                    if (partnerTypeSelect) {
                        partnerTypeSelect.addEventListener('change', function() {
                            const typeId = this.value;
                            const partners = allPartners.filter(p => p.type_id == typeId);
                            updateDropdown(`edit-partner-${detailId}`, partners);
                        });
                    }

                    if (partnerSelect) {
                        partnerSelect.addEventListener('change', function() {
                            const partnerId = this.value;
                            const partnerObjects = allPartnerObjects.filter(po => po.partner_id == partnerId);
                            updateDropdown(`edit-partner-object-${detailId}`, partnerObjects);
                        });
                    }

                    if (partnerObjectSelect) {
                        partnerObjectSelect.addEventListener('change', function() {
                            const partnerObjectId = this.value;
                            const items = allObjectItems.filter(oi => oi.partner_object_id == partnerObjectId);
                            updateDropdown(`edit-object-item-${detailId}`, items);
                        });
                    }

                    if (objectItemSelect && quantityInput && priceInput && costPriceInput) {
                        objectItemSelect.addEventListener('change', function() {
                            calculatePrice(this, quantityInput, priceInput, costPriceInput);
                        });

                        quantityInput.addEventListener('input', function() {
                            calculatePrice(objectItemSelect, this, priceInput, costPriceInput);
                        });
                    }
                });
            });

            // Set default dates for create modal
            if (document.getElementById('create-start-date')) {
                document.getElementById('create-start-date').value = bookingStartDate;
            }
            if (document.getElementById('create-end-date')) {
                document.getElementById('create-end-date').value = bookingEndDate;
            }
        });
    </script>
@endpush
