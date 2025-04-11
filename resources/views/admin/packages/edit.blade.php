<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">
            Modifica Pacchetto
        </h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <form method="POST" action="{{ route('admin.packages.update', $package) }}" class="bg-gray-800 p-6 rounded-lg shadow-md w-full max-w-xl space-y-4 text-white">
            @csrf
            @method('PUT')

            <div>
                <x-input-label for="name" value="Nome" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $package->name)" required />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="price" value="Prezzo (€)" />
                <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full" :value="old('price', $package->price)" required />
                <x-input-error :messages="$errors->get('price')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="quantity" value="Quantità Voucher" />
                <x-text-input id="quantity" name="quantity" type="number" class="mt-1 block w-full" :value="old('quantity', $package->quantity)" required />
                <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-4">
                <x-primary-button>Salva</x-primary-button>
                <a href="{{ route('admin.packages.index') }}" class="text-sm text-gray-400 hover:text-white">Annulla</a>
            </div>
        </form>
    </div>
</x-app-layout>
