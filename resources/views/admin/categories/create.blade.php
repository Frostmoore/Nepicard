<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Nuova Categoria</h2>
    </x-slot>

    <form method="POST" action="{{ route('admin.categories.store') }}"
          class="mt-6 space-y-4 max-w-xl mx-auto bg-gray-800 rounded-xl p-6 shadow text-white">
        @csrf

        <div>
            <x-input-label for="name" value="Nome Categoria" />
            <x-text-input id="name" name="name" type="text" class="block w-full mt-1"
                          :value="old('name')" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <x-primary-button>Salva</x-primary-button>
        <a href="{{ route('admin.categories.index') }}" class="text-sm text-gray-400 hover:text-white">Annulla</a>
    </form>
</x-app-layout>
