@extends('layouts.dashboard')
@section('title', "Balances Management")
@section('description', "Manage financial balances")

@section('content')
    <div class="px-4 pt-6 min-h-screen w-1/2">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <!-- Card header -->
            <div class="items-center justify-between lg:flex">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Balances Management</h3>
                </div>
                <div class="items-center sm:flex">
                    <button data-modal-target="createBalanceModal" data-modal-toggle="createBalanceModal" class="admin-add-btn" type="button">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add new balance
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
                                    <th scope="col" class="px-6 py-3">Currency</th>
                                    <th scope="col" class="px-6 py-3">Amount</th>
                                    <th scope="col" class="px-6 py-3">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($balances as $balance)
                                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $loop->iteration }}</td>
                                        <td class="px-6 py-4">{{ $balance->name }}</td>
                                        <td class="px-6 py-4">{{ $balance->currency->name ?? 'N/A' }} ({{ $balance->currency->code ?? '' }})</td>
                                        <td class="px-6 py-4">{{ number_format($balance->amount, 2) }}</td>
                                        <td class="px-6 py-4">
                                            <button type="button" data-modal-target="editBalanceModal-{{ $balance->id }}" data-modal-toggle="editBalanceModal-{{ $balance->id }}" class="admin-edit-btn">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                                </svg>
                                                Edit
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div id="editBalanceModal-{{ $balance->id }}" tabindex="-1" class="hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-modal md:h-full">
                                        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5">
                                                <div class="flex justify-between items-center pb-4 mb-4 border-b dark:border-gray-600">
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Edit Balance</h3>
                                                    <button type="button" data-modal-hide="editBalanceModal-{{ $balance->id }}" class="admin-close-modal-btn">
                                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <form action="{{ route('balances.update', $balance->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="mb-4">
                                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                                        <input type="text" name="name" value="{{ $balance->name }}" class="e-input" required>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Currency</label>
                                                        <select name="currency_id" class="e-input" required>
                                                            @foreach($currencies as $currency)
                                                                <option value="{{ $currency->id }}" {{ $balance->currency_id == $currency->id ? 'selected' : '' }}>
                                                                    {{ $currency->name }} ({{ $currency->code }})
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-4">
                                                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Amount</label>
                                                        <input type="number" step="0.01" name="amount" value="{{ $balance->amount }}" class="e-input" required>
                                                    </div>
                                                    <div class="flex justify-end space-x-2">
                                                        <button type="submit" class="admin-add-btn">Update</button>
                                                        <button type="button" data-modal-hide="editBalanceModal-{{ $balance->id }}" class="admin-cancel-btn">Cancel</button>
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

    <!-- Create Balance Modal -->
    <div id="createBalanceModal" tabindex="-1" class="hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5">
                <div class="flex justify-between items-center pb-4 mb-4 border-b dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Add New Balance</h3>
                    <button type="button" data-modal-hide="createBalanceModal" class="admin-close-modal-btn">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('balances.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                        <input type="text" name="name" class="e-input" placeholder="Balance name" required>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Currency</label>
                        <select name="currency_id" class="e-input" required>
                            @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}">{{ $currency->name }} ({{ $currency->code }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Amount</label>
                        <input type="number" step="0.01" name="amount" class="e-input" placeholder="0.00" required>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="submit" class="admin-add-btn">Add Balance</button>
                        <button type="button" data-modal-hide="createBalanceModal" class="admin-cancel-btn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
