<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-white">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @include('components.tabs')

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Azione 1 -->
            <a href="#" class="bg-gray-800 hover:bg-gray-700 transition rounded-xl p-6 flex flex-col items-center text-center shadow-lg group">
                <i class="fas fa-users fa-xl mb-4 text-indigo-400 group-hover:text-indigo-300"></i>
                <h3 class="text-lg font-semibold text-white">Gestione Utenti</h3>
                <p class="text-sm text-gray-400 mt-1">Visualizza, modifica o aggiungi nuovi utenti</p>
            </a>

            <!-- Azione 2 -->
            <a href="#" class="bg-gray-800 hover:bg-gray-700 transition rounded-xl p-6 flex flex-col items-center text-center shadow-lg group">
                <i class="fas fa-calendar-alt fa-xl mb-4 text-emerald-400 group-hover:text-emerald-300"></i>
                <h3 class="text-lg font-semibold text-white">Calendario</h3>
                <p class="text-sm text-gray-400 mt-1">Consulta e modifica gli appuntamenti</p>
            </a>

            <!-- Azione 3 -->
            <a href="#" class="bg-gray-800 hover:bg-gray-700 transition rounded-xl p-6 flex flex-col items-center text-center shadow-lg group">
                <i class="fas fa-file-alt fa-xl mb-4 text-pink-400 group-hover:text-pink-300"></i>
                <h3 class="text-lg font-semibold text-white">Documenti</h3>
                <p class="text-sm text-gray-400 mt-1">Gestisci i file e le schede degli utenti</p>
            </a>

            <!-- Azione 4 -->
            <a href="#" class="bg-gray-800 hover:bg-gray-700 transition rounded-xl p-6 flex flex-col items-center text-center shadow-lg group">
                <i class="fas fa-cog fa-xl mb-4 text-yellow-400 group-hover:text-yellow-300"></i>
                <h3 class="text-lg font-semibold text-white">Impostazioni</h3>
                <p class="text-sm text-gray-400 mt-1">Personalizza NepiCard e configura i dati</p>
            </a>
        </div>
    </div>
</x-app-layout>
