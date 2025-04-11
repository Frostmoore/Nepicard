<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Nuovo Pacchetto</h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <form method="POST" action="{{ route('admin.packages.store') }}" class="bg-gray-800 rounded-xl shadow-lg w-full max-w-xl p-6 space-y-6 text-white">
            @csrf

            <x-form-field id="name" label="Nome Pacchetto" required />
            <x-form-field id="price" label="Prezzo (€)" type="number" step="0.01" required />
            <x-form-field id="quantity" label="Quantità Voucher" type="number" required />

            <div class="flex justify-end gap-4">
                <x-primary-button>
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Salva
                </x-primary-button>
                <a href="{{ route('admin.packages.index') }}" class="text-sm text-gray-400 hover:text-white self-center">Annulla</a>
            </div>
        </form>
    </div>
</x-app-layout>
