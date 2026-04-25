<nav x-data="{ open: false }" class="bg-hitam border-b border-oranye">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('peserta.dashboard') }}">
                        <h1
                            class="text-2xl font-bold text-white tracking-widest hover:text-oranye transition duration-300">
                            LPK<span class="text-oranye">BINA</span></h1>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('peserta.dashboard')" :active="request()->routeIs('peserta.dashboard')"
                        class="text-white hover:text-oranye focus:text-oranye {{ request()->routeIs('peserta.dashboard') ? 'border-oranye text-oranye' : 'border-transparent' }}">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('peserta.biodata.index')" :active="request()->routeIs('peserta.biodata.*')"
                        class="text-white hover:text-oranye focus:text-oranye {{ request()->routeIs('peserta.biodata.*') ? 'border-oranye text-oranye' : 'border-transparent' }}">
                        {{ __('Biodata Diri') }}
                    </x-nav-link>
                    <x-nav-link :href="route('peserta.pendaftaran.index')"
                        :active="request()->routeIs('peserta.pendaftaran.*')"
                        class="text-white hover:text-oranye focus:text-oranye {{ request()->routeIs('peserta.pendaftaran.*') ? 'border-oranye text-oranye' : 'border-transparent' }}">
                        {{ __('Pendaftaran') }}
                    </x-nav-link>
                    <x-nav-link :href="route('peserta.materi.index')" :active="request()->routeIs('peserta.materi.*')"
                        class="text-white hover:text-oranye focus:text-oranye {{ request()->routeIs('peserta.materi.*') ? 'border-oranye text-oranye' : 'border-transparent' }}">
                        {{ __('Materi & Nilai') }}
                    </x-nav-link>
                    <x-nav-link :href="route('peserta.sertifikat.index')"
                        :active="request()->routeIs('peserta.sertifikat.*')"
                        class="text-white hover:text-oranye focus:text-oranye {{ request()->routeIs('peserta.sertifikat.*') ? 'border-oranye text-oranye' : 'border-transparent' }}">
                        {{ __('Sertifikat') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-oranye focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }} (Peserta)</div>
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
                        <x-dropdown-link :href="route('profile.edit')"
                            class="hover:bg-oranye hover:text-white">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="hover:bg-oranye hover:text-white">Log Out</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-oranye hover:bg-gray-800 focus:outline-none transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-hitam border-t border-oranye">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('peserta.dashboard')"
                class="text-white hover:text-oranye">Dashboard</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('peserta.biodata.index')"
                :active="request()->routeIs('peserta.biodata.*')" class="text-white hover:text-oranye">Biodata
                Diri</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('peserta.pendaftaran.index')"
                :active="request()->routeIs('peserta.pendaftaran.*')"
                class="text-white hover:text-oranye">Pendaftaran</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('peserta.materi.index')"
                :active="request()->routeIs('peserta.materi.*')" class="text-white hover:text-oranye">Materi &
                Nilai</x-responsive-nav-link>
            <x-responsive-nav-link :href="route('peserta.sertifikat.index')"
                :active="request()->routeIs('peserta.sertifikat.*')"
                class="text-white hover:text-oranye">Sertifikat</x-responsive-nav-link>
        </div>
    </div>
</nav>