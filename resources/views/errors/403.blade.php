<x-guest-layout>
    <div class="text-center py-24">
        <h1 class="text-3xl font-bold text-white mb-4">
            <i class="fa-solid fa-ban text-red-500 me-3"></i> Accesso Negato
        </h1>
        <p class="text-gray-400 text-lg mb-6">
            Non hai i permessi necessari per accedere a questa pagina.
        </p>
        <a href="{{ url()->previous() }}" class="inline-block px-5 py-2 text-sm bg-gray-700 hover:bg-gray-600 text-white rounded-md transition">
            <i class="fa-solid fa-arrow-left me-2"></i> Torna indietro
        </a>
    </div>
</x-guest-layout>
