<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

            <!-- Logo & Menu Kiri -->
            <div class="flex items-center space-x-6">
                <a href="#" class="text-2xl font-extrabold text-blue-600 hover:text-blue-800 transition duration-300">
                    CariWisataID
                </a>

                <a href="{{ route('user.index') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('tampilan') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-cart" viewBox="0 0 16 16">
                        <path
                            d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M3.102 4l1.313 7h8.17l1.313-7zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2" />
                    </svg>
                    Destinasi
                </a>

                <!-- Tombol Riwayat (Desktop) -->
                <button id="btnRiwayat" onclick="toggleModal(true)"
    class="hidden sm:inline flex items-center px-4 py-2 text-gray-900 rounded-md hover:bg-gray-200 transition focus:outline-none focus:ring-2 focus:ring-indigo-500">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock mr-2" viewBox="0 0 16 16">
        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
    </svg>
   
</button>

            </div>

            <!-- Menu Kanan -->
            <div class="hidden sm:flex sm:items-center sm:space-x-6">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-600 bg-white hover:text-gray-900 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition duration-200">
                            <svg class="h-5 w-5 text-gray-400 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A7.5 7.5 0 0112 15a7.5 7.5 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="ml-1 h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @endauth

                @guest
                <div class="space-x-4">
                    <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Login</a>
                    <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:underline">Register</a>
                </div>
                @endguest
            </div>

            <!-- Hamburger Menu (Mobile) -->
            <div class="sm:hidden flex items-center">
                <button @click="open = !open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Menu (Mobile) -->
    <div :class="{ 'block': open, 'hidden': !open }"
        class="transition-all duration-300 ease-in-out hidden sm:hidden border-t border-gray-200">
        <div class="px-4 py-3 space-y-1">
            <!-- Tombol Riwayat (Mobile) -->
            <button onclick="toggleModal(true)"
                class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-blue-600 hover:bg-blue-50">
                Riwayat
            </button>

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>

            @auth
            <x-responsive-nav-link :href="route('profile.edit')">Profile</x-responsive-nav-link>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-responsive-nav-link :href="route('logout')"
                    onclick="event.preventDefault(); this.closest('form').submit();">
                    Log Out
                </x-responsive-nav-link>
            </form>
            @endauth

            @guest
            <a href="{{ route('login') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 hover:bg-blue-50">Login</a>
            <a href="{{ route('register') }}"
                class="block px-3 py-2 rounded-md text-base font-medium text-blue-600 hover:bg-blue-50">Register</a>
            @endguest
        </div>
    </div>
</nav>