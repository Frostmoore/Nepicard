<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Gestione Aziende</h2>
    </x-slot>

    <div class="mt-6 max-w-md mb-6">
        <input type="text" id="searchInput"
               class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring focus:border-indigo-400"
               placeholder="Cerca per nome, email o partita IVA...">
    </div>

    <div id="companyGrid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($companies as $company)
            <div class="bg-gray-800 rounded-xl shadow p-4 hover:shadow-lg transition flex flex-col justify-between company-card">
                @php
                    $pics = $company->pictures ? json_decode($company->pictures, true) : [];
                    $cover = $pics[0] ?? null;
                @endphp

                @if($cover)
                    <img src="{{ asset($cover) }}"
                         alt="Cover"
                         class="w-full h-40 object-cover rounded mb-3">
                @endif

                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-white mb-1">{{ $company->name }}</h3>
                    <p class="text-sm text-gray-300"><strong>Email:</strong> {{ $company->email }}</p>
                    <p class="text-sm text-gray-300"><strong>Telefono:</strong> {{ $company->phone }}</p>
                    <p class="text-sm text-gray-300"><strong>Categoria:</strong> {{ $company->category }}</p>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <a href="{{ route('admin.companies.show', $company) }}"
                       class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs rounded-md hover:bg-indigo-500">
                        <i class="fa-solid fa-eye me-1"></i> Vedi
                    </a>
                    <a href="{{ route('admin.companies.edit', $company) }}"
                       class="inline-flex items-center px-3 py-1.5 bg-yellow-600 text-white text-xs rounded-md hover:bg-yellow-500">
                        <i class="fa-solid fa-pen-to-square me-1"></i> Modifica
                    </a>
                    <form action="{{ route('admin.companies.destroy', $company) }}" method="POST"
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
        <a href="{{ route('admin.companies.create') }}"
           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-500 shadow">
            <i class="fa-solid fa-plus me-2"></i> Aggiungi Azienda
        </a>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const cards = document.querySelectorAll('.company-card');

        searchInput.addEventListener('input', function () {
            const search = this.value.toLowerCase();
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.includes(search) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>
