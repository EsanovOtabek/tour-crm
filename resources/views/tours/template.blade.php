@extends('layouts.dashboard')
@section('title', "Tour Template - {$tour->name}")
@section('description', "Manage template for {$tour->name}")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 rounded-lg shadow-sm sm:p-6 bg-white dark:bg-gray-800">
            <div class="items-center justify-between lg:flex">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">
                        Templates for {{ $tour->name }}
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400">
                        Day quantity:<b> {{ $tour->day_quantity }} days</b>
                    </p>
                    <p class="text-gray-500 dark:text-gray-400">
                        Unique CODE:<b> {{ $tour->{'unique-code'} }} </b>
                    </p>
                    <p class="text-gray-500 dark:text-gray-400">
                        Tour Category:<b> {{ $tour->category->name }} </b>
                    </p>
                </div>
                <div class="items-center sm:flex">
                    <button data-modal-target="createRouteModal" data-modal-toggle="createRouteModal" class="admin-add-btn" type="button">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Mashrut qo'shish
                    </button>
                    <button data-modal-target="createDetailModal" data-modal-toggle="createDetailModal" class="admin-add-btn ml-3" type="button">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Detal qo'shish
                    </button>
                </div>
            </div>

            <!-- Details Section -->
            <div class="mt-8">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Details</h4>
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-primary-200 dark:bg-primary-900 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-2 px-3 border">#</th>
                            <th scope="col" class="py-2 px-3 border">Hamkor turi</th>
                            <th scope="col" class="py-2 px-3 border">Hamkor</th>
                            <th scope="col" class="py-2 px-3 border">Obyekt</th>
                            <th scope="col" class="py-2 px-3 border">Obyekt mahsuloti</th>
                            <th scope="col" class="py-2 px-3 border">Boshlanish kuni</th>
                            <th scope="col" class="py-2 px-3 border">Tugash kuni</th>
                            <th scope="col" class="py-2 px-3 border text-end">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($template->details as $detail)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="py-2 px-4 border">{{ $loop->index + 1 }}</td>
                                <td class="py-2 px-4 border">
                                    {{ $detail->objectItem->partnerObject->partner->type->name ?? 'Tur yo\'q' }}
                                </td>
                                <td class="py-2 px-4 border">
                                    {{ $detail->objectItem->partnerObject->partner->name ?? 'Hamkor yo\'q' }}
                                </td>
                                <td class="py-2 px-4 border">
                                    {{ $detail->objectItem->partnerObject->name ?? 'Hamkor yo\'q' }}
                                </td>
                                <td class="py-2 px-4 border">
                                    {{ $detail->objectItem->name ?? 'Ob\'ekt yo\'q' }}
                                </td>
                                <td class="py-2 px-4 border">
                                    {{ $detail->start_day }}
                                </td>
                                <td class="py-2 px-4 border">
                                    {{ $detail->end_day }}
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
                                        <form action="{{ route('tours.templates.updateDetail', [$template->id, $detail->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                                <!-- Partner Type -->
                                                <div class="sm:col-span-2">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hamkor turi</label>
                                                    <select name="type_id" required class="partner-type-select e-input">
                                                        <option value="">Hamkor turini tanlang</option>
                                                        @foreach($partnerTypes as $type)
                                                            <option value="{{ $type->id }}" {{ $detail->objectItem->partnerObject->partner->type_id == $type->id ? 'selected' : '' }}>
                                                                {{ $type->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Partner -->
                                                <div class="sm:col-span-2">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hamkor</label>
                                                    <select name="partner_id" required class="partner-select e-input">
                                                        <option value="">Hamkorni tanlang</option>
                                                        @foreach($partners->where('type_id', $detail->objectItem->partnerObject->partner->type_id) as $partner)
                                                            <option value="{{ $partner->id }}" {{ $detail->objectItem->partnerObject->partner_id == $partner->id ? 'selected' : '' }}>
                                                                {{ $partner->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Partner Object -->
                                                <div class="sm:col-span-2">
                                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Hamkor ob'ekti</label>
                                                    <select name="partner_object_id" class="partner-object-select e-input">
                                                        <option value="">Hamkor ob'ektini tanlang</option>
                                                        @foreach($partnerObjects->where('partner_id', $detail->objectItem->partnerObject->partner_id) as $object)
                                                            <option value="{{ $object->id }}" {{ $detail->objectItem->partner_object_id == $object->id ? 'selected' : '' }}>
                                                                {{ $object->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Object Item -->
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Xizmat/Obyekt</label>
                                                    <select name="object_item_id" required class="object-item-select e-input">
                                                        <option value="">Xizmatni tanlang</option>
                                                        @foreach($objectItems->where('partner_object_id', $detail->objectItem->partner_object_id) as $item)
                                                            <option value="{{ $item->id }}" {{ $detail->object_item_id == $item->id ? 'selected' : '' }}>
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Quantity -->
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Soni</label>
                                                    <input type="number" name="quantity" class="e-input calculate-price" required min="1" value="{{ $detail->quantity }}">
                                                </div>

                                                <!-- Start Day -->
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Boshlanish kuni</label>
                                                    <input type="number" name="start_day" class="e-input" required min="1" max="{{ $tour->day_quantity }}" value="{{ $detail->start_day }}">
                                                </div>

                                                <!-- End Day -->
                                                <div>
                                                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tugash kuni</label>
                                                    <input type="number" name="end_day" class="e-input" required min="1" max="{{ $tour->day_quantity }}" value="{{ $detail->end_day }}">
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
                                            <form action="{{ route('tours.templates.removeDetail', [$template->id, $detail->id]) }}" method="POST" class="inline">
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
                                <td colspan="8" class="py-2 px-4 border text-center text-gray-500 dark:text-gray-400">
                                    Detallar topilmadi
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Routes Section -->
            <div class="mt-8">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Mashrutlar</h4>
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-primary-200 dark:bg-primary-900 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-2 px-3 border">#</th>
                            <th scope="col" class="py-2 px-3 border">Shahar</th>
                            <th scope="col" class="py-2 px-3 border">Kun raqami</th>
                            <th scope="col" class="py-2 px-3 border">Dastur</th>
                            <th scope="col" class="py-2 px-3 border">Tartib raqami</th>
                            <th scope="col" class="py-2 px-3 border text-end">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($template->mashruts as $mashrut)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="py-2 px-4 border">{{ $loop->index + 1 }}</td>
                                <td class="py-2 px-4 border">{{ $mashrut->tourCity->name ?? 'N/A' }}</td>
                                <td class="py-2 px-4 border">{{ $mashrut->day_number }}</td>
                                <td class="py-2 px-4 border">{{ $mashrut->program ?? '-' }}</td>
                                <td class="py-2 px-4 border">{{ $mashrut->order_no }}</td>
                                <td class="py-2 px-4 border text-right">
                                    <button data-modal-target="editRouteModal-{{ $mashrut->id }}" data-modal-toggle="editRouteModal-{{ $mashrut->id }}" class="admin-edit-btn">
                                        Tahrirlash
                                    </button>
                                    <button data-modal-target="deleteRouteModal-{{ $mashrut->id }}" data-modal-toggle="deleteRouteModal-{{ $mashrut->id }}" class="admin-delete-btn">
                                        O'chirish
                                    </button>
                                </td>
                            </tr>

                            <!-- Edit Route Modal -->
                            <div id="editRouteModal-{{ $mashrut->id }}" tabindex="-1" class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full h-modal md:h-full">
                                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5">
                                        <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-600">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                Mashrutni tahrirlash
                                            </h3>
                                            <button type="button" class="admin-close-modal-btn" data-modal-hide="editRouteModal-{{ $mashrut->id }}">
                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('tours.templates.updateMashrut', [$template->id, $mashrut->id]) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-900 dark:text-white">Shahar</label>
                                                <select name="tour_city_id" class="e-input" required>
                                                    @foreach($tourCities as $city)
                                                        <option value="{{ $city->id }}" {{ $mashrut->tour_city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-900 dark:text-white">Kun raqami</label>
                                                <input type="number" name="day_number" min="1" max="{{ $tour->day_quantity }}" value="{{ $mashrut->day_number }}" class="e-input" required>
                                            </div>
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-900 dark:text-white">Dastur</label>
                                                <textarea name="program" class="e-input">{{ $mashrut->program }}</textarea>
                                            </div>
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-900 dark:text-white">Tartib raqami</label>
                                                <input type="number" name="order_no" value="{{ $mashrut->order_no }}" class="e-input">
                                            </div>
                                            <div class="flex justify-end space-x-2">
                                                <button type="submit" class="admin-add-btn">Saqlash</button>
                                                <button type="button" data-modal-hide="editRouteModal-{{ $mashrut->id }}" class="admin-cancel-btn">Bekor qilish</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Route Modal -->
                            <div id="deleteRouteModal-{{ $mashrut->id }}" tabindex="-1" class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full h-modal md:h-full">
                                <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5 text-center">
                                        <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white" data-modal-hide="deleteRouteModal-{{ $mashrut->id }}">
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
                                            <form action="{{ route('tours.templates.removeMashrut', [$template->id, $mashrut->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-delete-btn">
                                                    Ha, o'chirish
                                                </button>
                                            </form>
                                            <button type="button" data-modal-hide="deleteRouteModal-{{ $mashrut->id }}" class="admin-cancel-btn">
                                                Yo'q, bekor qilish
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="6" class="py-2 px-4 border text-center text-gray-500 dark:text-gray-400">
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
                <form action="{{ route('tours.templates.addDetail', $tour->id) }}" method="POST">
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

                        <!-- Start Day -->
                        <div>
                            <label for="create-start-day" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Boshlanish kuni</label>
                            <input type="number" name="start_day" id="create-start-day" class="e-input" required min="1" max="{{ $tour->day_quantity }}" value="1" disabled>
                        </div>

                        <!-- End Day -->
                        <div>
                            <label for="create-end-day" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tugash kuni</label>
                            <input type="number" name="end_day" id="create-end-day" class="e-input" required min="1" max="{{ $tour->day_quantity }}" value="1" disabled>
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

    <!-- Create Route Modal -->
    <div id="createRouteModal" tabindex="-1" class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5">
                <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Yangi mashrut qo'shish
                    </h3>
                    <button type="button" class="admin-close-modal-btn" data-modal-hide="createRouteModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="{{ route('tours.templates.addMashrut', $tour->id) }}" method="POST">
                    @csrf
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
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Kun raqami</label>
                        <input type="number" name="day_number" min="1" max="{{ $tour->day_quantity }}" class="e-input" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Dastur</label>
                        <textarea name="program" class="e-input"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Tartib raqami</label>
                        <input type="number" name="order_no" class="e-input" >
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="submit" class="admin-add-btn">Qo'shish</button>
                        <button type="button" data-modal-hide="createRouteModal" class="admin-cancel-btn">Bekor qilish</button>
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
                    select.innerHTML = `<option value="" selected disabled>Avval kerakli maydonni tanlang</option>`;
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

            // ============= CREATE DETAIL MODAL HANDLERS =============

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
                    document.getElementById('create-start-day').disabled = true;
                    document.getElementById('create-end-day').disabled = true;
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
                    document.getElementById('create-start-day').disabled = true;
                    document.getElementById('create-end-day').disabled = true;
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

                    // Enable quantity and day fields
                    document.getElementById('create-quantity').disabled = false;
                    document.getElementById('create-start-day').disabled = false;
                    document.getElementById('create-end-day').disabled = false;
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
                });
            });
        });
    </script>
@endpush
