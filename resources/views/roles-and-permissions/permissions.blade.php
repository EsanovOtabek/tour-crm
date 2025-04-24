@extends('layouts.dashboard')
@section('title', "Ruxsatlarni boshqarish")
@section('description', "Tizimdagi Ruxsatlarni boshqarish")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <!-- Card header -->
            <div class="items-center justify-between lg:flex">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Ruxsatlarni boshqarish</h3>
                </div>
                <div class="items-center sm:flex">
                    <button data-modal-target="createPermissionModal" data-modal-toggle="createPermissionModal" class="admin-add-btn" type="button">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Qo'shish
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
                                        Nomi
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Sana
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-medium tracking-wider text-left text-gray-500 uppercase dark:text-white">
                                        Amallar
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800">
                                @foreach($permissions as $permission)
                                    <tr>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            <span class="bg-purple-100 text-purple-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-purple-200 dark:text-purple-800">{{ $permission->name }}</span>
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">
                                            {{ $permission->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="p-4 space-x-2 whitespace-nowrap">
                                            <button type="button" data-modal-target="editPermissionModal-{{ $permission->id }}" data-modal-toggle="editPermissionModal-{{ $permission->id }}" class="admin-edit-btn">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                                </svg>
                                                Tahrirlash
                                            </button>
                                            <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="admin-delete-btn" onclick="return confirm('O'chirganingizdan keyin uni qayta tiklab bo'lmaydi this permission?')">
                                                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    O'chirish
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Permission Modal -->
                                    <div id="editPermissionModal-{{ $permission->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                                            <!-- Modal content -->
                                            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                                <!-- Modal header -->
                                                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                        Tahrirlash
                                                    </h3>
                                                    <button type="button" class="admin-close-modal-btn" data-modal-hide="editPermissionModal-{{ $permission->id }}">
                                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <form action="{{ route('permissions.update', $permission->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="grid gap-4 mb-4">
                                                        <div>
                                                            <label for="permission-name-{{ $permission->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ruxsat nomi</label>
                                                            <input type="text" name="name" id="permission-name-{{ $permission->id }}" value="{{ $permission->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-4">
                                                        <button type="submit" class="admin-add-btn">
                                                            Yangilash
                                                        </button>
                                                        <button type="button" data-modal-hide="editPermissionModal-{{ $permission->id }}" class="admin-cancel-btn">
                                                            Orqaga
                                                        </button>
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

            <!-- Pagination -->
            <div class="flex items-center justify-between pt-3 sm:pt-6">
                <div class="flex-1 flex justify-between sm:hidden">
                    @if($permissions->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">Previous</span>
                    @else
                        <a href="{{ $permissions->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Previous</a>
                    @endif

                    @if($permissions->hasMorePages())
                        <a href="{{ $permissions->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Next</a>
                    @else
                        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">Next</span>
                    @endif
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Showing
                            <span class="font-medium">{{ $permissions->firstItem() ?? 0 }}</span>
                            to
                            <span class="font-medium">{{ $permissions->lastItem() ?? 0 }}</span>
                            of
                            <span class="font-medium">{{ $permissions->total() }}</span>
                            results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                            {{ $permissions->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Permission Modal -->
    <div id="createPermissionModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Qo'shish
                    </h3>
                    <button type="button" class="admin-close-modal-btn" data-modal-hide="createPermissionModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('permissions.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4">
                        <div>
                            <label for="permission-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomi</label>
                            <input type="text" name="name" id="permission-name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="e.g. edit articles" required>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="admin-add-btn">
                            Saqlash
                        </button>
                        <button type="button" data-modal-hide="createPermissionModal" class="admin-cancel-btn">
                            Bekor qilish
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
