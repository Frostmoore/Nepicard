<x-guest-layout>
    <div class="text-center py-24">
        <h1 class="text-3xl font-bold text-white mb-4">
            <i class="fa-solid fa-clock-rotate-left text-orange-400 me-3"></i> Sessione Scaduta
        </h1>
        <p class="text-gray-400 text-lg mb-6">
            Per motivi di sicurezza la tua sessione è scaduta. Per favore ricarica la pagina e riprova.
        </p>
        <a href="{{ url()->previous() }}" class="inline-block px-5 py-2 text-sm bg-gray-700 hover:bg-gray-600 text-white rounded-md transition">
            <i class="fa-solid fa-rotate-left me-2"></i> Riprova
        </a>
    </div>
</x-guest-layout>
