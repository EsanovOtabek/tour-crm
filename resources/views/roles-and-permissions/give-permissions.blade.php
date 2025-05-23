@extends('layouts.dashboard')
@section('title', "Tizimdagi rollarga ruxsatlarni biriktirish")
@section('description', "Tizimdagi rollarga ruxsatlarni biriktirish")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <!-- Card header -->
            <div class="items-center justify-between lg:flex">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Rollar va ruxsatlarni boshqarish</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tizimdagi rollarga ruxsatlarni biriktirish</p>
                </div>
            </div>

            <!-- Role tanlash form (GET orqali) -->
            <div class="mt-6">
                <form method="GET" action="{{ route('roles.permissions.index') }}">
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Rolni tanlang</label>
                            <select id="role" name="role_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required>
                                <option value="">Tanlang</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="admin-add-btn mt-7">
                                Tortib olish
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Permissions form (POST orqali) -->
            @if(isset($selectedRole))
                <form method="POST" action="{{ route('roles.permissions.sync') }}">
                    @csrf
                    <input type="hidden" name="role_id" value="{{ $selectedRole->id }}">

                    <div class="mt-6">
                        <h4 class="mb-4 text-lg font-medium text-gray-900 dark:text-white"> {{ $selectedRole->name }} ruxsatlari</h4>

                        <div class="space-y-6">
                            @foreach($custom_permission as $group => $permissions)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 group-permission-block">
                                    <div class="flex items-center justify-between mb-3">
                                        <h5 class="text-md font-semibold text-gray-800 dark:text-gray-200 capitalize">{{ $group }} Ruxsatlar</h5>
                                        <label class="text-sm text-gray-700 dark:text-gray-300">
                                            <input type="checkbox" class="select-all-group-checkbox mr-1">
                                            Barchasini tanlash
                                        </label>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                                        @foreach($permissions as $permission)
                                            <div class="flex items-center">
                                                <input id="permission-{{ $permission->id }}" name="permissions[]" type="checkbox" value="{{ $permission->id }}"
                                                       {{ $selectedRole->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                       class="w-4 h-4 text-primary-600 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 permission-checkbox">
                                                <label for="permission-{{ $permission->id }}" class="ml-2 text-sm text-gray-900 dark:text-gray-300">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="admin-add-btn">
                                Yangilash
                            </button>
                        </div>
                    </div>
                </form>
            @endif

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.group-permission-block').forEach(function(group) {
            const selectAllCheckbox = group.querySelector('.select-all-group-checkbox');
            const checkboxes = group.querySelectorAll('.permission-checkbox');

            // Dastlabki holatni tekshirish
            function updateSelectAllState() {
                const allChecked = [...checkboxes].every(checkbox => checkbox.checked);
                selectAllCheckbox.checked = allChecked;
            }

            // "Select All"ni bosganda
            selectAllCheckbox.addEventListener('change', function () {
                checkboxes.forEach(cb => cb.checked = this.checked);
            });

            // Ichki checkboxlardan birortasi bosilganda
            checkboxes.forEach(cb => {
                cb.addEventListener('change', updateSelectAllState);
            });

            updateSelectAllState(); // Sahifa yuklanganda holatni to'g'rilash
        });
    </script>
@endpush
