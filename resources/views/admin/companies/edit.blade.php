<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Modifica Azienda</h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <form method="POST" action="{{ route('admin.companies.update', $company) }}"
              class="bg-gray-800 rounded-xl shadow-lg w-full max-w-4xl p-6 space-y-6 text-white">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form-field id="name" label="Nome" :value="old('name', $company->name)" required />
                <x-form-field id="email" label="Email" :value="old('email', $company->email)" />
                <x-form-field id="phone" label="Telefono" :value="old('phone', $company->phone)" />
                <x-form-field id="address" label="Indirizzo" :value="old('address', $company->address)" />
                <x-form-field id="coordinates" label="Coordinate" :value="old('coordinates', $company->coordinates)" />
                <x-form-field id="website" label="Sito Web" :value="old('website', $company->website)" />

                {{-- SELECT: Categoria --}}
                <x-select
                    name="category"
                    label="Categoria"
                    :options="$categories"
                    optionValue="id"
                    optionLabel="name"
                    :selected="old('category', $company->category)"
                />

                <x-form-field id="piva" label="Partita IVA" :value="old('piva', $company->piva)" />
                <x-form-field id="cf" label="Codice Fiscale" :value="old('cf', $company->cf)" />
                <x-form-field id="pec" label="PEC" :value="old('pec', $company->pec)" />
                <x-form-field id="codice_univoco" label="Codice Univoco" :value="old('codice_univoco', $company->codice_univoco)" />
                <x-form-field id="points" label="Punti" type="number" :value="old('points', $company->points)" />

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-white mb-1" for="status">Stato</label>
                    <select name="status" id="status"
                            class="w-full bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="1" @selected(old('status', $company->status) == 1)>Attiva</option>
                        <option value="0" @selected(old('status', $company->status) === '0')>Disattiva</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <x-primary-button>
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Salva
                </x-primary-button>
                <a href="{{ route('admin.companies.index') }}" class="text-sm text-gray-400 hover:text-white">Annulla</a>
            </div>
        </form>
    </div>
</x-app-layout>
