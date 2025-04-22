@extends('layouts.dashboard')
@section('title', "Agents Management")
@section('description', "Manage system agents")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <!-- Card header -->
            <div class="items-center justify-between lg:flex">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Agents Management</h3>
                </div>
                <div class="items-center sm:flex">
                    <button data-modal-target="createAgentModal" data-modal-toggle="createAgentModal" class="admin-add-btn" type="button">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                        </svg>
                        Add new agent
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
                                    <th scope="col" class="p-4 text-xs font-bold tracking-wider text-left text-gray-700 uppercase dark:text-white">
                                        ID
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-bold tracking-wider text-left text-gray-700 uppercase dark:text-white">
                                        Name
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-bold tracking-wider text-left text-gray-700 uppercase dark:text-white">
                                        Email
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-bold tracking-wider text-left text-gray-700 uppercase dark:text-white">
                                        Balance
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-bold tracking-wider text-left text-gray-700 uppercase dark:text-white">
                                        Contact Details
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-bold tracking-wider text-left text-gray-700 uppercase dark:text-white">
                                        Created At
                                    </th>
                                    <th scope="col" class="p-4 text-xs font-bold tracking-wider text-left text-gray-700 uppercase dark:text-white">
                                        Actions
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800">
                                @foreach($agents as $agent)
                                    <tr class="border">
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $agent->name }}
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-gray-400">
                                            {{ $agent->email }}
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-gray-400">
                                            {{ number_format($agent->balance, 2) }}
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-gray-400">
                                            {{ $agent->contact_details }}
                                        </td>
                                        <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-gray-400">
                                            {{ $agent->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="p-4 space-x-2 whitespace-nowrap">
                                            <button type="button" data-modal-target="editAgentModal-{{ $agent->id }}" data-modal-toggle="editAgentModal-{{ $agent->id }}" class="admin-edit-btn">
                                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path>
                                                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path>
                                                </svg>
                                                Edit
                                            </button>
                                            <a href="{{ route('agents.show', $agent->id) }}" class="admin-view-btn">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                View
                                            </a>
                                        </td>
                                    </tr>

                                    <!-- Edit Agent Modal -->
                                    <div id="editAgentModal-{{ $agent->id }}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
                                        <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
                                            <!-- Modal content -->
                                            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                                                <!-- Modal header -->
                                                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                                        Edit Agent
                                                    </h3>
                                                    <button type="button" class="admin-close-modal-btn" data-modal-hide="editAgentModal-{{ $agent->id }}">
                                                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="sr-only">Close modal</span>
                                                    </button>
                                                </div>
                                                <!-- Modal body -->
                                                <form action="{{ route('agents.update', $agent->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')

                                                    <div class="grid gap-4 mb-4 sm:grid-cols-1">
                                                        <div>
                                                            <label for="name-{{ $agent->id }}" class="e-label">Name</label>
                                                            <input type="text" name="name" id="name-{{ $agent->id }}" value="{{ $agent->name }}" class="e-input" placeholder="Agent name" required>
                                                        </div>
                                                        <div>
                                                            <label for="email-{{ $agent->id }}" class="e-label">Email</label>
                                                            <input type="email" name="email" id="email-{{ $agent->id }}" value="{{ $agent->email }}" class="e-input" placeholder="agent@example.com" required>
                                                        </div>
                                                        <div>
                                                            <label for="contact_details-{{ $agent->id }}" class="e-label">Contact Details</label>
                                                            <textarea  name="contact_details" id="contact_details-{{ $agent->id }}" class="e-input" placeholder="Phone, address, etc.">{{ $agent->contact_details }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center space-x-4">
                                                        <button type="submit" class="admin-add-btn">
                                                            Update agent
                                                        </button>
                                                        <button type="button" data-modal-hide="editAgentModal-{{ $agent->id }}" class="admin-cancel-btn">
                                                            Cancel
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
                    @if($agents->onFirstPage())
                        <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">Previous</span>
                    @else
                        <a href="{{ $agents->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Previous</a>
                    @endif

                    @if($agents->hasMorePages())
                        <a href="{{ $agents->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">Next</a>
                    @else
                        <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-md">Next</span>
                    @endif
                </div>
                <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                    <div>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            Showing
                            <span class="font-medium">{{ $agents->firstItem() ?? 0 }}</span>
                            to
                            <span class="font-medium">{{ $agents->lastItem() ?? 0 }}</span>
                            of
                            <span class="font-medium">{{ $agents->total() }}</span>
                            results
                        </p>
                    </div>
                    <div>
                        <nav class="relative z-0 inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                            {{ $agents->links() }}
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Agent Modal -->
    <div id="createAgentModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
        <div class="relative p-4 w-full max-w-lg h-full md:h-auto">
            <!-- Modal content -->
            <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                <!-- Modal header -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Add New Agent
                    </h3>
                    <button type="button" class="admin-close-modal-btn" data-modal-hide="createAgentModal">
                        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('agents.store') }}" method="POST">
                    @csrf
                    <div class="grid gap-4 mb-4 sm:grid-cols-1">
                        <div>
                            <label for="create-name" class="e-label">Name</label>
                            <input type="text" name="name" id="create-name" class="e-input" placeholder="Agent name" required>
                        </div>
                        <div>
                            <label for="create-email" class="e-label">Email</label>
                            <input type="email" name="email" id="create-email" class="e-input" placeholder="agent@example.com" required>
                        </div>
                        <div>
                            <label for="create-balance" class="e-label">Balance</label>
                            <input type="number" step="0.01" name="balance" id="create-balance" class="e-input" placeholder="0.00">
                        </div>
                        <div>
                            <label for="create-contact-details" class="e-label">Contact Details</label>
                            <textarea name="contact_details" id="create-contact-details" class="e-input" placeholder="Phone, address, etc."></textarea>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button type="submit" class="admin-add-btn">
                            Add new agent
                        </button>
                        <button type="button" data-modal-hide="createAgentModal" class="admin-cancel-btn">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
