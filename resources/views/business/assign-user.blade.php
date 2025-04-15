<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10 p-6 bg-gray-800 rounded shadow text-white">
        <h1 class="text-2xl font-semibold mb-6">Assegna un Utente alla tua Azienda</h1>

        @if(session('success'))
            <div class="mb-4 text-green-400">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 text-red-500">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('business.assign-user.store') }}">
            @csrf

            <label class="block mb-2 text-sm font-medium text-gray-300">Seleziona utente</label>
            <select name="user_id" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white mb-6" required>
                <option value="">-- Seleziona un utente --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->surname }} {{ $user->name }} ({{ $user->username }})</option>
                @endforeach
            </select>

            <x-primary-button>Assegna alla mia Azienda</x-primary-button>
        </form>
    </div>

    @if(auth()->user()->company && $assignedUsers->count())
        <div class="max-w-4xl mx-auto mt-10 p-6 bg-gray-800 rounded shadow text-white">
            <h2 class="text-xl font-semibold mb-4">Utenti già assegnati alla tua azienda</h2>

            <table class="w-full text-sm text-left text-gray-300">
                <thead class="text-xs uppercase bg-gray-700 text-gray-300">
                    <tr>
                        <th scope="col" class="px-4 py-3">Nome</th>
                        <th scope="col" class="px-4 py-3">Cognome</th>
                        <th scope="col" class="px-4 py-3">Username</th>
                        <th scope="col" class="px-4 py-3">Email</th>
                        <th scope="col" class="px-4 py-3">Azione</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-700">
                    @foreach($assignedUsers as $u)
                        <tr class="border-b border-gray-600 hover:bg-gray-600">
                            <td class="px-4 py-2">{{ $u->name }}</td>
                            <td class="px-4 py-2">{{ $u->surname }}</td>
                            <td class="px-4 py-2">{{ $u->username }}</td>
                            <td class="px-4 py-2">{{ $u->email }}</td>
                            <td class="px-4 py-2">
                                <form method="POST" action="{{ route('business.remove-user', $u->id) }}" onsubmit="return confirm('Sei sicuro di voler rimuovere questo utente?');">
                                    @csrf
                                    @method('DELETE')
                                    <x-danger-button>Rimuovi</x-danger-button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-app-layout>
