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

                    {{-- Users --}}
                    <li>
                        <x-dashboard.sidebar.item path="{{ route('users.index') }}/"
                                                  content="Foydalanuvchilar" >
                            <x-s-v-g-s.users
                                class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.item>
                    </li>


                    {{-- Rolas And Permissions --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Ruxsatlar" controls='roles-and-permissions'>
                            <x-s-v-g-s.pages
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="roles-and-permissions">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('roles.index') }}"
                                                          content="Foydalanuvchi rollari" >
                                </x-dashboard.sidebar.item>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('permissions.index') }}"
                                                          content="Ruxsatlar" />
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('roles.permissions.index') }}"
                                                          content="Ruxsat biriktish" />

                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>


                    {{-- Daily Report --}}
                    <li>
                        <x-dashboard.sidebar.item path="{{ route('daily-reports.index') }}/"
                                                  content="Daily report" >
                            <x-s-v-g-s.calendar
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.item>
                    </li>

                    {{-- Tours --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Turlar" controls='tours'>
                            <x-s-v-g-s.pages
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="tours">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('tours.index') }}"
                                                          content="Turlar" >
                                </x-dashboard.sidebar.item>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('tour-categories.index') }}"
                                                          content="Tur Kategoriyalari" />
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('price-lists.index') }}"
                                                          content="Narxlar ro'yxati" />
                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>

                    {{-- Bookings --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Buyurtmalar" controls='bookings'>
                            <x-s-v-g-s.calendar
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="bookings">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('bookings.index') }}"
                                                          content="Buyurtmalar" >
                                </x-dashboard.sidebar.item>

                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('bookings.index',['filter' => 'archive']) }}"
                                                          content="Buyurtmalar arxivi" >
                                </x-dashboard.sidebar.item>
                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>

                    {{-- Guides --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Gitlar" controls='guides'>
                            <x-s-v-g-s.user-plus
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="guides">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('guides.index') }}"
                                                          content="Barcha Gitlar" >
                                </x-dashboard.sidebar.item>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('guide-categories.index') }}"
                                                          content="Git Kategoriyalari" />
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('guides.calendar') }}"
                                                          content="Kalendar" />
                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>

                    {{-- Companies --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Hamkorlar" controls='companies'>
                            <x-s-v-g-s.building
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="companies">
                            <li>

                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('partner-types.index') }}"
                                                          content="Hamkorlar turlari" />
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('partners.index') }}"
                                                          content="Hamkorlar" >
                                </x-dashboard.sidebar.item>

                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('partners.show') }}"
                                                          content="Hamkorlar obyektlari" />
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('object-items.index') }}"
                                                          content="Hamkor obyekt mahsulotlari" />
                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>

                    {{-- Agents --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Agentlar" controls='agents'>
                            <x-s-v-g-s.users
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="agents">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('agents.index') }}"
                                                          content="Barcha Agentlar" >
                                </x-dashboard.sidebar.item>
{{--                                <x-dashboard.sidebar.item class="pl-10"--}}
{{--                                                          path=""--}}
{{--                                                          content="Agent buyurtmalari" />--}}
                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>

                    {{-- Finance --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Moliyaviy amallar" controls='finance'>
                            <x-s-v-g-s.coins
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="finance">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('balances.index') }}"
                                                          content="Balanslar" >
                                </x-dashboard.sidebar.item>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('expenses.index') }}"
                                                          content="Xarajatlar" />
{{--                                <x-dashboard.sidebar.item class="pl-10"--}}
{{--                                                          path=""--}}
{{--                                                          content="To'lov tarixi" />--}}
{{--                                <x-dashboard.sidebar.item class="pl-10"--}}
{{--                                                          path=""--}}
{{--                                                          content="Buyurtma harajatlari" />--}}
                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>

                    {{-- Reports --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Hisobotlar" controls='reports'>
                            <x-s-v-g-s.clipboard
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="reports">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path=""
                                                          content="Kunlik hisobotlar" >
                                </x-dashboard.sidebar.item>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path=""
                                                          content="Moliyaviy hisobotlar" />
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path=""
                                                          content="Turlar hisoboti" />
                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>

                    {{-- Settings --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Vositalar" controls='tools'>
                            <x-s-v-g-s.settings-3
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="tools">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('tools.countries') }}"
                                                          content="Davlatlar" >
                                </x-dashboard.sidebar.item>

                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('tools.cities.index') }}"
                                                          content="Shaharlar" />

                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('tools.languages') }}"
                                                          content="Tillar" />

                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('tools.currencies') }}"
                                                          content="Valyutalar" />
                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>




                </ul>
{{--                <div class="pt-2 space-y-2">--}}

{{--                    --}}{{-- Components --}}
{{--                    <x-dashboard.sidebar.item path="https://flowbite.com/docs/components/alerts/" content="Components">--}}
{{--                        <x-s-v-g-s.components/>--}}
{{--                    </x-dashboard.sidebar.item>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</aside>


