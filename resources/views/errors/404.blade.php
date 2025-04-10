<x-guest-layout>
    <div class="text-center py-24">
        <h1 class="text-3xl font-bold text-white mb-4">
            <i class="fa-solid fa-magnifying-glass text-yellow-500 me-3"></i> Pagina non trovata
        </h1>
        <p class="text-gray-400 text-lg mb-6">
            La risorsa richiesta non esiste o è stata rimossa.
        </p>
        <a href="{{ route('dashboard') }}" class="inline-block px-5 py-2 text-sm bg-gray-700 hover:bg-gray-600 text-white rounded-md transition">
            <i class="fa-solid fa-house me-2"></i> Torna alla dashboard
        </a>
    </div>
</x-guest-layout>
