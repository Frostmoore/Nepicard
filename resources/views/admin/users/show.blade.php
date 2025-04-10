<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">
            Dettaglio Utente
        </h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <div class="bg-gray-800 rounded-xl shadow-lg w-full max-w-4xl p-6 text-white space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><span class="text-gray-400">ID:</span> {{ $user->id }}</div>
                <div><span class="text-gray-400">Username:</span> {{ $user->username }}</div>
                <div><span class="text-gray-400">Nome:</span> {{ $user->name }}</div>
                <div><span class="text-gray-400">Cognome:</span> {{ $user->surname }}</div>
                <div><span class="text-gray-400">Email:</span> {{ $user->email }}</div>
                <div><span class="text-gray-400">Telefono:</span> {{ $user->phone }}</div>
                <div><span class="text-gray-400">Indirizzo:</span> {{ $user->address }}</div>
                <div><span class="text-gray-400">Categoria:</span> {{ $user->category }}</div>
                <div><span class="text-gray-400">Sito Web:</span> {{ $user->website }}</div>
                <div><span class="text-gray-400">Ruolo:</span> {{ $user->role }}</div>
                <div><span class="text-gray-400">Punti:</span> {{ $user->points }}</div>
                <div><span class="text-gray-400">Stato:</span> {{ $user->status }}</div>
                <div><span class="text-gray-400">Descrizione:</span> {{ $user->description }}</div>
                <div><span class="text-gray-400">Coordinate:</span> {{ $user->coordinates }}</div>
                <div><span class="text-gray-400">Ditta:</span> {{ $user->ditta }}</div>
                <div><span class="text-gray-400">Sede:</span> {{ $user->sede }}</div>
                <div><span class="text-gray-400">Partita IVA:</span> {{ $user->piva }}</div>
                <div><span class="text-gray-400">Codice Fiscale:</span> {{ $user->cf }}</div>
                <div><span class="text-gray-400">PEC:</span> {{ $user->pec }}</div>
                <div><span class="text-gray-400">Codice Univoco:</span> {{ $user->codice_univoco }}</div>
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('admin.users.edit', $user) }}"
                   class="inline-flex items-center px-4 py-2 text-sm bg-yellow-600 hover:bg-yellow-500 text-white rounded-md">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Modifica
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="inline-flex items-center px-4 py-2 text-sm bg-gray-600 hover:bg-gray-500 text-white rounded-md">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Indietro
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
