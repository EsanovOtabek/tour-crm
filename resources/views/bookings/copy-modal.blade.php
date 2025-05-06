@extends('layouts.dashboard')
@section('title', "Buyurtma Nusxalash")
@section('description', "Mavjud shablon yoki buyurtmadan nusxa olish")

@section('content')
<div class="px-4 pt-6 min-h-screen">
    <div class="p-4 rounded-lg shadow-sm sm:p-6">
        <!-- Modal header -->
        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                Buyurtma nusxalash
            </h3>
            <button type="button" onclick="window.history.back()" class="admin-close-modal-btn">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
                <span class="sr-only">Yopish</span>
            </button>
        </div>

        <!-- Tabs -->
        <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px" id="copyTabs" role="tablist">
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="templates-tab" data-tabs-target="#templates" type="button" role="tab" aria-controls="templates" aria-selected="true">Shablonlardan</button>
                </li>
                <li class="mr-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300" id="bookings-tab" data-tabs-target="#bookings" type="button" role="tab" aria-controls="bookings" aria-selected="false">Buyurtmalardan</button>
                </li>
            </ul>
        </div>

        <!-- Tab contents -->
        <div id="copyTabsContent">
            <!-- Templates tab -->
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="templates" role="tabpanel" aria-labelledby="templates-tab">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-primary-200 dark:bg-primary-900 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">ID</th>
                                <th scope="col" class="py-3 px-6">Tur</th>
                                <th scope="col" class="py-3 px-6">Holat</th>
                                <th scope="col" class="py-3 px-6">Narx</th>
                                <th scope="col" class="py-3 px-6">Amallar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($templates as $template)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="py-4 px-6">{{ $template->id }}</td>
                                <td class="py-4 px-6">{{ $template->tour->name ?? 'Tur yo\'q' }}</td>
                                <td class="py-4 px-6">{{ ucfirst($template->status) }}</td>
                                <td class="py-4 px-6">{{ number_format($template->price, 2) }}</td>
                                <td class="py-4 px-6">
                                    <a href="{{ route('bookings.copy.from.template', $template) }}" class="admin-edit-btn">Nusxalash</a>
                                </td>
                            </tr>
                            @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="5" class="py-4 px-6 text-center">Shablonlar topilmadi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Bookings tab -->
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="bookings" role="tabpanel" aria-labelledby="bookings-tab">
                <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-primary-200 dark:bg-primary-900 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="py-3 px-6">ID</th>
                                <th scope="col" class="py-3 px-6">Tur</th>
                                <th scope="col" class="py-3 px-6">Holat</th>
                                <th scope="col" class="py-3 px-6">Narx</th>
                                <th scope="col" class="py-3 px-6">Amallar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentBookings as $booking)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="py-4 px-6">{{ $booking->id }}</td>
                                <td class="py-4 px-6">{{ $booking->tour->name ?? 'Tur yo\'q' }}</td>
                                <td class="py-4 px-6">{{ ucfirst($booking->status) }}</td>
                                <td class="py-4 px-6">{{ number_format($booking->price, 2) }}</td>
                                <td class="py-4 px-6">
                                    <a href="{{ route('bookings.copy.from.booking', $booking) }}" class="admin-edit-btn">Nusxalash</a>
                                </td>
                            </tr>
                            @empty
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <td colspan="5" class="py-4 px-6 text-center">Buyurtmalar topilmadi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switcher
        const tabs = document.querySelectorAll('[data-tabs-target]');
        tabs.forEach(tab => {
            tab.addEventListener('click', function() {
                const target = document.querySelector(this.dataset.tabsTarget);
                document.querySelectorAll('[role="tabpanel"]').forEach(panel => {
                    panel.classList.add('hidden');
                });
                target.classList.remove('hidden');

                // Update active tab styling
                document.querySelectorAll('[role="tab"]').forEach(t => {
                    t.classList.remove('border-blue-600', 'text-blue-600', 'dark:text-blue-500', 'dark:border-blue-500');
                    t.classList.add('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300', 'dark:hover:text-gray-300');
                });

                this.classList.remove('border-transparent', 'hover:text-gray-600', 'hover:border-gray-300', 'dark:hover:text-gray-300');
                this.classList.add('border-blue-600', 'text-blue-600', 'dark:text-blue-500', 'dark:border-blue-500');
            });
        });

        // Activate first tab by default
        if (tabs.length > 0) {
            tabs[0].click();
        }
    });
</script>
@endpush
