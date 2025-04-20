@extends('layouts.dashboard')
@section('title', "Guides Management")
@section('description', "Manage guides for tourists")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <!-- Card header -->
            <div class="items-center justify-between lg:flex">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Guides Management</h3>
                </div>
                <div class="items-center sm:flex">
                    <button data-modal-target="createGuideModal" data-modal-toggle="createGuideModal" class="admin-add-btn" type="button">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add new guide
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="flex flex-col mt-6">
                <div class="overflow-x-auto rounded-lg">
                    <div class="inline-block min-w-full align-middle">
                        <div class="overflow-hidden shadow sm:rounded-lg">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-6 py-3">#</th>
                                    <th scope="col" class="px-6 py-3">Name</th>
                                    <th scope="col" class="px-6 py-3">Category</th>
                                    <th scope="col" class="px-6 py-3">City</th>
                                    <th scope="col" class="px-6 py-3">Price</th>
                                    <th scope="col" class="px-6 py-3">Status</th>
                                    <th scope="col" class="px-6 py-3">Languages</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($guides as $guide)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{ $guide->name }}</td>
                                        <td class="px-6 py-4">{{ $guide->category->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">{{ $guide->city->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">{{ $guide->price }}</td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-medium {{ $guide->status ? 'text-green-700 bg-green-100' : 'text-red-700 bg-red-100' }} rounded-full">
                                                {{ $guide->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($guide->languages as $language)
                                                    <span class="px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full">{{ $language->name }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <button type="button" data-modal-target="editGuideModal-{{ $guide->id }}" data-modal-toggle="editGuideModal-{{ $guide->id }}" class="admin-edit-btn">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                                </svg>
                                                Edit
                                            </button>
                                            <form action="{{ route('guides.destroy', $guide->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="admin-delete-btn">
                                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div id="editGuideModal-{{ $guide->id }}" tabindex="-1" class="hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-modal md:h-full">
                                        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5">
                                                <div class="flex justify-between items-center pb-4 mb-4 border-b dark:border-gray-600">
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Guide</h3>
                                                    <button type="button" data-modal-hide="editGuideModal-{{ $guide->id }}" class="admin-close-modal-btn">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <form action="{{ route('guides.update', $guide->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                        <div class="mb-4">
                                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                                            <input type="text" name="name" value="{{ $guide->name }}" class="e-input" required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                                                            <select name="guide_category_id" class="e-input" required>
                                                                @foreach($categories as $category)
                                                                    <option value="{{ $category->id }}" {{ $guide->guide_category_id == $category->id ? 'selected' : '' }}>
                                                                        {{ $category->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                                                            <select name="city_id" class="e-input" required>
                                                                @foreach($cities as $city)
                                                                    <option value="{{ $city->id }}" {{ $guide->city_id == $city->id ? 'selected' : '' }}>
                                                                        {{ $city->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                                                            <input type="number" name="price" value="{{ $guide->price }}" class="e-input" required>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                                            <select name="status" class="e-input" required>
                                                                <option value="1" {{ $guide->status ? 'selected' : '' }}>Active</option>
                                                                <option value="0" {{ !$guide->status ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-4">
                                                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Languages</label>
                                                            <select name="languages[]" class="e-input" multiple>
                                                                @foreach($languages as $language)
                                                                    <option value="{{ $language->id }}" {{ $guide->languages->contains($language->id) ? 'selected' : '' }}>
                                                                        {{ $language->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="flex justify-end space-x-2 mt-4">
                                                        <button type="submit" class="admin-add-btn">Update</button>
                                                        <button type="button" data-modal-hide="editGuideModal-{{ $guide->id }}" class="admin-cancel-btn">Cancel</button>
                                                    </div>
                                                </form>
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

    <!-- Create Guide Modal -->
    <div id="createGuideModal" tabindex="-1" class="hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5">
                <div class="flex justify-between items-center pb-4 mb-4 border-b dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Guide</h3>
                    <button type="button" data-modal-hide="createGuideModal" class="admin-close-modal-btn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('guides.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="text" name="name" class="e-input" placeholder="Guide name" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                            <select name="guide_category_id" class="e-input" required>
                                <option value="">Select a category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">City</label>
                            <select name="city_id" class="e-input" required>
                                <option value="">Select a city</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}">{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
                            <input type="number" name="price" class="e-input" placeholder="0.00" required>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select name="status" class="e-input" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Languages</label>
                            <select name="languages[]" class="e-input" multiple>
                                @foreach($languages as $language)
                                    <option value="{{ $language->id }}">{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2 mt-4">
                        <button type="submit" class="admin-add-btn">Add Guide</button>
                        <button type="button" data-modal-hide="createGuideModal" class="admin-cancel-btn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
