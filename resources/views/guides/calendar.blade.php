@extends('layouts.dashboard')
@section('title', "Gidlar Kalendari")
@section('description', "Gidlarning band/bo'sh kunlari")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 rounded-lg shadow-sm sm:p-6 bg-white dark:bg-gray-800">
            <!-- Calendar Header -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Gidlar Kalendari - {{ $currentMonth->translatedFormat('F Y') }}
                </h2>

                <div class="flex items-center gap-2">
                    <!-- Month/Year Selector -->
                    <div class="flex items-center gap-2">
                        <form method="GET" action="{{ route('guides.calendar') }}" class="flex items-center gap-2">
                            <select name="month" onchange="this.form.submit()"
                                    class="text-sm rounded-lg bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white">
                                @foreach($monthOptions as $value => $name)
                                    <option value="{{ $value }}" {{ $currentMonth->month == $value ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>

                            <select name="year" onchange="this.form.submit()"
                                    class="text-sm rounded-lg bg-gray-100 dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white">
                                @foreach($yearOptions as $year)
                                    <option value="{{ $year }}" {{ $currentMonth->year == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex items-center gap-1">
                        <a href="{{ route('guides.calendar', ['month' => $prevMonth->month, 'year' => $prevMonth->year]) }}"
                           class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>

                        <a href="{{ route('guides.calendar', ['month' => now()->month, 'year' => now()->year]) }}"
                           class="px-3 py-2 text-sm rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-600">
                            This Month
                        </a>

                        <a href="{{ route('guides.calendar', ['month' => $nextMonth->month, 'year' => $nextMonth->year]) }}"
                           class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="overflow-x-auto">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300 dark:divide-gray-600">
                            <!-- Days Header -->
                            <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-white">Gid</th>
                                @php
                                    $firstDay = $currentMonth->copy()->startOfMonth();
                                    $daysInMonth = $currentMonth->daysInMonth;
                                @endphp

                                @for($i = 0; $i < $daysInMonth; $i++)
                                    @php
                                        $day = $firstDay->copy()->addDays($i);
                                    @endphp
                                    <th scope="col" class="px-2 py-3.5 text-center text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ $day->translatedFormat('D') }}<br>
                                        <span class="font-normal">{{ $day->day }}</span>
                                    </th>
                                @endfor
                            </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            @foreach($guides as $guide)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-white">
                                        <div class="flex items-center">
                                            <!-- Status indicator based on guide's status field -->
                                            <div class="h-4 w-4 rounded-full mr-2
                {{ $guide->status === 'green' ? 'bg-green-500' :
                   ($guide->status === 'yellow' ? 'bg-yellow-500' : 'bg-red-500') }}"></div>
                                            {{ $guide->name }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $guide->tour_city->name ?? 'Shahar yo\'q' }}
                                            @if($guide->price)
                                                • {{ number_format($guide->price) }} {{ $guide->currency->code ?? '' }}
                                            @endif
                                        </div>
                                    </td>

                                    @foreach($guide->calendarDays as $day)
                                        <td class="whitespace-nowrap px-2 py-4 text-sm text-center border">

                                            <div x-data="{ open: false }" class="relative">
                                                <div class="h-8 w-8 mx-auto flex items-center justify-center rounded-full
                    {{ $day['is_booked'] ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' :
                       'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' }}"
                                                     @mouseenter="open = true" @mouseleave="open = false">
                                                </div>

                                                @if($day['is_booked'])
                                                    <div x-show="open" x-transition
                                                         class="absolute z-10 left-1/2 transform -translate-x-1/2 mt-2 w-48 p-2 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700">
                                                        <div class="text-xs font-semibold text-gray-900 dark:text-white mb-1">
                                                            Band:
                                                        </div>
                                                        @foreach($day['bookings'] as $booking)
                                                            <div class="text-xs text-gray-600 dark:text-gray-300">
                                                                {{ $booking->booking->unique_code ?? 'N/A' }}
                                                                ({{ $booking->start_date->format('d.m') }}-{{ $booking->end_date->format('d.m') }})
                                                            </div>
                                                            @if($booking->tourCity)
                                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                                    {{ $booking->tourCity->name }}
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Legend -->
            <div class="mt-6 flex flex-wrap items-center justify-center gap-4">
                <div class="flex items-center">
                    <div class="h-4 w-4 rounded-full bg-green-500 mr-2"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-300">Bo'sh</span>
                </div>
                <div class="flex items-center">
                    <div class="h-4 w-4 rounded-full bg-red-500 mr-2"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-300">Band</span>
                </div>
                <div class="flex items-center">
                    <div class="h-4 w-4 rounded-full bg-yellow-500 mr-2"></div>
                    <span class="text-sm text-gray-600 dark:text-gray-300">Kutilmoqda</span>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endpush
