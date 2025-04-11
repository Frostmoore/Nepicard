<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">
            Gestione Utenti
        </h2>
    </x-slot>

    <div class="mt-6 space-y-4">

        <div class="max-w-md">
            <input type="text" id="searchInput"
                   class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring focus:border-indigo-400"
                   placeholder="Cerca per nome, email o username...">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-300" id="userTable">
                <thead class="uppercase bg-gray-700 text-gray-300">
                    <tr>
                        <th class="px-6 py-3">ID</th>
                        <th class="px-6 py-3">Nome</th>
                        <th class="px-6 py-3">Username</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Telefono</th>
                        <th class="px-6 py-3">Ruolo</th>
                        <th class="px-6 py-3 text-right">Azioni</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-600">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-700 transition">
                            <td class="px-6 py-4">{{ $user->id }}</td>
                            <td class="px-6 py-4">{{ $user->name }} {{ $user->surname }}</td>
                            <td class="px-6 py-4">{{ $user->username }}</td>
                            <td class="px-6 py-4">{{ $user->email }}</td>
                            <td class="px-6 py-4">{{ $user->phone }}</td>
                            <td class="px-6 py-4">{{ $user->role }}</td>
                            <td class="px-6 py-4 text-right flex justify-end space-x-2">
                                <a href="{{ route('admin.users.show', $user) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs rounded-md hover:bg-indigo-500">
                                    <i class="fa-solid fa-eye me-1"></i> Vedi
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-yellow-600 text-white text-xs rounded-md hover:bg-yellow-500">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Modifica
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Confermi l\'eliminazione?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs rounded-md hover:bg-red-500">
                                        <i class="fa-solid fa-trash me-1"></i> Elimina
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.reset', $user) }}" method="POST">
                                    @csrf
                                    <button
                                        class="inline-flex items-center px-3 py-1.5 bg-gray-600 text-white text-xs rounded-md hover:bg-gray-500">
                                        <i class="fa-solid fa-envelope-circle-check me-1"></i> Reset
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('searchInput');
        const table = document.getElementById('userTable');
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
