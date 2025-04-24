@extends('layouts.dashboard')
@section('title', "Narxlar ro'yxati")
@section('description', "Turlar uchun Narxlar ro'yxati")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <!-- Card header -->
            <div class="items-center justify-between lg:flex">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Narxlar ro'yxati</h3>
                </div>
                <div class="items-center sm:flex">
                    <button data-modal-target="createPriceListModal" data-modal-toggle="createPriceListModal" class="admin-add-btn" type="button">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Qo'shish
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="mt-6 overflow-x-auto">
                <table class="w-full whitespace-nowrap border-2">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Soni</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Narxi</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Amallar</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                    @foreach($priceLists as $priceList)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                {{ $priceList->tour->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $priceList->quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ number_format($priceList->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button data-modal-target="editPriceListModal{{ $priceList->id }}" data-modal-toggle="editPriceListModal{{ $priceList->id }}" class="admin-edit-btn">
                                    Tahrirlash
                                </button>
                                <form action="{{ route('price-lists.destroy', $priceList->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-delete-btn" onclick="return confirm('O'chirganingizdan keyin uni qayta tiklab bo'lmaydi this item?')">
                                        O'chirish
                                    </button>
                                </form>
                            </td>
                        </tr>

                        <!-- Edit Price List Modal -->
                        <div id="editPriceListModal{{ $priceList->id }}" tabindex="-1" class="hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5">
                                    <div class="flex justify-between items-center pb-4 mb-4 border-b dark:border-gray-600">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Price List</h3>
                                        <button type="button" data-modal-hide="editPriceListModal{{ $priceList->id }}" class="admin-close-modal-btn">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <form action="{{ route('price-lists.update', $priceList->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-4">
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tour</label>
                                            <select name="tour_id" class="e-input" required>
                                                @foreach($tours as $tour)
                                                    <option value="{{ $tour->id }}" {{ $priceList->tour_id == $tour->id ? 'selected' : '' }}>{{ $tour->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Odam soni</label>
                                            <input type="number" name="quantity" class="e-input" placeholder="Odam soni" value="{{ $priceList->quantity }}" required>
                                        </div>
                                        <div class="mb-4">
                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Narxi</label>
                                            <input type="number" step="0.01" name="price" class="e-input" placeholder="Price" value="{{ $priceList->price }}" required>
                                        </div>
                                        <div class="flex justify-end space-x-2">
                                            <button type="submit" class="admin-add-btn">Yangilash</button>
                                            <button type="button" data-modal-hide="editPriceListModal{{ $priceList->id }}" class="admin-cancel-btn">Bekor qilish</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between pt-3 sm:pt-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if($priceLists->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">Previous</span>
                    @else
                        <a href="{{ $priceLists->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Previous</a>
                    @endif

                    @if($priceLists->hasMorePages())
                        <a href="{{ $priceLists->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Next</a>
                    @else
                        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">Next</span>
                    @endif
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Showing
                            <span class="font-medium">{{ $priceLists->firstItem() ?? 0 }}</span>
                            to
                            <span class="font-medium">{{ $priceLists->lastItem() ?? 0 }}</span>
                            of
                            <span class="font-medium">{{ $priceLists->total() }}</span>
                            results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                            {{ $priceLists->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Price List Modal -->
    <div id="createPriceListModal" tabindex="-1" class="hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5">
                <div class="flex justify-between items-center pb-4 mb-4 border-b dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Price List</h3>
                    <button type="button" data-modal-hide="createPriceListModal" class="admin-close-modal-btn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('price-lists.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Tour</label>
                        <select name="tour_id" class="e-input" required>
                            <option selected disabled>-- Tours --</option>
                            @foreach($tours as $tour)
                                <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Odam soni</label>
                        <input type="number" name="quantity" class="e-input" placeholder="Odam soni" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Narxi</label>
                        <input type="number" step="0.01" name="price" class="e-input" placeholder="Price" required>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="submit" class="admin-add-btn">Add Price List</button>
                        <button type="button" data-modal-hide="createPriceListModal" class="admin-cancel-btn">Bekor qilish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
