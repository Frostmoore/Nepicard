<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Nuovo Sponsor</h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <form method="POST" action="{{ route('admin.sponsors.store') }}" enctype="multipart/form-data"
              class="bg-gray-800 rounded-xl shadow-lg w-full max-w-4xl p-6 space-y-6 text-white">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form-field id="name" label="Nome" :value="old('name')" required />
                <x-form-field id="company" label="Azienda" :value="old('company')" />
                <x-form-field id="url" label="Link esterno" :value="old('url')" />
                <x-form-field id="type" label="Tipo" :value="old('type')" />
                <x-form-field id="address" label="Indirizzo" :value="old('address')" />

                <x-form-field id="start" label="Data Inizio" type="date" :value="old('start')" />
                <x-form-field id="end" label="Data Fine" type="date" :value="old('end')" />
                <x-form-field id="points" label="Punti" type="number" :value="old('points')" />

                <x-select name="category" label="Categoria"
                          :options="$categories"
                          optionValue="id"
                          optionLabel="name"
                          :selected="old('category')" />

                <div class="md:col-span-2">
                    <x-input-label for="picture" value="Immagine (facoltativa)" />
                    <input type="file" id="picture" name="picture" accept="image/*"
                        class="mt-1 block w-full text-sm text-white bg-gray-700 border border-gray-600 rounded-md">
                    <x-input-error :messages="$errors->get('picture')" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="short_description" value="Descrizione Breve" />
                    <textarea name="short_description" rows="2"
                              class="w-full bg-gray-700 text-white rounded-md border border-gray-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('short_description') }}</textarea>
                    <x-input-error :messages="$errors->get('short_description')" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="description" value="Descrizione Estesa" />
                    <textarea name="description" rows="4"
                              class="w-full bg-gray-700 text-white rounded-md border border-gray-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>

                <div class="md:col-span-2">
                    <x-input-label for="status" value="Stato" />
                    <select name="status" id="status"
                            class="w-full bg-gray-700 text-white border border-gray-600 rounded-md">
                        <option value="1" @selected(old('status') == 1)>Attivo</option>
                        <option value="0" @selected(old('status') === '0')>Inattivo</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                {{-- MAPPA CON COORDINATE --}}
                <div class="md:col-span-2">
                    <x-input-label for="coordinates" value="Coordinate (clicca sulla mappa)" />
                    <input type="text" id="coordinates" name="coordinates" readonly
                        class="w-full bg-gray-700 text-white border border-gray-600 rounded-md mt-1"
                        :value="old('coordinates')" />
                    <div id="map" class="mt-2 rounded shadow" style="height: 300px;"></div>
                    <x-input-error :messages="$errors->get('coordinates')" class="mt-2" />
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <x-primary-button>
                    <i class="fa-solid fa-plus me-2"></i> Crea Sponsor
                </x-primary-button>
                <a href="{{ route('admin.sponsors.index') }}" class="text-sm text-gray-400 hover:text-white mt-2">Annulla</a>
            </div>
        </form>
    </div>

    {{-- LEAFLET.JS --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const defaultCoords = [42.2786, 12.3021]; // Nepi
            const map = L.map('map').setView(defaultCoords, 14);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
            }).addTo(map);

            let marker = null;

            map.on('click', function(e) {
                const latlng = `${e.latlng.lat.toFixed(5)},${e.latlng.lng.toFixed(5)}`;
                document.getElementById('coordinates').value = latlng;

                if (marker) {
                    marker.setLatLng(e.latlng);
                } else {
                    marker = L.marker(e.latlng).addTo(map);
                }
            });
        });
    </script>
</x-app-layout>
