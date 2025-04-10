<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">
            Gestione Utenti
        </h2>
    </x-slot>

    <div class="mt-6">
        <div class="max-w-md mb-4">
            <input type="text" id="searchInput"
                   class="w-full px-4 py-2 rounded-md bg-gray-700 text-white border border-gray-600 focus:outline-none focus:ring focus:border-indigo-400"
                   placeholder="Cerca per nome, email o username...">
        </div>

        <div class="overflow-x-auto bg-gray-800 rounded-lg shadow-md">
            <table class="min-w-full divide-y divide-gray-700 text-sm text-white" id="userTable">
                <thead class="bg-gray-700 uppercase text-xs text-gray-300">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Nome</th>
                        <th class="px-4 py-3">Username</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Telefono</th>
                        <th class="px-4 py-3">Ruolo</th>
                        <th class="px-4 py-3 text-right">Azioni</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-700 text-center">
                            <td class="px-4 py-3">{{ $user->id }}</td>
                            <td class="px-4 py-3">{{ $user->name }} {{ $user->surname }}</td>
                            <td class="px-4 py-3">{{ $user->username }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">{{ $user->phone }}</td>
                            <td class="px-4 py-3">{{ $user->role }}</td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-indigo-400 hover:text-indigo-200"><i class="fa-solid fa-eye"></i></a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-400 hover:text-yellow-200"><i class="fa-solid fa-pen-to-square"></i></a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Confermi l\'eliminazione?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:text-red-300"><i class="fa-solid fa-trash"></i></button>
                                </form>
                                <form action="{{ route('admin.users.reset', $user) }}" method="POST" class="inline">
                                    @csrf
                                    <button class="text-gray-400 hover:text-white"><i class="fa-solid fa-envelope-circle-check"></i></button>
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
