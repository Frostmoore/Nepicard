<nav class="bg-gray-800 border-b border-gray-700 relative">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">

            <!-- SINISTRA: Logo -->
            <div class="flex items-center space-x-4">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 text-white font-bold text-lg">
                    <i class="fa-solid fa-id-card text-xl"></i>
                    <span>SuperSconti</span>
                </a>
            </div>

            <!-- BOTTONE MOBILE -->
            @auth
                <div class="md:hidden flex items-center">
                    <button id="mobileMenuToggle" class="text-gray-300 hover:text-white focus:outline-none focus:ring">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>
            @endauth

            @auth
                <!-- MENU DESKTOP PER RUOLO -->
                <x-admin-menu />
                <x-user-menu />
                <x-business-menu />

                <!-- DESTRA: Utente (solo desktop) -->
                <div class="relative flex items-center space-x-2 hidden md:flex">
                    <button id="userMenuButton"
                        class="flex items-center space-x-2 text-sm font-medium text-gray-300 hover:text-white focus:outline-none focus:ring">
                        <span>{{ Auth::user()->username }}</span>
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>

                    <!-- Dropdown -->
                    <div id="userMenu"
                        class="absolute right-0 top-10 z-50 w-44 bg-white dark:bg-gray-700 rounded-lg shadow divide-y divide-gray-100 dark:divide-gray-600
                            transform scale-95 opacity-0 pointer-events-none transition-all duration-200 ease-out origin-top">
                        <div class="px-4 py-3 text-sm text-gray-900 dark:text-white">
                            <div>{{ Auth::user()->role ?? '' }}</div>
                            <div class="font-medium truncate">{{ Auth::user()->surname }} {{ Auth::user()->name }}</div>
                        </div>
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="userMenuButton">
                            <li>
                                <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                    <i class="fa-solid fa-user me-2 text-gray-400"></i> Profilo
                                </a>
                            </li>
                            @if(Auth::user()->role === 'superadmin')
                                <li>
                                    <a href="{{ route('admin.env.edit') }}"
                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        <i class="fa-solid fa-gear me-2 text-gray-400"></i> Impostazioni
                                    </a>
                                </li>
                            @endif
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
            @endauth
        </div>

        <!-- MENU MOBILE -->
        @auth
            <div id="mobileMenu"
                class="hidden absolute top-16 left-0 w-full bg-gray-800 z-50 shadow-lg md:hidden transition-all duration-200 ease-out transform scale-y-0 origin-top"
            >
                <div class="px-4 py-4 space-y-2">
                    <x-admin-menu-mobile />
                    <x-user-menu-mobile />
                    <x-business-menu-mobile />

                    <a href="{{ route('profile.edit') }}" class="block py-2 text-sm text-gray-300 hover:text-white">
                        <i class="fa-solid fa-user me-1"></i> Profilo
                    </a>

                    @if(Auth::user()->role === 'superadmin')
                        <a href="{{ route('admin.env.edit') }}" class="block py-2 text-sm text-gray-300 hover:text-white">
                            <i class="fa-solid fa-gear me-1"></i> Impostazioni
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left py-2 text-sm text-gray-300 hover:text-white">
                            <i class="fa-solid fa-right-from-bracket me-1"></i> Esci
                        </button>
                    </form>
                </div>
            </div>

        @endauth
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggle = document.getElementById("mobileMenuToggle");
            const menu = document.getElementById("mobileMenu");

            if (toggle && menu) {
                toggle.addEventListener("click", function (e) {
                    e.stopPropagation();
                    const isHidden = menu.classList.contains("hidden");

                    if (isHidden) {
                        menu.classList.remove("hidden");
                        requestAnimationFrame(() => {
                            menu.classList.remove("scale-y-0");
                            menu.classList.add("scale-y-100");
                        });
                    } else {
                        menu.classList.remove("scale-y-100");
                        menu.classList.add("scale-y-0");
                        setTimeout(() => {
                            menu.classList.add("hidden");
                        }, 200);
                    }
                });

                document.addEventListener("click", function (e) {
                    if (!menu.contains(e.target) && !toggle.contains(e.target)) {
                        menu.classList.remove("scale-y-100");
                        menu.classList.add("scale-y-0");
                        setTimeout(() => {
                            menu.classList.add("hidden");
                        }, 200);
                    }
                });
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const userToggle = document.getElementById("userMenuButton");
            const userMenu = document.getElementById("userMenu");

            if (userToggle && userMenu && window.innerWidth >= 768) {
                let isOpen = false;

                userToggle.addEventListener("click", (e) => {
                    e.stopPropagation();
                    isOpen = !isOpen;

                    if (isOpen) {
                        userMenu.classList.remove("pointer-events-none", "scale-95", "opacity-0");
                        userMenu.classList.add("pointer-events-auto", "scale-100", "opacity-100");
                        console.log("🔓 APRO userMenu");
                    } else {
                        userMenu.classList.remove("scale-100", "opacity-100", "pointer-events-auto");
                        userMenu.classList.add("scale-95", "opacity-0", "pointer-events-none");
                        console.log("🔒 CHIUDO userMenu");
                    }
                });

                // 👉 BLOCCA la propagazione del click sul menu
                userMenu.addEventListener("click", (e) => e.stopPropagation());

                document.addEventListener("click", (e) => {
                    if (
                        isOpen &&
                        !userMenu.contains(e.target) &&
                        !userToggle.contains(e.target)
                    ) {
                        userMenu.classList.remove("scale-100", "opacity-100", "pointer-events-auto");
                        userMenu.classList.add("scale-95", "opacity-0", "pointer-events-none");
                        isOpen = false;
                        console.log("🔒 CHIUDO userMenu (click fuori)");
                    }
                });
            }
        });
    </script>














</nav>
