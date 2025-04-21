@extends('layouts.dashboard')
@section('title', "Guides Management")
@section('description', "Manage guides for tourists")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <!-- Card header -->
            <div class="items-center justify-between lg:flex">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Partner Types Management</h3>
                </div>
                <div class="items-center sm:flex">
                    <button type="button" data-modal-target="add-guide-modal" data-modal-toggle="add-guide-modal" class="admin-add-btn">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path></svg>
                        Add Guide
                    </button>
                </div>
            </div>
            <div class="flex flex-col  mt-6">
                <div class="overflow-x-auto">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden shadow">
                            <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-600">
                                <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        #
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Name
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Category
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        City
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Price
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Languages
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Status
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach($guides as $guide)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ 1 + $loop->index }}</td>
                                        <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $guide->name }}</td>
                                        <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $guide->category->name ?? 'N/A' }}</td>
                                        <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $guide->tour_city->name ?? 'N/A' }}</td>
                                        <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ number_format($guide->price, 2) }}</td>
                                        <td class="p-4 text-base font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            @foreach($guide->languages as $language)
                                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">{{ $language->name }}</span>
                                            @endforeach
                                        </td>
                                        <td class="p-4 text-base font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <div class="flex items-center">
                                                <div class="h-2.5 w-2.5 rounded-full bg-{{$guide->status}}-400 mr-1"></div>
                                                @switch($guide->status)
                                                    @case('green')
                                                        Accepted
                                                        @break
                                                    @case('yellow')
                                                        Waiting
                                                        @break
                                                    @case('red')
                                                        Busy
                                                        @break
                                                @endswitch
                                            </div>
                                        </td>
                                        <td class="p-4 space-x-2 whitespace-nowrap">
                                            <button type="button" data-modal-target="edit-guide-modal-{{ $guide->id }}" data-modal-toggle="edit-guide-modal-{{ $guide->id }}" class="admin-add-btn">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg>
                                                Edit
                                            </button>
                                            <button type="button" data-modal-target="delete-guide-modal-{{ $guide->id }}" data-modal-toggle="delete-guide-modal-{{ $guide->id }}" class="admin-delete-btn">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                                Delete
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sticky bottom-0 right-0 items-center w-full p-4 bg-white border-t border-gray-200 sm:flex sm:justify-between dark:bg-gray-800 dark:border-gray-700">
                <div class="flex items-center mb-4 sm:mb-0">
                    <span class="text-sm font-normal text-gray-500 dark:text-gray-400">Showing <span class="font-semibold text-gray-900 dark:text-white">1-{{ $guides->count() }}</span> of <span class="font-semibold text-gray-900 dark:text-white">{{ $guides->total() }}</span></span>
                </div>
                <div class="flex items-center space-x-3">
                    @if($guides->previousPageUrl())
                        <a href="{{ $guides->previousPageUrl() }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            <svg class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            Previous
                        </a>
                    @endif
                    @if($guides->nextPageUrl())
                        <a href="{{ $guides->nextPageUrl() }}" class="inline-flex items-center justify-center flex-1 px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            Next
                            <svg class="w-5 h-5 ml-1 -mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Guide Modal -->
    <div class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full" id="add-guide-modal">
        <div class="relative w-full h-full max-w-2xl px-4 md:h-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-xl font-semibold dark:text-white">
                        Add new guide
                    </h3>
                    <button type="button" class="admin-close-modal-btn" data-modal-toggle="add-guide-modal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="block p-6 space-y-6">
                    <form action="{{ route('guides.store') }}" method="POST" id="addGuideForm">
                        @csrf
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                <label for="name" class="e-label">Name</label>
                                <input type="text" name="name" id="name" class="e-input" required placeholder="Name">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="guide_category_id" class="e-label">Category</label>
                                <select name="guide_category_id" id="guide_category_id" class="e-input" required>
                                    <option value="">Select category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="tour_city_id" class="e-label">City</label>
                                <select name="tour_city_id" id="tour_city_id" class="e-input" required>
                                    <option value="">Select city</option>
                                    @foreach($tour_cities as $city)
                                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="price" class="e-label">Price</label>
                                <input type="number" step="0.01" name="price" id="price" class="e-input" required placeholder="0">
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="status" class="e-label">Status</label>
                                <select name="status" id="status" class="e-input" required>

                                    <option value="green">Accepted</option>
                                    <option value="yellow">Waiting</option>
                                    <option value="red">Busy</option>
                                </select>
                            </div>
                            <div class="col-span-6">
                                <label for="languages" class="e-label">Languages</label>
                                <div class="select2-purple">
                                    <select id="languages" name="languages[]" multiple data-placeholder="Select a Languages" data-dropdown-css-class="select2-purple"
                                            class="select-languages" style="width: 100%">
                                        @foreach($languages as $language)
                                            <option value="{{ $language->id }}">{{ $language->name }} ({{ $language->name_native }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Hold Ctrl/Cmd to select multiple languages</p>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-700">
                    <button class="admin-add-btn" type="submit" form="addGuideForm">Add guide</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Guide Modals -->
    @foreach($guides as $guide)
        <div class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full" id="edit-guide-modal-{{ $guide->id }}">
            <div class="relative w-full h-full max-w-2xl px-4 md:h-auto">
                <!-- Modal content -->
                <form action="{{ route('guides.update', $guide->id) }}" method="POST" class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                    @csrf
                    @method('PUT')
                    <!-- Modal header -->
                    <div class="flex items-start justify-between p-5 border-b rounded-t dark:border-gray-700">
                        <h3 class="text-xl font-semibold dark:text-white">
                            Edit guide
                        </h3>
                        <button type="button" class="admin-close-modal-btn" data-modal-toggle="edit-guide-modal-{{ $guide->id }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 space-y-6">

                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6">
                                <label for="name-{{ $guide->id }}" class="e-label">Name</label>
                                <input type="text" name="name" id="name-{{ $guide->id }}" value="{{ $guide->name }}" class="e-input" required>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="guide_category_id-{{ $guide->id }}" class="e-label">Category</label>
                                <select name="guide_category_id" id="guide_category_id-{{ $guide->id }}" class="e-input" required>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $guide->guide_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="tour_city_id-{{ $guide->id }}" class="e-label">City</label>
                                <select name="tour_city_id" id="tour_city_id-{{ $guide->id }}" class="e-input" required>
                                    @foreach($tour_cities as $city)
                                        <option value="{{ $city->id }}" {{ $guide->tour_city_id == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="price-{{ $guide->id }}" class="e-label">Price</label>
                                <input type="number" step="0.01" name="price" id="price-{{ $guide->id }}" value="{{ $guide->price }}" class="e-input" required>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="status-{{ $guide->id }}" class="e-label">Status</label>
                                <select name="status" id="status-{{ $guide->id }}" class="e-input" required>
                                    <option value="green" {{ $guide->status == 'green' ? 'selected' : '' }}>Accepted</option>
                                    <option value="yellow" {{ $guide->status == 'yellow' ? 'selected' : '' }}>Waiting</option>
                                    <option value="red" {{ $guide->status == 'red' ? 'selected' : '' }}>Busy</option>
                                </select>
                            </div>
                            <div class="col-span-6">
                                <label for="languages-{{ $guide->id }}" class="e-label">Languages</label>
                                <div class="select2-purple">

                                    <select id="languages-{{ $guide->id }}" name="languages[]" multiple data-placeholder="Select a Languages" data-dropdown-css-class="select2-purple"
                                            class="select-languages" style="width: 100%">
                                        @foreach($languages as $language)
                                            <option value="{{ $language->id }}" {{ $guide->languages->contains($language->id) ? 'selected' : '' }}>{{ $language->name }} ({{ $language->name_native }})</option>
                                        @endforeach
                                    </select>
                                </div>

                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Hold Ctrl/Cmd to select multiple languages</p>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="items-center p-6 border-t border-gray-200 rounded-b dark:border-gray-700">
                        <button class="admin-add-btn" type="submit">Update guide</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Delete Guide Modal -->
        <div class="fixed left-0 right-0 z-50 items-center justify-center hidden overflow-x-hidden overflow-y-auto top-4 md:inset-0 h-modal sm:h-full" id="delete-guide-modal-{{ $guide->id }}">
            <div class="relative w-full h-full max-w-md px-4 md:h-auto">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
                    <!-- Modal header -->
                    <div class="flex justify-end p-2">
                        <button type="button" class="admin-close-modal-btn" data-modal-hide="delete-guide-modal-{{ $guide->id }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-6 text-center">
                        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">
                            Are you sure you want to delete this guide?
                        </h3>
                        <form action="{{ route('guides.destroy', $guide->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="admin-delete-btn">
                                Yes, delete
                            </button>
                            <button type="button" data-modal-hide="delete-guide-modal-{{ $guide->id }}"
                                    class="admin-cancel-btn">
                                No, cancel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection


@push('styles')
    <!-- Select2  -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select-languages{
            @apply shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500;
        }
    </style>
@endpush

@push('scripts')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select-languages').select2();
        });
    </script>
@endpush
