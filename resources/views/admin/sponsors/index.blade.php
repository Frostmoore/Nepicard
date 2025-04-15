<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Gestione Sponsor</h2>
    </x-slot>

    <div class="mt-6 max-w-md mb-4">
        <input type="text" id="searchInput"
               class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring focus:border-indigo-400"
               placeholder="Cerca per nome, azienda o categoria...">
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($sponsors as $sponsor)
            <div class="bg-gray-800 rounded-xl shadow p-5 hover:shadow-lg transition flex flex-col justify-between">
                @if($sponsor->picture)
                    <img src="{{ asset($sponsor->picture) }}" alt="Cover"
                         class="w-full h-40 object-cover rounded mb-3 shadow">
                @endif

                <div class="flex-grow">
                    <h3 class="text-lg font-semibold text-white mb-2">{{ $sponsor->name }}</h3>
                    <p class="text-sm text-gray-300 mb-1"><strong>Azienda:</strong> {{ $sponsor->company }}</p>
                    <p class="text-sm text-gray-300"><strong>Categoria:</strong> {{ $categories[$sponsor->category]->name ?? '-' }}</p>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <a href="{{ route('admin.sponsors.show', $sponsor) }}"
                       class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs rounded-md hover:bg-indigo-500">
                        <i class="fa-solid fa-eye me-1"></i> Vedi
                    </a>
                    <a href="{{ route('admin.sponsors.edit', $sponsor) }}"
                       class="inline-flex items-center px-3 py-1.5 bg-yellow-600 text-white text-xs rounded-md hover:bg-yellow-500">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Modifica
                    </a>
                    <form action="{{ route('admin.sponsors.destroy', $sponsor) }}" method="POST" onsubmit="return confirm('Confermi eliminazione?')">
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
        <a href="{{ route('admin.sponsors.create') }}"
           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-500 shadow">
            <i class="fa-solid fa-plus me-2"></i> Aggiungi Sponsor
        </a>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const cards = document.querySelectorAll('.grid > div');

        searchInput.addEventListener('input', function () {
            const search = this.value.toLowerCase();
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(search) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>
