@extends('layouts.dashboard')
@section('title', 'Booking Expenses Management')
@section('description', 'Manage booking expenses')

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-2 sm:p-4">
            <!-- Booking Info Card -->
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-6">
                <div class="p-5 flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Booking #{{ $booking->id }} - {{ $booking->tour->name ?? 'No Tour' }}
                        </h5>
                        <div class="flex flex-wrap gap-2">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                {{ $booking->user->name ?? 'No User' }}
                            </span>
                            <span class="bg-{{
                                $booking->status == 'confirmed' ? 'green' :
                                ($booking->status == 'cancelled' ? 'red' : 'yellow')
                            }}-100 text-{{
                                $booking->status == 'confirmed' ? 'green' :
                                ($booking->status == 'cancelled' ? 'red' : 'yellow')
                            }}-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-{{
                                $booking->status == 'confirmed' ? 'green' :
                                ($booking->status == 'cancelled' ? 'red' : 'yellow')
                            }}-200 dark:text-{{
                                $booking->status == 'confirmed' ? 'green' :
                                ($booking->status == 'cancelled' ? 'red' : 'yellow')
                            }}-800">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                        <div class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                            <p><span class="font-semibold">Dates:</span>
                                {{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}
                            </p>
                            <p><span class="font-semibold">Total Amount:</span> {{ number_format($booking->total_amount, 2) }}</p>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('bookings.index') }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-gray-600 rounded-lg hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Buyurtmalarga qaytish
                        </a>
                    </div>
                </div>
            </div>

            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
                <div class="items-center justify-between lg:flex">
                    <div class="mb-4 lg:mb-0">
                        <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Booking Expenses</h3>
                        <p class="text-gray-600 dark:text-gray-400">Manage expenses for this booking</p>
                    </div>
                    <div class="items-center sm:flex">
                        <button data-modal-target="createExpenseModal" data-modal-toggle="createExpenseModal" class="admin-add-btn" type="button">
                            <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                            </svg>
                            Add Expense
                        </button>
                    </div>
                </div>

                <div class="flex flex-col mt-6">
                    <div class="overflow-x-auto rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-100">
                            <tr>
                                <th scope="col" class="px-6 py-3">#</th>
                                <th scope="col" class="px-6 py-3">Expense Type</th>
                                <th scope="col" class="px-6 py-3">Title</th>
                                <th scope="col" class="px-6 py-3">Amount</th>
                                <th scope="col" class="px-6 py-3">Description</th>
                                <th scope="col" class="px-6 py-3">Added By</th>
                                <th scope="col" class="px-6 py-3">Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($expenses as $expense)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-4">
                                        {{ $expense->expense->name ?? 'N/A' }}
                                        @if($expense->expense)
                                            <span class="text-xs text-gray-500 dark:text-gray-400 block">({{ $expense->expense->sub_category }})</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">{{ $expense->title }}</td>
                                    <td class="px-6 py-4">{{ number_format($expense->amount, 2) }}</td>
                                    <td class="px-6 py-4">{{ $expense->description ?? '-' }}</td>
                                    <td class="px-6 py-4">{{ $expense->user->name ?? 'System' }}</td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <!-- Edit Button -->
                                            <button data-modal-target="editExpenseModal-{{ $expense->id }}" data-modal-toggle="editExpenseModal-{{ $expense->id }}" class="admin-edit-btn">
                                                Tahrirlash
                                            </button>

                                            <!-- Delete Button -->
                                            <button data-modal-target="deleteExpenseModal-{{ $expense->id }}" data-modal-toggle="deleteExpenseModal-{{ $expense->id }}" class="admin-delete-btn">
                                                Delete
                                            </button>
                                        </div>
                                    </td>
                                </tr>

                                <!-- Edit Expense Modal -->
                                <div id="editExpenseModal-{{ $expense->id }}" tabindex="-1" class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full h-modal md:h-full">
                                    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5">
                                            <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-600">
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                    Edit Expense
                                                </h3>
                                                <button type="button" class="admin-close-modal-btn" data-modal-hide="editExpenseModal-{{ $expense->id }}">
                                                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('bookings.expenses.update', [$booking->id, $expense->id]) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">Expense Type</label>
                                                    <select name="expense_id" class="e-input" required>
                                                        <option value="" selected disabled>Select Expense Type</option>
                                                        @foreach($allExpenses as $expenseType)
                                                            <option value="{{ $expenseType->id }}" {{ $expense->expense_id == $expenseType->id ? 'selected' : '' }}>
                                                                {{ $expenseType->name }} ({{ $expenseType->sub_category }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">Title</label>
                                                    <input type="text" name="title" value="{{ $expense->title }}" class="e-input" required placeholder="title">
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">Amount</label>
                                                    <input type="number" step="0.01" name="amount" value="{{ $expense->amount }}" class="e-input" required placeholder="0">
                                                </div>
                                                <div class="mb-4">
                                                    <label class="block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                                    <textarea name="description" class="e-input" placeholder="Description">{{ $expense->description }}</textarea>
                                                </div>
                                                <div class="flex justify-end space-x-2">
                                                    <button type="submit" class="admin-add-btn">Update Expense</button>
                                                    <button type="button" data-modal-hide="editExpenseModal-{{ $expense->id }}" class="admin-cancel-btn">Bekor qilish</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Expense Modal -->
                                <div id="deleteExpenseModal-{{ $expense->id }}" tabindex="-1" class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full h-modal md:h-full">
                                    <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5 text-center">
                                            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white" data-modal-hide="deleteExpenseModal-{{ $expense->id }}">
                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                            <svg class="mx-auto mb-4 w-12 h-12 text-gray-400 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">O'chirganingizdan keyin uni qayta tiklab bo'lmaydi this expense?</h3>
                                            <div class="flex justify-center space-x-4">
                                                <form action="{{ route('bookings.expenses.destroy', [$booking->id, $expense->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="admin-delete-btn">
                                                        Ha , o'chirish
                                                    </button>
                                                </form>
                                                <button type="button" data-modal-hide="deleteExpenseModal-{{ $expense->id }}" class="admin-cancel-btn">
                                                    No, cancel
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                        No expenses found for this booking.
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Expense Modal -->
    <div id="createExpenseModal" tabindex="-1" class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-800 p-5">
                <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Add New Expense
                    </h3>
                    <button type="button" class="admin-close-modal-btn" data-modal-hide="createExpenseModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="{{ route('bookings.expenses.store', $booking->id) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Expense Type</label>
                        <select name="expense_id" class="e-input" required>
                            <option value="" selected disabled>Select Expense Type</option>
                            @foreach($allExpenses as $expense)
                                <option value="{{ $expense->id }}">
                                    {{ $expense->name }} ({{ $expense->sub_category }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Title</label>
                        <input type="text" name="title" class="e-input" required placeholder="Title">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Amount</label>
                        <input type="number" step="0.01" name="amount" class="e-input" required placeholder="0">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-900 dark:text-white">Description</label>
                        <textarea name="description" class="e-input" placeholder="Description"></textarea>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="submit" class="admin-add-btn">Add Expense</button>
                        <button type="button" data-modal-hide="createExpenseModal" class="admin-cancel-btn">Bekor qilish</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
