<aside id="sidebar"
       class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width"
       aria-label="Sidebar">
    <div class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                <ul class="pb-2 space-y-2">

                    {{-- dashboard --}}
                    <li>
                        <x-dashboard.sidebar.item path="{{ route('dashboard') }}" class="items-start" >
                            <x-s-v-g-s.dashboard class="w-6 h-6" />
                        </x-dashboard.sidebar.item>
                    </li>


                    {{-- Settings --}}
                    <li>
                        <x-dashboard.sidebar.item path="{{ route('profile.edit') }}/"
                                                  content="Settings" >
                            <x-s-v-g-s.settings-3
                                class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.item>
                    </li>

                    {{-- Settings --}}
                    <li>
                        <x-dashboard.sidebar.item path="/"
                                                  content="News" >
                            <x-s-v-g-s.comment
                                class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.item>
                    </li>

                    {{-- Courses dropdown --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Courses" controls='courses'>
                            <x-s-v-g-s.pages
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="courses">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path=""
                                                          content="Kurslar" >
                                </x-dashboard.sidebar.item>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path=""
                                                          content="Kurs qo'shish +" />

                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>

                </ul>
                <div class="pt-2 space-y-2">

                    {{-- Components --}}
                    <x-dashboard.sidebar.item path="https://flowbite.com/docs/components/alerts/" content="Components">
                        <x-s-v-g-s.components/>
                    </x-dashboard.sidebar.item>
                </div>
            </div>
        </div>
    </div>
</aside>


