<aside id="sidebar"
       class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width"
       aria-label="Sidebar">
    <div class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                <ul class="pb-2 space-y-2">

                    {{-- Daily Report --}}
                    <li>
                        <x-dashboard.sidebar.item path="{{ route('daily-reports.index') }}/"
                                                  content="Daily report"
                                                  :active="request()->routeIs('daily-reports.*')">
                            <x-s-v-g-s.calendar
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.item>
                    </li>

                    {{-- Tours --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Turlar"
                                                              controls='tours'
                                                              :active="request()->routeIs('tours.*', 'tour-categories.*', 'price-lists.*')">
                            <x-s-v-g-s.pages
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="tours"
                                                               :show="request()->routeIs('tours.*', 'tour-categories.*', 'price-lists.*')">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('tours.index') }}"
                                                          content="Turlar"
                                                          :active="request()->routeIs('tours.*')">
                                </x-dashboard.sidebar.item>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('tour-categories.index') }}"
                                                          content="Tur Kategoriyalari"
                                                          :active="request()->routeIs('tour-categories.*')" />
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('price-lists.index') }}"
                                                          content="Narxlar ro'yxati"
                                                          :active="request()->routeIs('price-lists.*')" />
                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>

                    {{-- Bookings --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Buyurtmalar"
                                                              controls='bookings'
                                                              :active="request()->routeIs('bookings.*')">
                            <x-s-v-g-s.calendar
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="bookings"
                                                               :show="request()->routeIs('bookings.*')">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('bookings.index') }}"
                                                          content="Buyurtmalar"
                                                          :active="request()->routeIs('bookings.index') && !request()->has('filter')">
                                </x-dashboard.sidebar.item>

                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('bookings.index',['filter' => 'archive']) }}"
                                                          content="Buyurtmalar arxivi"
                                                          :active="request()->routeIs('bookings.index') && request()->get('filter') === 'archive'">
                                </x-dashboard.sidebar.item>
                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>

                    {{-- Guides --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Gitlar"
                                                              controls='guides'
                                                              :active="request()->routeIs('guides.*', 'guide-categories.*')">
                            <x-s-v-g-s.user-plus
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="guides"
                                                               :show="request()->routeIs('guides.*', 'guide-categories.*')">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('guides.index') }}"
                                                          content="Barcha Gitlar"
                                                          :active="request()->routeIs('guides.index')">
                                </x-dashboard.sidebar.item>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('guide-categories.index') }}"
                                                          content="Git Kategoriyalari"
                                                          :active="request()->routeIs('guide-categories.*')" />
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('guides.calendar') }}"
                                                          content="Kalendar"
                                                          :active="request()->routeIs('guides.calendar')" />
                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>

                    {{-- Companies --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Hamkorlar"
                                                              controls='companies'
                                                              :active="request()->routeIs('partner-types.*', 'partners.*', 'object-items.*')">
                            <x-s-v-g-s.building
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="companies"
                                                               :show="request()->routeIs('partner-types.*', 'partners.*', 'object-items.*')">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('partner-types.index') }}"
                                                          content="Hamkorlar turlari"
                                                          :active="request()->routeIs('partner-types.*')" />
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('partners.index') }}"
                                                          content="Hamkorlar"
                                                          :active="request()->routeIs('partners.index')">
                                </x-dashboard.sidebar.item>

                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('partners.show') }}"
                                                          content="Hamkorlar obyektlari"
                                                          :active="request()->routeIs('partners.show')" />
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('object-items.index') }}"
                                                          content="Hamkor obyekt mahsulotlari"
                                                          :active="request()->routeIs('object-items.*')" />
                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>

                    {{-- Agents --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Agentlar"
                                                              controls='agents'
                                                              :active="request()->routeIs('agents.*')">
                            <x-s-v-g-s.users
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="agents"
                                                               :show="request()->routeIs('agents.*')">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('agents.index') }}"
                                                          content="Barcha Agentlar"
                                                          :active="request()->routeIs('agents.*')">
                                </x-dashboard.sidebar.item>
                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>

                    {{-- Finance --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Moliyaviy amallar"
                                                              controls='finance'
                                                              :active="request()->routeIs('balances.*', 'expenses.*')">
                            <x-s-v-g-s.coins
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="finance"
                                                               :show="request()->routeIs('balances.*', 'expenses.*')">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('balances.index') }}"
                                                          content="Balanslar"
                                                          :active="request()->routeIs('balances.*')">
                                </x-dashboard.sidebar.item>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('expenses.index') }}"
                                                          content="Xarajatlar"
                                                          :active="request()->routeIs('expenses.*')" />
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
                                                          content="Kunlik hisobotlar">
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
                        <x-dashboard.sidebar.drop-down-button content="Vositalar"
                                                              controls='tools'
                                                              :active="request()->routeIs('tools.*')">
                            <x-s-v-g-s.settings-3
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="tools"
                                                               :show="request()->routeIs('tools.*')">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('tools.countries') }}"
                                                          content="Davlatlar"
                                                          :active="request()->routeIs('tools.countries')">
                                </x-dashboard.sidebar.item>

                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('tools.cities.index') }}"
                                                          content="Shaharlar"
                                                          :active="request()->routeIs('tools.cities.*')" />

                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('tools.languages') }}"
                                                          content="Tillar"
                                                          :active="request()->routeIs('tools.languages')" />

                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('tools.currencies') }}"
                                                          content="Valyutalar"
                                                          :active="request()->routeIs('tools.currencies')" />
                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>

                    <li>
                        <x-dashboard.sidebar.item path="{{ route('users.index') }}/"
                                                  content="Foydalanuvchilar"
                                                  :active="request()->routeIs('users.*')">
                            <x-s-v-g-s.users
                                class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.item>
                    </li>

                    {{-- Roles And Permissions --}}
                    <li>
                        <x-dashboard.sidebar.drop-down-button content="Ruxsatlar"
                                                              controls='roles-and-permissions'
                                                              :active="request()->routeIs('roles.*', 'permissions.*')">
                            <x-s-v-g-s.pages
                                class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white" />
                        </x-dashboard.sidebar.drop-down-button>
                        <x-dashboard.sidebar.drop-down-wrapper controls="roles-and-permissions"
                                                               :show="request()->routeIs('roles.*', 'permissions.*')">
                            <li>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('roles.index') }}"
                                                          content="Foydalanuvchi rollari"
                                                          :active="request()->routeIs('roles.index')">
                                </x-dashboard.sidebar.item>
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('permissions.index') }}"
                                                          content="Ruxsatlar"
                                                          :active="request()->routeIs('permissions.*')" />
                                <x-dashboard.sidebar.item class="pl-10"
                                                          path="{{ route('roles.permissions.index') }}"
                                                          content="Ruxsat biriktish"
                                                          :active="request()->routeIs('roles.permissions.*')" />
                            </li>
                        </x-dashboard.sidebar.drop-down-wrapper>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</aside>
