<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Crea Nuovi Codici</h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <form method="POST" action="{{ route('admin.codes.store') }}" enctype="multipart/form-data"
              class="bg-gray-800 rounded-xl shadow-lg w-full max-w-3xl p-6 space-y-6 text-white">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Serie --}}
                <x-form-field id="serie" label="Serie" :value="old('serie')" required />

                {{-- Quantità --}}
                <x-form-field id="quantita" label="Quantità" type="number" :value="old('quantita', 1)" min="1" required />

                {{-- Punti --}}
                <x-form-field id="points" label="Punti" type="number" :value="old('points')" />

                {{-- Azienda --}}
                <x-select
                    name="company"
                    label="Azienda"
                    :options="$companies"
                    optionValue="id"
                    optionLabel="name"
                    :selected="old('company')"
                />

                {{-- Stato --}}
                <x-select
                    name="status"
                    label="Stato"
                    :options="[['value' => 'active', 'label' => 'Attivo'], ['value' => 'inactive', 'label' => 'Inattivo']]"
                    optionValue="value"
                    optionLabel="label"
                    :selected="old('status', 'active')"
                />
            </div>

            <div class="flex justify-end gap-4">
                <x-primary-button>
                    <i class="fa-solid fa-plus me-2"></i> Crea Codici
                </x-primary-button>
                <a href="{{ route('admin.codes.index') }}" class="text-sm text-gray-400 hover:text-white mt-2">Annulla</a>
            </div>
        </form>
    </div>
</x-app-layout>
