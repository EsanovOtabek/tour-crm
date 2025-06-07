<nav class="fixed z-30 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">

                <x-dashboard.header.sidebar-toggler-button/>

                {{-- Yangi desktop hamburger menu --}}
                <button type="button"
                        class="hidden lg:inline-flex items-center p-2 ml-3 text-sm text-gray-500 rounded-lg hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        id="sidebar-toggle-desktop"
                        aria-label="Toggle sidebar">
                    <span class="sr-only">Toggle sidebar</span>
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                </button>


                <x-dashboard.header.logo/>

            </div>
            <div class="flex items-center">
                <!-- Search mobile -->
                <x-dashboard.header.mobile-search/>
                <!-- Notifications -->
                {{-- <x-dashboard.header.notification-button/>--}}
                <!-- Dropdown menu -->
                {{-- <x-dashboard.header.notification-drop-down/>--}}
                <!-- Apps -->
                <x-dashboard.header.apps-button/>
                <!-- Dropdown menu -->
                <x-dashboard.header.apps-drop-down/>

                <x-dashboard.header.dark-white-mode-toggler/>

                <!-- Profile -->
                <div class="flex items-center ml-3">
                    <x-dashboard.header.user-menu-avatar/>
                    <!-- Dropdown menu -->
                    <x-dashboard.header.user-menu-drop-down/>
                </div>
            </div>
        </div>
    </div>
</nav>
