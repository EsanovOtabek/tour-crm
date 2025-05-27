@extends('layouts.dashboard')
@section('title', "Tour Templates - {$tour->name}")
@section('description', "Manage templates for {$tour->name}")

@section('content')
    <div class="px-4 pt-6 min-h-screen">
        <div class="p-4 rounded-lg shadow-sm sm:p-6 bg-white dark:bg-gray-800">
            <div class="items-center justify-between lg:flex">
                <div class="mb-4 lg:mb-0">
                    <h3 class="mb-2 text-xl font-bold text-gray-900 dark:text-white">
                        Templates for {{ $tour->name }}
                    </h3>
                    <p class="text-gray-500 dark:text-gray-400">
                        Day quantity:<b> {{ $tour->day_quantity }} days</b>
                    </p>
                    <p class="text-gray-500 dark:text-gray-400">
                        Unique CODE:<b> {{ $tour->{'unique-code'} }} </b>
                    </p>
                    <p class="text-gray-500 dark:text-gray-400">
                        Tour Category:<b> {{ $tour->category->name }} </b>
                    </p>
                </div>

            </div>

        </div>
    </div>

    <!-- Create Template Modal -->
@endsection
