<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Elenco Codici</h2>
    </x-slot>

    <div class="mt-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
        <div class="w-full md:w-2/3">
            <input type="text" id="searchInput"
                class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring focus:border-indigo-400"
                placeholder="Cerca per codice, utente o azienda...">
        </div>
        <a href="{{ route('admin.codes.create') }}"
        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-500 shadow whitespace-nowrap">
            <i class="fa-solid fa-plus me-2"></i> Aggiungi Codici
        </a>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach ($codes as $code)
            <div class="bg-gray-800 rounded-xl shadow p-5 hover:shadow-lg transition flex flex-col justify-between">
                <h3 class="text-2xl font-semibold text-white mb-1 text-center mb-4">{{ $code->code }}</h3>
                @if($code->qr)
                    <img src="{{ asset($code->qr) }}" alt="QR Code"
                         class="w-full h-auto object-contain mb-4 rounded bg-white p-2">
                @endif

                <div class="flex-1">
                    @php
                        $companyName = optional($companies->firstWhere('id', $code->company))->name ?? '—';
                        $userObj = $users->firstWhere('id', $code->user);
                        $userName = $userObj ? "{$userObj->surname} {$userObj->name} ({$userObj->username})" : '—';
                        $points = $userObj ? ($userObj->points ?? 0) : ($code->points ?? 0);
                    @endphp

                    <p class="text-sm text-gray-300"><strong>Punti:</strong> <span style="color: green;">{{ $points }}</span></p>


                    <p class="text-sm text-gray-300">
                        <strong>Azienda:</strong> {{ $companyName }}
                    </p>

                    <p class="text-sm text-gray-300">
                        <strong>Utente:</strong> {{ $userName }}
                    </p>
                    <p class="text-sm text-gray-300"><strong>Stato:</strong> {!! ucfirst($code->status) == 'Active' ? '<span style="color:green;">Attivo</span>' : '<span style="color:red;">Disattivato</span>' !!}</p>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <a href="{{ route('admin.codes.show', $code) }}"
                       class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs rounded-md hover:bg-indigo-500">
                        <i class="fa-solid fa-eye me-1"></i> Vedi
                    </a>
                    <a href="{{ route('admin.codes.edit', $code) }}"
                       class="inline-flex items-center px-3 py-1.5 bg-yellow-600 text-white text-xs rounded-md hover:bg-yellow-500">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Modifica
                    </a>
                    <form action="{{ route('admin.codes.destroy', $code) }}" method="POST"
                          onsubmit="return confirm('Confermi l\'eliminazione?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs rounded-md hover:bg-red-500">
                            <i class="fa-solid fa-trash me-1"></i> Elimina
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-6 flex justify-end">
        <a href="{{ route('admin.codes.create') }}"
        class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-500 shadow">
            <i class="fa-solid fa-plus me-2"></i> Aggiungi Codici
        </a>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const cards = document.querySelectorAll('.grid > div');

        searchInput.addEventListener('input', function () {
            const value = this.value.toLowerCase();
            cards.forEach(card => {
                card.style.display = card.textContent.toLowerCase().includes(value) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>
