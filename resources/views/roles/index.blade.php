<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-white">Gestione Ruoli</h2>
    </x-slot>

    <div class="mt-6">
        <div class="bg-gray-800 shadow-lg rounded-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-white">
                    <i class="fa-solid fa-key me-2 text-indigo-400"></i> Elenco Ruoli
                </h3>
                <a href="{{ route('roles.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md shadow hover:bg-indigo-500 transition">
                    <i class="fa-solid fa-plus me-2"></i> Nuovo Ruolo
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-300">
                    <thead class="uppercase bg-gray-700 text-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3">#</th>
                            <th scope="col" class="px-6 py-3">Nome</th>
                            <th scope="col" class="px-6 py-3 text-right">Azioni</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-600">
                        @forelse ($roles as $role)
                            @if($role->name != 'superadmin')
                                <tr class="hover:bg-gray-700 transition">
                                    <td class="px-6 py-4">{{ $role->id }}</td>
                                    <td class="px-6 py-4">{{ $role->name }}</td>
                                    <td class="px-6 py-4 text-right flex justify-end space-x-2">
                                        <a href="{{ route('roles.edit', $role) }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-yellow-600 text-white text-xs rounded-md hover:bg-yellow-500">
                                            <i class="fa-solid fa-pen-to-square me-1"></i> Modifica
                                        </a>
                                        <form action="{{ route('roles.destroy', $role) }}" method="POST" onsubmit="return confirm('Confermi eliminazione?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs rounded-md hover:bg-red-500">
                                                <i class="fa-solid fa-trash me-1"></i> Elimina
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                    Nessun ruolo disponibile.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
