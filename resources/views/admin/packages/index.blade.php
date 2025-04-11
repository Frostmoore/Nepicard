<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">
            Gestione Pacchetti
        </h2>
    </x-slot>

    <div class="mt-6">
        <div class="flex justify-between items-center mb-4 flex-col sm:flex-row gap-4">
            <input type="text" id="searchInput"
                   class="w-full sm:w-1/3 px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring focus:border-indigo-400"
                   placeholder="Cerca pacchetto...">

            <a href="{{ route('admin.packages.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-500">
                <i class="fa-solid fa-plus me-2"></i> Nuovo Pacchetto
            </a>
        </div>

        <div id="cardsWrapper" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($packages as $package)
                <div class="bg-gray-800 rounded-xl shadow p-5 hover:shadow-lg transition flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-2">{{ $package->name }}</h3>
                        <p class="text-sm text-gray-300 mb-1"><strong>Prezzo:</strong> {{ number_format($package->price, 2) }} €</p>
                        <p class="text-sm text-gray-300"><strong>Quantità:</strong> {{ $package->quantity }}</p>
                    </div>
                    <div class="flex justify-end gap-2 mt-4">
                        <a href="{{ route('admin.packages.show', $package) }}"
                           class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs rounded-md hover:bg-indigo-500">
                            <i class="fa-solid fa-eye me-1"></i> Vedi
                        </a>
                        <a href="{{ route('admin.packages.edit', $package) }}"
                           class="inline-flex items-center px-3 py-1.5 bg-yellow-600 text-white text-xs rounded-md hover:bg-yellow-500">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Modifica
                        </a>
                        <form action="{{ route('admin.packages.destroy', $package) }}" method="POST" onsubmit="return confirm('Confermi eliminazione?')">
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
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const cards = document.querySelectorAll('#cardsWrapper > div');

        searchInput.addEventListener('input', function () {
            const value = this.value.toLowerCase();
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(value) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>
