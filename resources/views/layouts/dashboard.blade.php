@extends('layouts.app')

@section("big-content")
    {{-- Header --}}
    <x-dashboard.include.header/>

    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">

        <x-dashboard.include.sidebar/>
        <x-dashboard.sidebar.backdrop/>
        <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
            <main>
                    {{-- Main Content--}}
                    @yield("content")
                    {{-- end Main Content--}}
            </main>

        </div>
    </div>

@endsection
