<x-app-layout>
    <div class="bg-gray-900 min-h-screen text-white flex flex-col justify-center items-center px-4 py-16">
        <div class="text-center max-w-3xl">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">Benvenuto su <span class="text-indigo-500">SuperSconti</span></h1>
            <p class="text-lg md:text-xl text-gray-300 mb-10">
                La piattaforma digitale per la gestione smart delle aziende, utenti, sponsor e codici promozionali della tua zona.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                @auth
                    @php
                        $user = Auth::user();
                        $dashboardRoute = match($user->role) {
                            'admin', 'superadmin' => route('dashboard'),
                            'business' => route('business.dashboard'),
                            'user' => route('user.dashboard'),
                            default => route('dashboard')
                        };
                    @endphp

                    <a href="{{ $dashboardRoute }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-md font-semibold transition">
                        Vai alla Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-6 py-3 rounded-md font-semibold transition">
                        Accedi
                    </a>
                    <a href="{{ route('register') }}" class="border border-indigo-600 hover:bg-indigo-600 hover:text-white text-indigo-400 px-6 py-3 rounded-md font-semibold transition">
                        Registrati
                    </a>
                @endauth
            </div>

            <div class="mt-16 border-t border-gray-700 pt-8 text-sm text-gray-400">
                <p>Progetto sviluppato con ❤️ da <strong>Lord_Frostmoore</strong>.</p>
            </div>
        </div>
    </div>
</x-app-layout>
