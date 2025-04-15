<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Nuova Azienda</h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <form method="POST" action="{{ route('admin.companies.store') }}" enctype="multipart/form-data"
              class="bg-gray-800 rounded-xl shadow-lg w-full max-w-4xl p-6 space-y-6 text-white">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form-field id="name" label="Nome" :value="old('name')" required />
                <x-form-field id="email" label="Email" :value="old('email')" />
                <x-form-field id="phone" label="Telefono" :value="old('phone')" />
                <x-form-field id="address" label="Indirizzo" :value="old('address')" />
                
                <div class="md:col-span-2">
                    <x-input-label for="coordinates" value="Posizione sulla mappa" />
                    <div id="map" class="w-full h-64 rounded-lg shadow border border-gray-600"></div>
                    <input type="hidden" name="coordinates" id="coordinates" value="{{ old('coordinates') }}">
                    <x-input-error :messages="$errors->get('coordinates')" class="mt-2" />
                </div>

                <x-form-field id="website" label="Sito Web" :value="old('website')" />

                <x-select
                    name="category"
                    label="Categoria"
                    :options="$categories"
                    optionValue="id"
                    optionLabel="name"
                    :selected="old('category')"
                />

                <x-form-field id="piva" label="Partita IVA" :value="old('piva')" />
                <x-form-field id="cf" label="Codice Fiscale" :value="old('cf')" />
                <x-form-field id="pec" label="PEC" :value="old('pec')" />
                <x-form-field id="codice_univoco" label="Codice Univoco" :value="old('codice_univoco')" />
                <x-form-field id="points" label="Punti" type="number" :value="old('points')" />

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-white mb-1" for="status">Stato</label>
                    <select name="status" id="status"
                            class="w-full bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="1" @selected(old('status') == 1)>Attiva</option>
                        <option value="0" @selected(old('status') === '0')>Disattiva</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                {{-- Campo Immagini --}}
                <div class="col-span-full">
                    <x-input-label for="pictures" value="Immagini (max 5)" />
                    <input type="file" id="pictures" name="pictures[]" multiple accept="image/*"
                        class="hidden" onchange="handleFiles(this.files)">
                    <div class="flex flex-wrap gap-2 mt-2" id="preview"></div>
                    <x-primary-button type="button" class="mt-4" onclick="document.getElementById('pictures').click()">
                        <i class="fa-solid fa-upload me-2"></i> Aggiungi Immagini
                    </x-primary-button>
                    <x-input-error :messages="$errors->get('pictures')" class="mt-2" />
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

    @push('scripts')
        <script>
            let selectedFiles = [];

            function handleFiles(files) {
                const preview = document.getElementById('preview');

                [...files].forEach(file => {
                    if (selectedFiles.length >= 5) return;

                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const div = document.createElement('div');
                        div.className = 'relative w-24 h-24';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="object-cover w-full h-full rounded shadow" />
                            <span class="absolute top-0 right-0 bg-red-600 text-white text-xs px-1 cursor-pointer rounded"
                                onclick="removeImage(this)">x</span>
                        `;
                        preview.appendChild(div);
                    };
                    selectedFiles.push(file);
                    reader.readAsDataURL(file);
                });

                updateInputFiles();
            }

            function removeImage(el) {
                const index = [...el.parentElement.parentElement.children].indexOf(el.parentElement);
                selectedFiles.splice(index, 1);
                el.parentElement.remove();
                updateInputFiles();
            }

            function updateInputFiles() {
                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => dataTransfer.items.add(file));
                document.getElementById('pictures').files = dataTransfer.files;
            }
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const defaultLatLng = [42.2421, 12.3392]; // Nepi
                const map = L.map('map').setView(defaultLatLng, 15);
                let marker;

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; OpenStreetMap contributors'
                }).addTo(map);

                function setMarker(latlng) {
                    if (marker) marker.setLatLng(latlng);
                    else marker = L.marker(latlng, { draggable: true }).addTo(map);

                    document.getElementById('coordinates').value = `${latlng.lat},${latlng.lng}`;

                    marker.on('dragend', function(e) {
                        const pos = e.target.getLatLng();
                        document.getElementById('coordinates').value = `${pos.lat},${pos.lng}`;
                    });
                }

                map.on('click', function(e) {
                    setMarker(e.latlng);
                });

                // Se esistono coordinate precedenti, mostra il marker
                const oldCoords = document.getElementById('coordinates').value;
                if (oldCoords) {
                    const parts = oldCoords.split(',');
                    if (parts.length === 2) {
                        setMarker({ lat: parseFloat(parts[0]), lng: parseFloat(parts[1]) });
                        map.setView([parseFloat(parts[0]), parseFloat(parts[1])], 15);
                    }
                }
            });
        </script>

    @endpush




</x-app-layout>
