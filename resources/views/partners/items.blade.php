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
                    <!-- Partner selection dropdown -->
                    <form action="" method="GET" class="mb-4 lg:mb-0">
                        <select name="partner_object_id" id="partner-object-filter" class="select2 w-96 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" onchange="this.form.submit()">
                            <option value="">All Objects</option>
                            @foreach($partnerObjects as $obj)
                                <option value="{{ $obj->id }}" {{ $selectedPartnerObjectId == $obj->id ? 'selected' : '' }}>
                                    {{ $obj->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <button data-modal-target="createItemModal" data-modal-toggle="createItemModal" class="admin-add-btn" type="button">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Add new object
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="flex flex-col mt-6">
                <div class="overflow-x-auto rounded-lg">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden shadow sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600 border">
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
                                        Partner
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Partner Object
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Amallar
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
                                            {{ $item->price }}
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $item->sale_price }}
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                                {{ $item->partnerObject->partner->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                                {{ $item->partnerObject->name ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="p-4 space-x-2 whitespace-nowrap">
                                            <button type="button" data-modal-target="editItemModal-{{ $item->id }}" data-modal-toggle="editItemModal-{{ $item->id }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                                </svg>
                                                Tahrirlash
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
                                    <div id="editItemModal-{{ $item->id }}" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
                                        <div class="bg-white dark:bg-gray-900 p-6 rounded-lg w-full max-w-xl">
                                            <form action="{{ route('object-items.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Edit Item</h2>

                                                <div class="mb-4">
                                                    <label class="e-label">Nomi</label>
                                                    <input type="text" name="name" value="{{ $item->name }}" required class="e-input">
                                                </div>

                                                <div class="mb-4">
                                                    <label class="e-label">Narxi</label>
                                                    <input type="number" name="price" step="0.01" value="{{ $item->price }}" required class="e-input">
                                                </div>

                                                <div class="mb-4">
                                                    <label class="e-label">Sale Price</label>
                                                    <input type="number" name="sale_price" step="0.01" value="{{ $item->sale_price }}" required class="e-input">
                                                </div>

                                                <div class="mb-4">
                                                    <label class="e-label">Partner Object</label>
                                                    <select name="partner_object_id" required class="e-input">
                                                        @foreach(App\Models\PartnerObject::all() as $object)
                                                            <option value="{{ $object->id }}" {{ $item->partner_object_id == $object->id ? 'selected' : '' }}>
                                                                {{ $object->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="flex justify-end space-x-2">
                                                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Yangilash</button>
                                                    <button type="button" data-modal-hide="editItemModal-{{ $item->id }}" class="text-gray-700 dark:text-white border px-4 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">Bekor qilish</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Delete Object Modal -->
                                    <div id="deleteItemModal-{{ $object->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                            <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                                <button type="button" class="admin-close-modal-btn" data-modal-toggle="deleteItemModal-{{ $object->id }}">
                                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                                <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                                <p class="mb-4 text-gray-500 dark:text-gray-300">O'chirganingizdan keyin uni qayta tiklab bo'lmaydi this object?</p>
                                                <div class="flex justify-center items-center space-x-4">
                                                    <form action="{{ route('object-items.destroy', $object->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="py-2 px-3 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                            Ha , o'chirish
                                                        </button>
                                                    </form>
                                                    <button data-modal-toggle="deleteItemModal-{{ $object->id }}" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
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

            <!-- Pagination -->
            <div class="flex items-center justify-between pt-3 sm:pt-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if($items->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">Previous</span>
                    @else
                        <a href="{{ $items->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Previous</a>
                    @endif

                    @if($items->hasMorePages())
                        <a href="{{ $items->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Next</a>
                    @else
                        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">Next</span>
                    @endif
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Showing
                            <span class="font-medium">{{ $items->firstItem() ?? 0 }}</span>
                            to
                            <span class="font-medium">{{ $items->lastItem() ?? 0 }}</span>
                            of
                            <span class="font-medium">{{ $items->total() }}</span>
                            results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                            {{ $items->appends(['partner_id' => $selectedPartnerObjectId])->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Object Item Modal -->
    <div id="createItemModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Add Object Item
                    </h3>
                    <button type="button" class="admin-close-modal-btn" data-modal-hide="createItemModal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="{{ route('object-items.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div>
                            <label for="create-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomi</label>
                            <input type="text" name="name" id="create-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Item name" required>
                        </div>
                        <div>
                            <label for="create-price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Narxi</label>
                            <input type="number" name="price" id="create-price" step="0.01" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Price" required>
                        </div>
                        <div>
                            <label for="create-sale_price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Sale Price</label>
                            <input type="number" name="sale_price" id="create-sale_price" step="0.01" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Sale price" required>
                        </div>
                        <div>
                            <label for="create-partner_object_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Partner Object</label>
                            <select id="create-partner_object_id" name="partner_object_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                                <option value="">Select partner object</option>
                                @foreach($partnerObjects as $object)
                                    <option value="{{ $object->id }}"  {{ $selectedPartnerObjectId == $object->id ? 'selected' : '' }}> {{ $object->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="text-white bg-primary-700 hover:bg-primary-800 font-medium rounded-lg text-sm px-5 py-2.5">Add Item</button>
                        <button type="button" data-modal-hide="createItemModal" class="text-red-600 hover:text-white border border-red-600 hover:bg-red-600 font-medium rounded-lg text-sm px-5 py-2.5">Bekor qilish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush

@push('scripts')
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('select').select2({
                theme: "default" // yoki boshqa theme sozlash mumkin
            });
        });

    </script>
@endpush
