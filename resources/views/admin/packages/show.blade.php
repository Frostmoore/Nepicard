<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">
            Dettagli Pacchetto
        </h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <div class="bg-gray-800 p-6 rounded-lg shadow-md w-full max-w-xl space-y-4 text-white">
            <div>
                <h3 class="text-lg font-bold">Nome:</h3>
                <p>{{ $package->name }}</p>
            </div>

            <div>
                <h3 class="text-lg font-bold">Prezzo:</h3>
                <p>{{ number_format($package->price, 2, ',', '.') }} €</p>
            </div>

            <div>
                <h3 class="text-lg font-bold">Quantità Voucher:</h3>
                <p>{{ $package->quantity }}</p>
            </div>

            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.packages.edit', $package) }}"
                   class="inline-flex items-center px-3 py-1.5 bg-yellow-600 text-white text-xs rounded-md hover:bg-yellow-500">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Modifica
                </a>
                <a href="{{ route('admin.packages.index') }}" class="text-sm text-gray-400 hover:text-white">Indietro</a>
            </div>
        </div>
    </div>
</x-app-layout>
