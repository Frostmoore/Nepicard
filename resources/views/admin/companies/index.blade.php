<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Gestione Aziende</h2>
    </x-slot>

    <div class="mt-6 max-w-md mb-4">
        <input type="text" id="searchInput"
               class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring focus:border-indigo-400"
               placeholder="Cerca per nome, email o partita IVA...">
    </div>

    <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-md">
        <table class="w-full text-sm text-left text-gray-300" id="companyTable">
            <thead class="uppercase bg-gray-700 text-gray-300">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Nome</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Telefono</th>
                    <th class="px-6 py-3">Categoria</th>
                    <th class="px-6 py-3 text-right">Azioni</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-600">
                @foreach($companies as $company)
                    <tr class="hover:bg-gray-700 transition">
                        <td class="px-6 py-4">{{ $company->id }}</td>
                        <td class="px-6 py-4">{{ $company->name }}</td>
                        <td class="px-6 py-4">{{ $company->email }}</td>
                        <td class="px-6 py-4">{{ $company->phone }}</td>
                        <td class="px-6 py-4">{{ $company->category }}</td>
                        <td class="px-6 py-4 text-right flex justify-end space-x-2">
                            <a href="{{ route('admin.companies.show', $company) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs rounded-md hover:bg-indigo-500">
                                <i class="fa-solid fa-eye me-1"></i> Vedi
                            </a>
                            <a href="{{ route('admin.companies.edit', $company) }}"
                               class="inline-flex items-center px-3 py-1.5 bg-yellow-600 text-white text-xs rounded-md hover:bg-yellow-500">
                                <i class="fa-solid fa-pen-to-square me-1"></i> Modifica
                            </a>
                            <form action="{{ route('admin.companies.destroy', $company) }}" method="POST" onsubmit="return confirm('Confermi l\'eliminazione?')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs rounded-md hover:bg-red-500">
                                    <i class="fa-solid fa-trash me-1"></i> Elimina
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6 flex justify-end">
        <a href="{{ route('admin.companies.create') }}"
           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-500 shadow">
            <i class="fa-solid fa-plus me-2"></i> Aggiungi Azienda
        </a>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('companyTable');
        const rows = table.querySelectorAll('tbody tr');

        searchInput.addEventListener('input', function () {
            const search = this.value.toLowerCase();
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(search) ? '' : 'none';
            });
        });
    </script>
</x-app-layout>
