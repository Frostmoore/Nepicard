<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">
            Modifica Utente
        </h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <form method="POST" action="{{ route('admin.users.update', $user) }}"
            x-data="{ isBusiness: '{{ old('role', $user->role) }}' === 'business' }"
            class="bg-gray-800 rounded-xl shadow-lg w-full max-w-4xl p-6 space-y-6 text-white">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="col-span-full">
                    <h3 class="text-lg font-semibold text-white mb-2">Informazioni Personali</h3>
                </div>
                <x-form-field id="name" label="Nome" :value="old('name', $user->name)" />
                <x-form-field id="surname" label="Cognome" :value="old('surname', $user->surname)" />
                <x-form-field id="username" label="Username" :value="old('username', $user->username)" required />
                <x-form-field id="email" label="Email" type="email" :value="old('email', $user->email)" required />
                <x-form-field id="phone" label="Telefono" :value="old('phone', $user->phone)" />
                <x-form-field id="address" label="Indirizzo" :value="old('address', $user->address)" />
                <x-select
                    name="category"
                    label="Categoria"
                    :options="['Privato', 'Azienda', 'Pubblica Amministrazione']"
                    :selected="old('category', $user->category)"
                />

                <x-form-field id="website" label="Sito Web" type="url" :value="old('website', $user->website)" />
                <x-select
                    name="role"
                    label="Ruolo"
                    :options="$roles"
                    optionValue="name"
                    optionLabel="name"
                    :selected="old('role', $user->role)"
                    x-on:change="isBusiness = $event.target.value === 'business'"
                />




                {{-- Descrizione (ultimo campo della sezione "personale") --}}
                <div class="md:col-span-2">
                    <x-input-label for="description" value="Descrizione" />
                    <textarea id="description" name="description" rows="3"
                            class="mt-1 w-full bg-gray-700 text-white rounded-md shadow-sm border-gray-600 focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $user->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                {{-- SEPARATORE --}}
                <div x-show="isBusiness" x-transition>
                    <div class="col-span-full border-t border-gray-600 my-4"></div>
                    <div class="col-span-full">
                        <h3 class="text-lg font-semibold text-white mb-2 mt-10">Informazioni Aziendali</h3>
                    </div>

                    <x-form-field id="coordinates" label="Coordinate" :value="old('coordinates', $user->coordinates)" />
                    <x-form-field id="ditta" label="Ditta" :value="old('ditta', $user->ditta)" />
                    <x-form-field id="sede" label="Sede" :value="old('sede', $user->sede)" />
                    <x-form-field id="piva" label="Partita IVA" :value="old('piva', $user->piva)" />
                    <x-form-field id="cf" label="Codice Fiscale" :value="old('cf', $user->cf)" />
                    <x-form-field id="pec" label="PEC" :value="old('pec', $user->pec)" />
                    <x-form-field id="codice_univoco" label="Codice Univoco" :value="old('codice_univoco', $user->codice_univoco)" />
                </div>

            </div>

            <div class="flex justify-end gap-4">
                <x-primary-button>
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Salva
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
