<x-guest-layout>
    <div class="text-center py-24">
        <h1 class="text-3xl font-bold text-white mb-4">
            <i class="fa-solid fa-server text-red-400 me-3"></i> Errore del Server
        </h1>
        <p class="text-gray-400 text-lg mb-6">
            Qualcosa è andato storto sul nostro server. Stiamo lavorando per risolvere il problema.
        </p>
        <a href="{{ route('dashboard') }}" class="inline-block px-5 py-2 text-sm bg-gray-700 hover:bg-gray-600 text-white rounded-md transition">
            <i class="fa-solid fa-house me-2"></i> Torna alla dashboard
        </a>
    </div>
</x-guest-layout>
