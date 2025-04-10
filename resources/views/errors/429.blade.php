<x-guest-layout>
    <div class="text-center py-24">
        <h1 class="text-3xl font-bold text-white mb-4">
            <i class="fa-solid fa-bolt text-pink-400 me-3"></i> Troppi Tentativi
        </h1>
        <p class="text-gray-400 text-lg mb-6">
            Hai effettuato troppe richieste in un breve periodo. Riprova tra qualche minuto.
        </p>
        <a href="{{ url()->previous() }}" class="inline-block px-5 py-2 text-sm bg-gray-700 hover:bg-gray-600 text-white rounded-md transition">
            <i class="fa-solid fa-rotate-left me-2"></i> Torna indietro
        </a>
    </div>
</x-guest-layout>
