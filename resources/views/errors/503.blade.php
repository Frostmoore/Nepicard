<x-guest-layout>
    <div class="text-center py-24">
        <h1 class="text-3xl font-bold text-white mb-4">
            <i class="fa-solid fa-wrench text-blue-400 me-3"></i> Manutenzione in corso
        </h1>
        <p class="text-gray-400 text-lg mb-6">
            Il sito è temporaneamente offline per manutenzione. Torna tra poco!
        </p>
        <a href="{{ url()->current() }}" class="inline-block px-5 py-2 text-sm bg-gray-700 hover:bg-gray-600 text-white rounded-md transition">
            <i class="fa-solid fa-rotate-right me-2"></i> Ricarica
        </a>
    </div>
</x-guest-layout>
