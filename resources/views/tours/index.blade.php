@extends('layouts.dashboard')
@section('title', "Tur paketlar")
@section('description', "Tur paketlarni boshqarish")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4  rounded-lg shadow-sm  sm:p-6 ">
            <!-- Card header -->
            <div class="items-center justify-between lg:flex">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Tur paketlar</h3>
                </div>
                <div class="items-center sm:flex space-x-3">
                    <!-- Category filter dropdown -->
                    <form action="" method="GET" class="mb-4 lg:mb-0">
                        <select name="category_id" id="category-filter" class="w-96 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" onchange="this.form.submit()">
                            <option value="">Barcha kategoriyalar</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $selectedCategoryId == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <button data-modal-target="createTourModal" data-modal-toggle="createTourModal" class="admin-add-btn" type="button">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Qo'shish
                    </button>
                </div>
            </div>

            <!-- Tours Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6 mt-6">
                @foreach($tours as $tour)
                    <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-5">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $tour->name }}</h5>
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                        {{ $tour->category->name ?? 'No Category' }}
                                    </span>
                                </div>
                                <span class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-green-200 dark:text-green-800">
                                    {{ $tour->status }}
                                </span>
                            </div>

                            <div class="mt-4 space-y-2">
                                <p class="text text-gray-600 dark:text-gray-300">
                                    <span class="font-semibold">Kodi:</span> {{ $tour->code }}
                                </p>
                                <p class="text text-gray-600 dark:text-gray-300">
                                    <span class="font-semibold">Unikal kodi(UK):</span> {{ $tour->{'unique-code'} }}
                                </p>
                                <p class="text text-gray-600 dark:text-gray-300">
                                    <span class="font-semibold">Davomiyligi:</span> {{ $tour->day_quantity }} kun
                                </p>
                            </div>

                            <div class="mt-4 flex space-x-2">
                                <button type="button" data-modal-target="editTourModal-{{ $tour->id }}" data-modal-toggle="editTourModal-{{ $tour->id }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg bg-yellow-600 hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800">
                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    Tahrirlash
                                </button>
                                <button type="button" data-modal-target="deleteTourModal-{{ $tour->id }}" data-modal-toggle="deleteTourModal-{{ $tour->id }}" class="admin-delete-btn">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Tour Modal -->
                    <div id="editTourModal-{{ $tour->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                            <!-- Modal content -->
                            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                <!-- Modal header -->
                                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        Edit Tour
                                    </h3>
                                    <button type="button" class="admin-close-modal-btn" data-modal-hide="editTourModal-{{ $tour->id }}">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <!-- Modal body -->
                                <form action="{{ route('tours.update', $tour->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                                        <div>
                                            <label for="edit-name-{{ $tour->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomi</label>
                                            <input type="text" name="name" id="edit-name-{{ $tour->id }}" value="{{ $tour->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                        </div>
                                        <div>
                                            <label for="edit-code-{{ $tour->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kodi</label>
                                            <input type="text" name="code" id="edit-code-{{ $tour->id }}" value="{{ $tour->code }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                        </div>
                                        <div>
                                            <label for="edit-unique-code-{{ $tour->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unikal kodi(UK)</label>
                                            <input type="text" name="unique-code" id="edit-unique-code-{{ $tour->id }}" value="{{ $tour->{'unique-code'} }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                        </div>
                                        <div>
                                            <label for="edit-status-{{ $tour->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                            <select name="status" id="edit-status-{{ $tour->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                                <option value="active" {{ $tour->status == 'active' ? 'selected' : '' }}>Faol</option>
                                                <option value="inactive" {{ $tour->status == 'inactive' ? 'selected' : '' }}>Faol emas</option>
                                                <option value="draft" {{ $tour->status == 'draft' ? 'selected' : '' }}>Qoralama</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label for="edit-day_quantity-{{ $tour->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Davomiyligi (days)</label>
                                            <input type="number" name="day_quantity" id="edit-day_quantity-{{ $tour->id }}" value="{{ $tour->day_quantity }}" min="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                        </div>
                                        <div>
                                            <label for="edit-tour_category_id-{{ $tour->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"><Kategoriya></Kategoriya></label>
                                            <select name="tour_category_id" id="edit-tour_category_id-{{ $tour->id }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $tour->tour_category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <button type="submit" class="admin-add-btn">
                                            Yangilash
                                        </button>
                                        <button type="button" data-modal-hide="editTourModal-{{ $tour->id }}" class="admin-cancel-btn">
                                            Bekor qilish
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Tour Modal -->
                    <div id="deleteTourModal-{{ $tour->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                            <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteTourModal-{{ $tour->id }}">
                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                                <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="mb-4 text-gray-500 dark:text-gray-300">O'chirganingizdan keyin uni qayta tiklab bo'lmaydi "{{ $tour->name }}"?</p>
                                <div class="flex justify-center items-center space-x-4">
                                    <form action="{{ route('tours.destroy', $tour->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="py-2 px-3 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                            Ha , o'chirish
                                        </button>
                                    </form>
                                    <button data-modal-toggle="deleteTourModal-{{ $tour->id }}" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                        Bekor qilish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between pt-3 sm:pt-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if($tours->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">Previous</span>
                    @else
                        <a href="{{ $tours->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Previous</a>
                    @endif

                    @if($tours->hasMorePages())
                        <a href="{{ $tours->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Next</a>
                    @else
                        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">Next</span>
                    @endif
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Showing
                            <span class="font-medium">{{ $tours->firstItem() ?? 0 }}</span>
                            to
                            <span class="font-medium">{{ $tours->lastItem() ?? 0 }}</span>
                            of
                            <span class="font-medium">{{ $tours->total() }}</span>
                            results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                            {{ $tours->appends(['category_id' => $selectedCategoryId])->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Tour Modal -->
    <div id="createTourModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Qo'shish
                    </h3>
                    <button type="button" class="admin-close-modal-btn" data-modal-hide="createTourModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('tours.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-2">
                        <div>
                            <label for="create-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomi</label>
                            <input type="text" name="name" id="create-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Tour name" required>
                        </div>
                        <div>
                            <label for="create-code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kodi</label>
                            <input type="text" name="code" id="create-code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Tour code" required>
                        </div>
                        <div>
                            <label for="create-unique-code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Unikal kodi(UK)</label>
                            <input type="text" name="unique-code" id="create-unique-code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Unique code" required>
                        </div>
                        <div>
                            <label for="create-status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select name="status" id="create-status" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="draft">Draft</option>
                            </select>
                        </div>
                        <div>
                            <label for="create-day_quantity" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Davomiyligi (days)</label>
                            <input type="number" name="day_quantity" id="create-day_quantity" min="1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Number of days" required>
                        </div>
                        <div>
                            <label for="create-tour_category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                            <select name="tour_category_id" id="create-tour_category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                <option value="">Select category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="admin-add-btn">
                            Saqlash
                        </button>
                        <button type="button" data-modal-hide="createTourModal" class="admin-cancel-btn">
                            Bekor qilish
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
