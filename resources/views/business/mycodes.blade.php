<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-semibold text-white mb-6">Le Tessere della Tua Azienda</h1>

        @if(session('success'))
            <div class="mb-4 text-green-400">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 text-red-500">{{ session('error') }}</div>
        @endif

        {{-- Barra di ricerca --}}
        <div class="mb-6">
            <input type="text" id="searchInput"
                   class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring focus:border-indigo-400"
                   placeholder="Cerca tessera per codice o utente...">
        </div>

        <div id="cardsGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

            {{-- Card Genera Nuova Tessera --}}
            <a href="{{ route('business.generate-code') }}"
               class="code-card bg-gray-800 hover:bg-gray-700 border-2 border-dashed border-indigo-500 rounded-xl shadow p-5 flex flex-col justify-center items-center transition"
               data-search="nuova tessera genera">
                <i class="fa-solid fa-plus text-4xl text-indigo-400 mb-2"></i>
                <span class="text-white text-lg font-semibold">Genera nuova Tessera</span>
            </a>
            @forelse ($codes as $code)
                @php
                    $user = \App\Models\User::find($code->user);
                    $userLabel = $user ? "$user->surname $user->name ($user->username)" : 'Tessera al Portatore';
                @endphp

                <div class="code-card bg-gray-800 rounded-xl shadow p-5 hover:shadow-lg transition flex flex-col justify-between"
                     data-search="{{ strtolower($code->code . ' ' . $userLabel) }}">
                    <h3 class="text-xl font-bold text-white mb-3 text-center">{{ $code->code }}</h3>

                    @if ($code->qr)
                        <a href="{{ asset($code->qr) }}" target="_blank" title="Apri QR Code in nuova scheda">
                            <img src="{{ asset($code->qr) }}" alt="QR Code"
                                class="w-full h-auto object-contain mb-4 rounded bg-white p-2 hover:scale-105 transition duration-200 ease-in-out">
                        </a>
                    @endif

                    <div class="flex-1 space-y-1">
                        <p class="text-sm text-gray-300"><strong>Punti:</strong> <span class="text-green-400">{{ $code->points ?? 0 }}</span></p>
                        <p class="text-sm text-gray-300"><strong>Utente:</strong> {{ $userLabel }}</p>
                        <p class="text-sm text-gray-300">
                            <strong>Stato:</strong>
                            {!! $code->status === 'active'
                                ? '<span class="text-green-400">Attiva</span>'
                                : '<span class="text-red-400">Disattivata</span>' !!}
                        </p>
                    </div>

                    @if (is_null($code->user))
                        <div class="flex justify-end mt-4">
                            <form action="{{ route('business.remove-code', $code->id) }}" method="POST" onsubmit="return confirm('Sei sicuro di voler rimuovere questa tessera?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-500 transition">
                                    <i class="fa-solid fa-trash mr-1"></i> Rimuovi
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                {{-- Nessun codice trovato --}}
            @endforelse
        </div>
    </div>

    {{-- Script per ricerca dinamica --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('searchInput');
            const cards = document.querySelectorAll('.code-card');

            input.addEventListener('input', () => {
                const query = input.value.toLowerCase();
                cards.forEach(card => {
                    const match = card.getAttribute('data-search').includes(query);
                    card.style.display = match ? '' : 'none';
                });
            });
        });
    </script>
</x-app-layout>
