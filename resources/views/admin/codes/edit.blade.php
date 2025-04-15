<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Modifica Codice</h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <form method="POST" action="{{ route('admin.codes.update', $code) }}" class="bg-gray-800 rounded-xl shadow-lg w-full max-w-3xl p-6 space-y-6 text-white">
            @csrf
            @method('PUT')

            @php
                $userObj = $users->firstWhere('id', $code->user);
                $currentPoints = $userObj ? ($userObj->points ?? 0) : ($code->points ?? 0);
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Punti --}}
                <x-form-field id="points" label="Punti (Attuali: {{ $currentPoints }})" type="number" :value="old('points', $code->points)" />

                {{-- Utente --}}
                <x-select
                    name="user"
                    label="Utente"
                    :options="$users"
                    optionValue="id"
                    optionLabel="name"
                    :selected="old('user', $code->user)"
                />

                {{-- Azienda --}}
                <x-select
                    name="company"
                    label="Azienda"
                    :options="$companies"
                    optionValue="id"
                    optionLabel="name"
                    :selected="old('company', $code->company)"
                />

                {{-- Stato --}}
                <x-select
                    name="status"
                    label="Stato"
                    :options="[['value' => 'active', 'label' => 'Attivo'], ['value' => 'inactive', 'label' => 'Inattivo'], ['value' => 'used', 'label' => 'Usato']]"
                    optionValue="value"
                    optionLabel="label"
                    :selected="old('status', $code->status)"
                />
            </div>


            <div class="flex justify-end gap-4">
                <x-primary-button>
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Salva
                </x-primary-button>
                <a href="{{ route('admin.codes.index') }}" class="text-sm text-gray-400 hover:text-white mt-2">Annulla</a>
            </div>
        </form>
    </div>
</x-app-layout>
