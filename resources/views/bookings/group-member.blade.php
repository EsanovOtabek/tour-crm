@extends('layouts.dashboard')
@section('title', "Group Member Details")
@section('description', "View group member details")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 rounded-lg shadow-sm sm:p-6">
            <!-- Member Info Card (Horizontal) -->
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-6">
                <div class="p-5 flex flex-col md:flex-row md:items-start md:justify-between">
                    <div class="mb-4 md:mb-0 w-full">
                        <div class="flex justify-between items-start mb-4">
                            <h5 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $groupMember->surname }} {{ $groupMember->name }}
                            </h5>
                            <div class="flex space-x-2">
                                <span class="bg-{{
                                    $groupMember->status == 'active' ? 'green' :
                                    ($groupMember->status == 'cancelled' ? 'red' : 'yellow')
                                }}-100 text-{{
                                    $groupMember->status == 'active' ? 'green' :
                                    ($groupMember->status == 'cancelled' ? 'red' : 'yellow')
                                }}-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-{{
                                    $groupMember->status == 'active' ? 'green' :
                                    ($groupMember->status == 'cancelled' ? 'red' : 'yellow')
                                }}-200 dark:text-{{
                                    $groupMember->status == 'active' ? 'green' :
                                    ($groupMember->status == 'cancelled' ? 'red' : 'yellow')
                                }}-800">
                                    {{ ucfirst($groupMember->status) }}
                                </span>
                                @if($groupMember->agent)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">
                                        {{ $groupMember->agent->name }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Personal Information -->
                            <div class="space-y-3">
                                <h6 class="text-md font-semibold text-gray-700 dark:text-gray-300 border-b pb-1">Personal Information</h6>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Full Name</label>
                                    <input type="text" value="{{ $groupMember->surname }} {{ $groupMember->name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" disabled>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Passport Number</label>
                                    <input type="text" value="{{ $groupMember->passport_number }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" disabled>
                                </div>
                            </div>

                            <!-- Contact Information -->
                            <div class="space-y-3">
                                <h6 class="text-md font-semibold text-gray-700 dark:text-gray-300 border-b pb-1">Contact Information</h6>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                                    <input type="text" value="{{ $groupMember->email ?? 'N/A' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" disabled>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Phone</label>
                                    <input type="text" value="{{ $groupMember->phone ?? 'N/A' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" disabled>
                                </div>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Telegram</label>
                                        <input type="text" value="{{ $groupMember->telegram ?? 'N/A' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" disabled>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">WhatsApp</label>
                                        <input type="text" value="{{ $groupMember->whatsapp ?? 'N/A' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Information -->
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-6">
                <div class="p-5">
                    <h5 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">Booking Information</h5>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Tour Name</label>
                            <input type="text" value="{{ $booking->tour->name ?? 'N/A' }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" disabled>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Booking Dates</label>
                            <input type="text" value="{{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" disabled>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400">Booking Status</label>
                            <input type="text" value="{{ ucfirst($booking->status) }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" disabled>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Daily Records Section -->
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-6">
                <div class="p-5">
                    <div class="flex justify-between items-center mb-4">
                        <h5 class="text-lg font-semibold text-gray-900 dark:text-white">Daily Records</h5>
                        <button type="button" data-modal-target="addDailyRecordModal" data-modal-toggle="addDailyRecordModal" class="admin-add-btn">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Add Daily Record
                        </button>
                    </div>

                    <!-- Daily Records Table -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">Date</th>
                                <th scope="col" class="px-6 py-3">Comment</th>
                                <th scope="col" class="px-6 py-3">Problem</th>
                                <th scope="col" class="px-6 py-3">Solution</th>
                                <th scope="col" class="px-6 py-3">Amallar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($groupMember->dailyRecords()->orderBy('day', 'desc')->get() as $record)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">{{ $record->day->format('M d, Y') }}</td>
                                    <td class="px-6 py-4">{{ $record->comment ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $record->problem ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">{{ $record->solve ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 flex space-x-2">
                                        <button type="button" data-modal-target="editDailyRecordModal-{{ $record->id }}" data-modal-toggle="editDailyRecordModal-{{ $record->id }}" class="admin-edit-btn">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                            </svg>
                                        </button>
                                        <form action="{{ route('daily-records.destroy', $record->id) }}" method="POST" onsubmit="return confirm('O'chirganingizdan keyin uni qayta tiklab bo'lmaydi this record?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="admin-delete-btn">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <!-- Edit Daily Record Modal for each record -->
                                <div id="editDailyRecordModal-{{ $record->id }}" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                    <div class="relative w-full max-w-2xl max-h-full">
                                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                            <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                    Edit Daily Record
                                                </h3>
                                                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="editDailyRecordModal-{{ $record->id }}">
                                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                    <span class="sr-only">Close modal</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('daily-records.update',  $record->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="p-6 space-y-6">
                                                    <div class="grid grid-cols-1 gap-4">
                                                        <div>
                                                            <input type="hidden" name="group_member_id" value="{{ $groupMember->id }}">

                                                            <label for="edit_day_{{ $record->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
                                                            <input type="date" id="edit_day_{{ $record->id }}" name="day" value="{{ $record->day->format('Y-m-d') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                                                        </div>
                                                        <div>
                                                            <label for="edit_comment_{{ $record->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comment</label>
                                                            <textarea id="edit_comment_{{ $record->id }}" name="comment" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ $record->comment }}</textarea>
                                                        </div>
                                                        <div>
                                                            <label for="edit_problem_{{ $record->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Problem</label>
                                                            <textarea id="edit_problem_{{ $record->id }}" name="problem" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ $record->problem }}</textarea>
                                                        </div>
                                                        <div>
                                                            <label for="edit_solve_{{ $record->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Solution</label>
                                                            <textarea id="edit_solve_{{ $record->id }}" name="solve" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">{{ $record->solve }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                    <button type="button" data-modal-hide="editDailyRecordModal-{{ $record->id }}" class="admin-cancel-btn">Bekor qilish</button>
                                                    <button type="submit" class="admin-add-btn">Update Record</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td colspan="5" class="px-6 py-4 text-center">No daily records found for this member.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('bookings.group-members.index', $booking->id) }}" class="admin-cancel-btn">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Group Members
                </a>
            </div>
        </div>
    </div>

    <!-- Add Daily Record Modal -->
    <div id="addDailyRecordModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Add Daily Record
                    </h3>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="addDailyRecordModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="{{ route('daily-records.store', ['booking' => $booking->id, 'groupMember' => $groupMember->id]) }}" method="POST">
                    @csrf
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 gap-4">
                            <div>
                                <input type="hidden" name="group_member_id" id="group_member_id" value="{{ $groupMember->id }}">

                                <label for="day" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Date</label>
                                <input type="date" id="day" name="day" value="{{ now()->format('Y-m-d') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" required>
                            </div>
                            <div>
                                <label for="comment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comment</label>
                                <textarea id="comment" name="comment" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"></textarea>
                            </div>
                            <div>
                                <label for="problem" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Problem</label>
                                <textarea id="problem" name="problem" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"></textarea>
                            </div>
                            <div>
                                <label for="solve" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Solution</label>
                                <textarea id="solve" name="solve" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="button" data-modal-hide="addDailyRecordModal" class="admin-cancel-btn">Bekor qilish</button>
                        <button type="submit" class="admin-add-btn">Add Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
