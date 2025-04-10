<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-white">Modifica Ruolo</h2>
    </x-slot>

    <div class="mt-10 flex justify-center">
        <div class="w-full max-w-xl bg-gray-800 rounded-xl shadow-lg p-6">
            <form method="POST" action="{{ route('roles.update', $role) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="name" value="Nome del Ruolo" />
                    <x-text-input id="name" name="name" type="text"
                                  class="block w-full mt-1"
                                  :value="old('name', $role->name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between">
                    <x-primary-button>
                        <i class="fa-solid fa-check me-2"></i> Aggiorna
                    </x-primary-button>

                    <a href="{{ route('roles.index') }}"
                       class="text-sm text-gray-400 hover:text-white transition">
                        Annulla
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
