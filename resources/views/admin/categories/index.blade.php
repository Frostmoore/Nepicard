<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Categorie Merceologiche</h2>
    </x-slot>

    <div class="mt-6 space-y-4">
        <a href="{{ route('admin.categories.create') }}"
           class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-500">
            <i class="fa-solid fa-plus me-2"></i> Nuova Categoria
        </a>

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
                    @forelse ($categories as $category)
                        <tr class="hover:bg-gray-700 transition">
                            <td class="px-6 py-4">{{ $category->id }}</td>
                            <td class="px-6 py-4">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-right flex justify-end space-x-2">
                                <a href="{{ route('admin.categories.edit', $category) }}"
                                   class="inline-flex items-center px-3 py-1.5 bg-yellow-600 text-white text-xs rounded-md hover:bg-yellow-500">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Modifica
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Confermi eliminazione?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs rounded-md hover:bg-red-500">
                                        <i class="fa-solid fa-trash me-1"></i> Elimina
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                Nessuna categoria disponibile.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
