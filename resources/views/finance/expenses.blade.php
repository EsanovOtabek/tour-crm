@extends('layouts.dashboard')
@section('title', 'Expenses Management')
@section('description', 'Manage expenses and limits')

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <div class="items-center justify-between lg:flex">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Expenses Management</h3>
                </div>
                <div class="items-center sm:flex">
                    <button data-modal-target="createExpenseModal" data-modal-toggle="createExpenseModal" class="admin-add-btn" type="button">Add new expense</button>
                </div>
            </div>
            <div class="flex flex-col mt-6">
                <div class="overflow-x-auto rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">Name</th>
                            <th scope="col" class="px-6 py-3">Allowed</th>
                            <th scope="col" class="px-6 py-3">Sub Category</th>
                            <th scope="col" class="px-6 py-3">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($expenses as $expense)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4">{{ $expense->name }}</td>
                                <td class="px-6 py-4">{{ $expense->allowed }}</td>
                                <td class="px-6 py-4">{{ $expense->sub_category }}</td>
                                <td class="px-6 py-4">
                                    <!-- Edit and Delete buttons go here -->
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Modal example -->
    <div id="createExpenseModal" tabindex="-1" class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5">
                <form action="{{ route('expenses.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" name="name" class="e-input" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Allowed</label>
                        <input type="number" step="0.01" name="allowed" class="e-input" required>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Sub Category</label>
                        <input type="text" name="sub_category" class="e-input">
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="submit" class="admin-add-btn">Add Expense</button>
                        <button type="button" data-modal-hide="createExpenseModal" class="admin-cancel-btn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
