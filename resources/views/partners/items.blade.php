@extends('layouts.dashboard')
@section('title', "Object Items")
@section('description', "Manage Object Items")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <!-- Card header -->
            <div class="items-center justify-between lg:flex">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Object Items</h3>
                </div>
                <div class="items-center sm:flex space-x-3">

                    <button data-modal-target="createItemModal" data-modal-toggle="createItemModal" class="admin-add-btn" type="button">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Add new item
                    </button>
                </div>

            </div>

            <div class="mt-3">
                <!-- Filters -->
                <form id="filter-form" action="" method="GET" class="flex space-x-2 mb-4 lg:mb-0">
                    <div>
                        <select name="partner_type_id" onchange="document.getElementById('filter-form').submit();" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="">All Partner Types</option>
                            @foreach($partnerTypes as $type)
                                <option value="{{ $type->id }}" {{ request('partner_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="partner_id" onchange="document.getElementById('filter-form').submit();" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="">All Partners</option>
                            @foreach($partners as $partner)
                                <option value="{{ $partner->id }}" {{ request('partner_id') == $partner->id ? 'selected' : '' }}>
                                    {{ $partner->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select name="partner_object_id" onchange="document.getElementById('filter-form').submit();" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="">All Objects</option>
                            @foreach($partnerObjects as $obj)
                                <option value="{{ $obj->id }}" {{ request('partner_object_id') == $obj->id ? 'selected' : '' }}>
                                    {{ $obj->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if(request()->has('partner_type_id') || request()->has('partner_id') || request()->has('partner_object_id'))
                        <a href="{{ route('object-items.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700">Reset</a>
                    @endif
                </form>
            </div>


            <!-- Table -->
            <div class="flex flex-col mt-6">
                <div class="overflow-x-auto rounded-lg">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden shadow sm:rounded-lg">
                            <table id="itemsTable" class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        ID
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Name
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Price
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Sale Price
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Currency
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Partner Type
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Partner
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Partner Object
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Contact
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800">
                                @foreach($items as $item)
                                    <tr>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $item->name }}
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ number_format($item->price, 2) }}
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ number_format($item->sale_price, 2) }}
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-indigo-200 dark:text-indigo-900">
                                                {{ $item->currency->code ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <span class="bg-purple-100 text-purple-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-purple-200 dark:text-purple-900">
                                                {{ $item->partnerObject->partner->type->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                                {{ $item->partnerObject->partner->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-900">
                                                {{ $item->partnerObject->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-xs font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $item->contact }}
                                        </td>
                                        <td class="p-4 space-x-2 whitespace-nowrap">
                                            <button type="button" data-modal-target="editItemModal-{{ $item->id }}" data-modal-toggle="editItemModal-{{ $item->id }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                                </svg>
                                                Edit
                                            </button>
                                            <button type="button" data-modal-target="deleteItemModal-{{ $item->id }}" data-modal-toggle="deleteItemModal-{{ $item->id }}" class="admin-delete-btn">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Delete
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Edit Object Item Modal -->
                                    <div id="editItemModal-{{ $item->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                            <!-- Modal content -->
                                            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                                <!-- Modal header -->
                                                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                        Edit Item
                                                    </h3>
                                                    <button type="button" class="admin-close-modal-btn" data-modal-hide="editItemModal-{{ $item->id }}">
                                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <form action="{{ route('object-items.update', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="grid gap-4 mb-4 sm:grid-cols-2">

                                                        <div>
                                                            <label for="partner_type_id-{{ $item->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Partner Type</label>
                                                            <select id="partner_type_id-{{ $item->id }}" name="partner_type_id" class="partner-type-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                                                <option value="" selected disabled>Select partner type</option>
                                                                @foreach($partnerTypes as $type)
                                                                    <option value="{{ $type->id }}" {{ $item->partnerObject->partner->type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div>
                                                            <label for="partner_id-{{ $item->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Partner</label>
                                                            <select id="partner_id-{{ $item->id }}" name="partner_id" class="partner-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                                                @foreach($partners->where('type_id', $item->partnerObject->partner->type_id) as $partner)
                                                                    <option value="{{ $partner->id }}" {{ $item->partnerObject->partner_id == $partner->id ? 'selected' : '' }}>{{ $partner->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-span-2">
                                                            <label for="partner_object_id-{{ $item->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Partner Object</label>
                                                            <select id="partner_object_id-{{ $item->id }}" name="partner_object_id" class="partner-object-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                                                @foreach($partnerObjects->where('partner_id', $item->partnerObject->partner_id) as $object)
                                                                    <option value="{{ $object->id }}" {{ $item->partner_object_id == $object->id ? 'selected' : '' }}>{{ $object->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div>
                                                            <label for="name-{{ $item->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                                            <input type="text" name="name" id="name-{{ $item->id }}" value="{{ $item->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Item name" required>
                                                        </div>
                                                        <div>
                                                            <label for="price-{{ $item->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                                                            <input type="number" step="0.01" name="price" id="price-{{ $item->id }}" value="{{ $item->price }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Price" required>
                                                        </div>
                                                        <div>
                                                            <label for="sale_price-{{ $item->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sale Price</label>
                                                            <input type="number" step="0.01" name="sale_price" id="sale_price-{{ $item->id }}" value="{{ $item->sale_price }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Sale price" required>
                                                        </div>
                                                        <div>
                                                            <label for="currency_id-{{ $item->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Currency</label>
                                                            <select id="currency_id-{{ $item->id }}" name="currency_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                                                @foreach($currencies as $currency)
                                                                    <option value="{{ $currency->id }}" {{ $item->currency_id == $currency->id ? 'selected' : '' }}>{{ $currency->code }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-span-2">
                                                            <label for="contact-{{ $item->id }}" class="e-label">Name</label>
                                                            <textarea name="contact" id="contact-{{ $item->id }}" class="e-input" placeholder="contact (optional)">{{ $item->contact }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-4">
                                                        <button type="submit" class="admin-add-btn">
                                                            Update item
                                                        </button>
                                                        <button type="button" data-modal-hide="editItemModal-{{ $item->id }}" class="admin-cancel-btn">
                                                            Cancel
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delete Object Modal -->
                                    <div id="deleteItemModal-{{ $item->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                            <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                                <button type="button" class="admin-close-modal-btn" data-modal-toggle="deleteItemModal-{{ $item->id }}">
                                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to delete this item?</p>
                                                <div class="flex justify-center items-center space-x-4">
                                                    <form action="{{ route('object-items.destroy', $item->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="py-2 px-3 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                            Yes, delete
                                                        </button>
                                                    </form>
                                                    <button data-modal-toggle="deleteItemModal-{{ $item->id }}" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                                        No, cancel
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
            </div>
        </div>
    </div>

    <!-- Create Object Item Modal -->
    <div id="createItemModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Add New Item
                    </h3>
                    <button type="button" class="admin-close-modal-btn" data-modal-hide="createItemModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('object-items.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">

                        <div>
                            <label for="create-partner_type_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Partner Type</label>
                            <select id="create-partner_type_id" name="partner_type_id" class="partner-type-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                <option value="" selected disabled>Select partner type</option>
                                @foreach($partnerTypes as $type)
                                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="create-partner_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Partner</label>
                            <select id="create-partner_id" name="partner_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                <option value=""  selected disabled>Select partner type first</option>
                            </select>
                        </div>
                        <div class="col-span-2 mb-3 ">
                            <label for="create-partner_object_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Partner Object</label>
                            <select id="create-partner_object_id" name="partner_object_id" class="partner-object-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                <option value="" selected disabled>Select partner first</option>
                            </select>

                        </div>


                        <div>
                            <label for="create-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="text" name="name" id="create-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Item name" required>
                        </div>
                        <div>
                            <label for="create-price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                            <input type="number" step="0.01" name="price" id="create-price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Price" required>
                        </div>
                        <div>
                            <label for="create-sale_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sale Price</label>
                            <input type="number" step="0.01" name="sale_price" id="create-sale_price" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Sale price" required>
                        </div>
                        <div>
                            <label for="create-currency_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Currency</label>
                            <select id="create-currency_id" name="currency_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->code }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-span-2">
                            <label for="contact}" class="e-label">Name</label>
                            <textarea name="contact" id="contact" class="e-input" placeholder="contact (optional)"></textarea>
                        </div>

                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="admin-add-btn">
                            Add new item
                        </button>
                        <button type="button" data-modal-hide="createItemModal" class="admin-cancel-btn">
                            Cancel
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
@endpush

@push('scripts')
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>
    <script>
        // Store all data from PHP
        const allPartnerTypes = @json($partnerTypes);
        const allPartners = @json($partners);
        const allPartnerObjects = @json($partnerObjects);

        $(document).ready(function() {
            // Initialize DataTable with Tailwind styling
            $('#itemsTable').DataTable({
                responsive: true,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columnDefs: [
                    { orderable: false, targets: [8] } // Disable sorting for actions column
                ]
            });

            // Common function to update partner dropdown based on partner type
            function updatePartnerDropdown(typeSelect, partnerSelect) {
                const partnerTypeId = typeSelect.val();

                // Clear current options
                partnerSelect.empty().append('<option value="" selected disabled>Select partner</option>');

                if (partnerTypeId) {
                    // Filter partners by type
                    allPartners.filter(partner => partner.type_id == partnerTypeId)
                        .forEach(partner => {
                            partnerSelect.append(`<option value="${partner.id}">${partner.name}</option>`);
                        });
                }
            }

            // Common function to update object dropdown based on partner
            function updateObjectDropdown(partnerSelect, objectSelect) {
                const partnerId = partnerSelect.val();

                // Clear current options
                // objectSelect.empty().append('<option value="" selected disabled>Select object</option>');

                if (partnerId) {
                    // Filter objects by partner
                    allPartnerObjects.filter(obj => obj.partner_id == partnerId)
                        .forEach(obj => {
                            objectSelect.append(`<option value="${obj.id}">${obj.name} </option>`);
                        });
                }
            }

            // ============= CREATE MODAL HANDLERS =============

            // Partner type change handler for create modal
            $('#create-partner_type_id').change(function() {
                updatePartnerDropdown($(this), $('#create-partner_id'));
                $('#create-partner_object_id').empty().append('<option value="" selected disabled>Select partner first</option>');
            });

            // Partner change handler for create modal
            $('#create-partner_id').change(function() {
                updateObjectDropdown($(this), $('#create-partner_object_id'));
            });

            // ============= EDIT MODAL HANDLERS =============

            // Partner type change handler for edit modals
            $(document).on('change', '.partner-type-select', function() {
                const partnerSelect = $(this).closest('.grid').find('.partner-select');
                updatePartnerDropdown($(this), partnerSelect);
                $(this).closest('.grid').find('.partner-object-select').empty()
                    .append('<option value="" selected disabled>Select partner first</option>');
            });

            // Partner change handler for edit modals
            $(document).on('change', '.partner-select', function() {
                updateObjectDropdown($(this), $(this).closest('.grid').find('.partner-object-select'));
            });

            // Initialize selects when edit modals are opened
            $('[data-modal-toggle^="editItemModal-"]').click(function() {
                const modalId = $(this).data('modal-target');
                const modal = $(`#${modalId}`);
                const partnerTypeSelect = modal.find('.partner-type-select');
                const partnerSelect = modal.find('.partner-select');
                const objectSelect = modal.find('.partner-object-select');

                // Store current values to restore them after populating dropdowns
                const partnerTypeId = partnerTypeSelect.val();
                const partnerId = partnerSelect.val();
                const objectId = objectSelect.val();

                // First populate partners based on partner type
                updatePartnerDropdown(partnerTypeSelect, partnerSelect);

                // Then populate objects based on partner
                updateObjectDropdown(partnerSelect, objectSelect);

                // Restore selected values
                partnerTypeSelect.val(partnerTypeId);
                partnerSelect.val(partnerId);
                objectSelect.val(objectId);
            });

            // Dark mode toggle support
            document.addEventListener('dark-mode', function(e) {
                $('.dataTables_wrapper').toggleClass('dark', e.detail.dark);
            });

            // Initialize dark mode if needed
            if (document.documentElement.classList.contains('dark')) {
                $('.dataTables_wrapper').addClass('dark');
            }
        });
    </script>
@endpush
