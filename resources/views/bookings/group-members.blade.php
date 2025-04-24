@extends('layouts.dashboard')
@section('title', "Group Members Management")
@section('description', "Manage group members for booking")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 rounded-lg shadow-sm sm:p-6">
            <!-- Booking Info Card (Horizontal) -->
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-6">
                <div class="p-5 flex flex-col md:flex-row md:items-center md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h5 class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Buyurtma #{{ $booking->id }} - {{ $booking->tour->name ?? 'No Tour' }}
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
                            <p><span class="font-semibold">Davomiyligi:</span>
                                {{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}
                            </p>
                            <p><span class="font-semibold">Jami summa:</span> ${{ number_format($booking->total_amount, 2) }}</p>
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
            <hr class="mb-3">
            <!-- Card header -->
            <div class="items-center justify-between lg:flex mb-6 ">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Group Members</h3>
{{--                    <p class="text-gray-600 dark:text-gray-400">Manage members for this booking</p>--}}
                </div>
                <div class="items-center sm:flex">
                    <button data-modal-target="createMemberModal" data-modal-toggle="createMemberModal" class="admin-add-btn" type="button">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Qo'shish
                    </button>
                </div>
            </div>

            <!-- Members Table -->
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-primary-200 dark:bg-primary-900 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="py-3 px-6">&num;</th>
                        <th scope="col" class="py-3 px-6">Surname</th>
                        <th scope="col" class="py-3 px-6">Nomi</th>
                        <th scope="col" class="py-3 px-6">Passport</th>
                        <th scope="col" class="py-3 px-6">Contact</th>
                        <th scope="col" class="py-3 px-6">Status</th>
                        <th scope="col" class="py-3 px-6">Agent</th>
                        <th scope="col" class="py-3 px-6 text-right">Amallar</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($booking->groupMembers as $member)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="py-4 px-6">
                                {{ $loop->index + 1 }}
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-medium text-gray-900 dark:text-white">
                                    {{ $member->surname }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <div class="font-medium text-gray-900 dark:text-white">
                                    {{ $member->name }}
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                {{ $member->passport_number }}
                            </td>
                            <td class="py-4 px-6">
                                @if($member->email)
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                            <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                        </svg>
                                        {{ $member->email }}
                                    </div>
                                @endif
                                @if($member->phone)
                                    <div class="flex items-center mt-1">
                                        <svg class="w-4 h-4 mr-1 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                        </svg>
                                        {{ $member->phone }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($member->status)
                                    <span class="bg-{{
                                        $member->status == 'active' ? 'green' :
                                        ($member->status == 'cancelled' ? 'red' : 'yellow')
                                    }}-100 text-{{
                                        $member->status == 'active' ? 'green' :
                                        ($member->status == 'cancelled' ? 'red' : 'yellow')
                                    }}-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-{{
                                        $member->status == 'active' ? 'green' :
                                        ($member->status == 'cancelled' ? 'red' : 'yellow')
                                    }}-200 dark:text-{{
                                        $member->status == 'active' ? 'green' :
                                        ($member->status == 'cancelled' ? 'red' : 'yellow')
                                    }}-800">
                                        {{ ucfirst($member->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                @if($member->agent)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">{{ $member->agent->name }} </span>
                                @else
                                    <span class="text-gray-500 dark:text-gray-400">No agent</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{route('bookings.group-members.show', [$booking->id, $member->id])}}" class="admin-add-btn ">
                                    View
                                </a>
                                <button data-modal-target="editMemberModal-{{ $member->id }}" data-modal-toggle="editMemberModal-{{ $member->id }}" class="admin-edit-btn">
                                    Tahrirlash
                                </button>
                                <button data-modal-target="deleteMemberModal-{{ $member->id }}" data-modal-toggle="deleteMemberModal-{{ $member->id }}" class="admin-delete-btn">
                                    Remove
                                </button>
                            </td>
                        </tr>

                        <!-- Edit Member Modal -->
                        <div id="editMemberModal-{{ $member->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                            Edit Group Member
                                        </h3>
                                        <button type="button" class="admin-close-modal-btn" data-modal-hide="editMemberModal-{{ $member->id }}">
                                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="sr-only">Close modal</span>
                                        </button>
                                    </div>
                                    <form action="{{ route('bookings.group-members.index', $booking->id) }}/{{ $member->id }}" method="POST">
                                        @csrf
                                        @method('PUT') <!-- yoki PATCH -->
                                        <div class="grid gap-4 mb-4">
                                            <div>
                                                <label for="edit-agent-{{ $member->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Agent</label>
                                                <select name="agent_id" required id="edit-agent-{{ $member->id }}" class="e-input">
                                                    <option value="" >Agentni tanlash</option>
                                                    @foreach($agents as $agent)
                                                        <option value="{{ $agent->id }}" {{ $member->agent_id == $agent->id ? 'selected' : '' }}>{{ $agent->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label for="edit-surname-{{ $member->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Surname</label>
                                                    <input type="text" name="surname" id="edit-surname-{{ $member->id }}" value="{{ $member->surname }}" class="e-input" required>
                                                </div>
                                                <div>
                                                    <label for="edit-name-{{ $member->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomi</label>
                                                    <input type="text" name="name" id="edit-name-{{ $member->id }}" value="{{ $member->name }}" class="e-input" required>
                                                </div>
                                            </div>
                                            <div>
                                                <label for="edit-passport-{{ $member->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Passport Number</label>
                                                <input type="text" name="passport_number" id="edit-passport-{{ $member->id }}" value="{{ $member->passport_number }}" class="e-input" required>
                                            </div>
                                            <div>
                                                <label for="edit-email-{{ $member->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                                <input type="email" name="email" id="edit-email-{{ $member->id }}" value="{{ $member->email }}" class="e-input">
                                            </div>
                                            <div>
                                                <label for="edit-phone-{{ $member->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                                                <input type="text" name="phone" id="edit-phone-{{ $member->id }}" value="{{ $member->phone }}" class="e-input">
                                            </div>
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label for="edit-telegram-{{ $member->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telegram</label>
                                                    <input type="text" name="telegram" id="edit-telegram-{{ $member->id }}" value="{{ $member->telegram }}" class="e-input">
                                                </div>
                                                <div>
                                                    <label for="edit-whatsapp-{{ $member->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">WhatsApp</label>
                                                    <input type="text" name="whatsapp" id="edit-whatsapp-{{ $member->id }}" value="{{ $member->whatsapp }}" class="e-input">
                                                </div>
                                            </div>
                                            <div>
                                                <label for="edit-status-{{ $member->id }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                                                <select name="status" id="edit-status-{{ $member->id }}" class="e-input">
                                                    <option value="">Select Status</option>
                                                    @foreach(App\Models\GroupMember::statusOptions() as $value => $label)
                                                        <option value="{{ $value }}" {{ $member->status == $value ? 'selected' : '' }}>{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-4">
                                            <button type="submit" class="admin-add-btn">
                                                Yangilash
                                            </button>
                                            <button type="button" data-modal-hide="editMemberModal-{{ $member->id }}" class="admin-cancel-btn">
                                                Bekor qilish
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Delete Member Modal -->
                        <div id="deleteMemberModal-{{ $member->id }}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                            <div class="relative p-4 w-full max-w-md h-full md:h-auto">
                                <div class="relative p-4 text-center bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                    <button type="button" class="text-gray-400 absolute top-2.5 right-2.5 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="deleteMemberModal-{{ $member->id }}">
                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                    <svg class="text-gray-400 dark:text-gray-500 w-11 h-11 mb-3.5 mx-auto" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="mb-4 text-gray-500 dark:text-gray-300">Are you sure you want to remove {{ $member->name }} from this booking?</p>
                                    <div class="flex justify-center items-center space-x-4">
                                        <form action="{{ route('bookings.group-members.index', [$booking->id]) }}/{{ $member->id }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="py-2 px-3 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-900">
                                                Ha , o'chirish
                                            </button>
                                        </form>
                                        <button data-modal-toggle="deleteMemberModal-{{ $member->id }}" type="button" class="py-2 px-3 text-sm font-medium text-gray-500 bg-white rounded-lg border border-gray-200 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-primary-300 hover:text-gray-900 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                                            No, Bekor qilish
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td colspan="5" class="py-4 px-6 text-center text-gray-500 dark:text-gray-400">
                                Hali odamlar biriktirilmagan.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create Member Modal -->
    <div id="createMemberModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-md h-full md:h-auto">
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Yangi odam qo'shish
                    </h3>
                    <button type="button" class="admin-close-modal-btn" data-modal-hide="createMemberModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <form action="{{ route('bookings.group-members.store', $booking->id) }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4">
                        <div>
                            <label for="create-agent" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Agent</label>
                            <select name="agent_id" required id="create-agent" class="e-input">
                                <option value="">Agentni tanlash</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="create-surname" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Surname</label>
                                <input type="text" name="surname" id="create-surname" class="e-input" required>
                            </div>
                            <div>
                                <label for="create-name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomi</label>
                                <input type="text" name="name" id="create-name" class="e-input" required>
                            </div>
                        </div>
                        <div>
                            <label for="create-passport" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Passport Number</label>
                            <input type="text" name="passport_number" id="create-passport" class="e-input" required>
                        </div>
                        <div>
                            <label for="create-email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" name="email" id="create-email" class="e-input">
                        </div>
                        <div>
                            <label for="create-phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone</label>
                            <input type="text" name="phone" id="create-phone" class="e-input">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="create-telegram" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telegram</label>
                                <input type="text" name="telegram" id="create-telegram" class="e-input">
                            </div>
                            <div>
                                <label for="create-whatsapp" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">WhatsApp</label>
                                <input type="text" name="whatsapp" id="create-whatsapp" class="e-input">
                            </div>
                        </div>
                        <div>
                            <label for="create-status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Status</label>
                            <select name="status" id="create-status" class="e-input">
                                <option value="">Statusni tanlash</option>
                                @foreach(App\Models\GroupMember::statusOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="admin-add-btn">
                            Saqlash
                        </button>
                        <button type="button" data-modal-hide="createMemberModal" class="admin-cancel-btn">
                            Bekor qilish
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
