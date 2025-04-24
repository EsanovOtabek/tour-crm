@extends('layouts.dashboard')
@section('title', "Tillar ro'yxati")
@section('description', "Tillar ro'yxati")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 sm:p-6 dark:bg-gray-800">
            <!-- Header -->
            <div class="mb-4">
                <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">Tillar ro'yxati</h3>
                <span class="text-base font-normal text-gray-500 dark:text-gray-400">Barcha Tillar ro'yxati</span>
            </div>

            <!-- Table -->
            <div class="flex flex-col mt-6">
                <div class="overflow-x-auto rounded-lg">
                    <div class="inline-block min-w-full align-middle">
                        <table id="languagesTable" class="display min-w-full">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nomi</th>
                                <th>Code</th>
                                <th>Direction</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($languages as $language)
                                <tr>
                                    <td>{{ $language->id }}</td>
                                    <td>{{ $language->name }}</td>
                                    <td>{{ $language->code }}</td>
                                    <td>
                                            <span class="px-2 py-1 text-xs font-medium rounded-full {{ $language->dir === 'rtl' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}">
                                                {{ strtoupper($language->dir) }}
                                            </span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        /* Custom styles for dark mode compatibility */
        .dark .dataTables_wrapper .dataTables_length,
        .dark .dataTables_wrapper .dataTables_filter,
        .dark .dataTables_wrapper .dataTables_info,
        .dark .dataTables_wrapper .dataTables_processing,
        .dark .dataTables_wrapper .dataTables_paginate {
            color: #f3f4f6;
        }

        .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #f3f4f6 !important;
        }

        .dark .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dark .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            color: #111827 !important;
        }

        .dark table.dataTable tbody tr {
            background-color: #1f2937;
            color: #f3f4f6;
        }

        .dark table.dataTable.stripe tbody tr.odd {
            background-color: #111827;
        }

        .dark table.dataTable.hover tbody tr:hover,
        .dark table.dataTable.hover tbody tr.odd:hover {
            background-color: #374151;
        }

        .dark .dataTables_wrapper .dataTables_length select,
        .dark .dataTables_wrapper .dataTables_filter input {
            background-color: #374151;
            border-color: #4b5563;
            color: #f3f4f6;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#languagesTable').DataTable({
                responsive: true,
                paging: true,
                searching: true,
                ordering: true,
                info: true,
                lengthChange: true,
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    zeroRecords: "No matching records found",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });
        });
    </script>
@endpush
