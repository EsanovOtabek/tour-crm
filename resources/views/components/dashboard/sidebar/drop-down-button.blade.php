{{--
Controls proparty must be passed to this component to make every button dropdown sperated from other dropdows buttons
same component controls prop must be passed to the dropdown related to the button
component name (drop-down-warapper) the controls prop can be string like the name button
ex:

<x-dashboard.sidebar.drop-down-button content="CRUD" :controls="2">
    your content...
</x-dashboard.sidebar.drop-down-button>

<x-dashboard.sidebar.drop-down-wrapper :controls="2">
    drop down list items...
</x-dashboard.sidebar.drop-down-wrapper>

--}}


@props(['content' => '', 'controls' => '', 'active' => false])

<button type="button"
        class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700
               {{ $active ? 'bg-gray-100 dark:bg-gray-700 text-blue-600 dark:text-blue-400' : '' }}"
        aria-controls="{{ $controls }}"
        data-collapse-toggle="{{ $controls }}">
    {{ $slot }}
    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>{{ $content }}</span>
    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
    </svg>
</button>
