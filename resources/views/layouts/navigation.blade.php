<nav class="bg-gray-800 border-b border-gray-700">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- SINISTRA: Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-white font-bold text-lg">
                    <i class="fa-solid fa-id-card text-xl"></i>
                    <span>NepiCard</span>
                </a>
            </div>

            <!-- CENTRO: Menu -->
            <div class="hidden md:flex space-x-8">
                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'text-white border-b-2 border-white pb-1' : 'text-gray-300 hover:text-white' }} text-sm font-medium transition">
                    <i class="fa-solid fa-house me-1"></i> Dashboard
                </a>
                <a href="{{ route('roles.index') }}"
                    class="{{ request()->routeIs('roles.*') ? 'text-white border-b-2 border-white pb-1' : 'text-gray-300 hover:text-white' }} text-sm font-medium transition">
                    <i class="fa-solid fa-key me-1"></i> Ruoli
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="{{ request()->routeIs('admin.users.*') ? 'text-white border-b-2 border-white pb-1' : 'text-gray-300 hover:text-white' }} text-sm font-medium transition">
                    <i class="fa-solid fa-users me-1"></i> Utenti
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="{{ request()->routeIs('admin.categories.*') ? 'text-white border-b-2 border-white pb-1' : 'text-gray-300 hover:text-white' }} text-sm font-medium transition">
                    <i class="fa-solid fa-layer-group"></i> Categorie
                </a>
                <a href="{{ route('admin.companies.index') }}"
                    class="{{ request()->routeIs('admin.companies.*') ? 'text-white border-b-2 border-white pb-1' : 'text-gray-300 hover:text-white' }} text-sm font-medium transition">
                    <i class="fa-solid fa-building"></i> Aziende
                </a>
                <a href="{{ route('admin.packages.index') }}"
                    class="{{ request()->routeIs('admin.packages.*') ? 'text-white border-b-2 border-white pb-1' : 'text-gray-300 hover:text-white' }} text-sm font-medium transition">
                    <i class="fa-solid fa-boxes-stacked"></i> Pacchetti
                </a>
                <a href="{{ route('admin.events.index') }}"
                    class="{{ request()->routeIs('admin.events.*') ? 'text-white border-b-2 border-white pb-1' : 'text-gray-300 hover:text-white' }} text-sm font-medium transition">
                    <i class="fa-solid fa-calendar-days"></i> Eventi
                </a>
            </div>

            <!-- DESTRA: Utente -->
            <div class="relative flex items-center space-x-2">
                <button id="userMenuButton"
                        class="flex items-center space-x-2 text-sm font-medium text-gray-300 hover:text-white focus:outline-none focus:ring">
                    <span>{{ Auth::user()->username }}</span>
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </button>

                <!-- Dropdown -->
                <div id="userMenu" class="hidden absolute right-0 top-10 z-50 bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                    <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                        <div>{{ Auth::user()->role ?? ''}} </div>
                        <div class="font-medium truncate">{{ Auth::user()->surname }} {{ Auth::user()->name }}</div>
                    </div>
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="userMenuButton">
                        <li>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                <i class="fa-solid fa-user me-2 text-gray-400"></i> Profilo
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                        class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                    <i class="fa-solid fa-right-from-bracket me-2 text-gray-400"></i> Esci
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>


        </div>

        <!-- MOBILE MENU -->
        <div class="md:hidden px-4 pb-4 hidden" id="mobileMenu">
            <a href="{{ route('dashboard') }}"
               class="block py-2 text-sm {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-300 hover:text-white' }}">
                <i class="fa-solid fa-house me-1"></i> Dashboard
            </a>
            <a href="#" class="block py-2 text-sm text-gray-300 hover:text-white">
                <i class="fa-solid fa-users me-1"></i> Utenti
            </a>
            <a href="#" class="block py-2 text-sm text-gray-300 hover:text-white">
                <i class="fa-solid fa-file-lines me-1"></i> Documenti
            </a>
            <a href="{{ route('roles.index') }}" class="block py-2 text-sm text-gray-300 hover:text-white">
                <i class="fa-solid fa-key me-1"></i> Ruoli
            </a>
            <a href="{{ route('profile.edit') }}" class="block py-2 text-sm text-gray-300 hover:text-white">
                <i class="fa-solid fa-user me-1"></i> Profilo
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left py-2 text-sm text-gray-300 hover:text-white">
                    <i class="fa-solid fa-right-from-bracket me-1"></i> Esci
                </button>
            </form>
        </div>
    </div>
</nav>
