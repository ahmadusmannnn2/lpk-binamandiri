<nav x-data="{ open: false }" class="bg-hitam border-b border-oranye">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}">
                        <h1
                            class="text-2xl font-bold text-white tracking-widest hover:text-oranye transition duration-300">
                            LPK<span class="text-oranye">BINA</span></h1>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')"
                        class="text-white hover:text-oranye focus:text-oranye {{ request()->routeIs('admin.dashboard') ? 'border-oranye text-oranye' : 'border-transparent' }}">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-oranye focus:outline-none transition ease-in-out duration-150">
                                    <div
                                        class="{{ request()->routeIs('admin.program.*') || request()->routeIs('admin.instruktur.*') ? 'text-oranye' : '' }}">
                                        Data Master</div>
                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('admin.program.index')"
                                    class="hover:bg-oranye hover:text-white">{{ __('Program Pelatihan') }}</x-dropdown-link>

                                <x-dropdown-link :href="route('admin.instruktur.index')"
                                    class="hover:bg-oranye hover:text-white">{{ __('Instruktur') }}</x-dropdown-link>

                                <x-dropdown-link :href="route('admin.peserta.index')"
                                    class="hover:bg-oranye hover:text-white">{{ __('Peserta') }}</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.kelas.index')"
                                    class="hover:bg-oranye hover:text-white">{{ __('Kelas') }}</x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <x-nav-link :href="route('admin.verifikasi.index')"
                        :active="request()->routeIs('admin.verifikasi.*')"
                        class="text-white hover:text-oranye focus:text-oranye {{ request()->routeIs('admin.verifikasi.*') ? 'border-oranye text-oranye' : 'border-transparent' }}">
                        {{ __('Verifikasi') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.laporan.index')" :active="request()->routeIs('admin.laporan.*')"
                        class="text-white hover:text-oranye focus:text-oranye {{ request()->routeIs('admin.laporan.*') ? 'border-oranye text-oranye' : 'border-transparent' }}">
                        {{ __('Laporan') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.pengaturan.index')"
                        :active="request()->routeIs('admin.pengaturan.*')"
                        class="text-white hover:text-oranye focus:text-oranye {{ request()->routeIs('admin.pengaturan.*') ? 'border-oranye text-oranye' : 'border-transparent' }}">
                        {{ __('Pengaturan Web') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-oranye focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }} (Admin)</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-oranye hover:text-white">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="hover:bg-oranye hover:text-white">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-oranye hover:bg-gray-800 focus:outline-none focus:bg-gray-800 focus:text-oranye transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-hitam border-t border-oranye">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')"
                class="text-white hover:text-oranye">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            <div class="px-4 py-2 text-xs text-gray-400 uppercase tracking-widest">Data Master</div>
            <x-responsive-nav-link :href="route('admin.program.index')" :active="request()->routeIs('admin.program.*')"
                class="text-white hover:text-oranye pl-8">
                - Data Program
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('admin.instruktur.index')"
                :active="request()->routeIs('admin.instruktur.*')" class="text-white hover:text-oranye pl-8">
                - Data Instruktur
            </x-responsive-nav-link>

            <div class="border-t border-gray-700 my-2"></div>
            <x-responsive-nav-link :href="route('admin.verifikasi.index')"
                :active="request()->routeIs('admin.verifikasi.*')"
                class="text-white hover:text-oranye">Verifikasi</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.pengaturan.index')"
                :active="request()->routeIs('admin.pengaturan.*')" class="text-white hover:text-oranye">Pengaturan
                Web</x-responsive-nav-link>

        </div>
    </div>
</nav>