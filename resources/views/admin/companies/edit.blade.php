<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Modifica Azienda</h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <form method="POST" action="{{ route('admin.companies.update', $company) }}" enctype="multipart/form-data"
              class="bg-gray-800 rounded-xl shadow-lg w-full max-w-4xl p-6 space-y-6 text-white">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form-field id="name" label="Nome" :value="old('name', $company->name)" required />
                <x-form-field id="email" label="Email" :value="old('email', $company->email)" />
                <x-form-field id="phone" label="Telefono" :value="old('phone', $company->phone)" />
                <x-form-field id="address" label="Indirizzo" :value="old('address', $company->address)" />
                
                {{-- Mappa per Coordinate --}}
                <div class="md:col-span-2">
                    <x-input-label for="coordinates" value="Coordinate" />
                    <input type="text" id="coordinates" name="coordinates"
                        value="{{ old('coordinates', $company->coordinates) }}"
                        class="mt-1 block w-full bg-gray-700 text-white border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" readonly>
                    <div id="map" class="mt-2 rounded-md shadow-md" style="height: 300px;"></div>
                    <x-input-error :messages="$errors->get('coordinates')" class="mt-2" />
                </div>



                <x-form-field id="website" label="Sito Web" :value="old('website', $company->website)" />

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

                {{-- Immagini esistenti --}}
                @if($company->pictures)
                    <div class="col-span-full flex flex-wrap gap-2">
                        @foreach(json_decode($company->pictures) as $pic)
                            <div class="relative w-24 h-24">
                                <img src="{{ asset($pic) }}" class="object-cover w-full h-full rounded shadow">
                                <span class="absolute top-0 right-0 bg-red-600 text-white text-xs px-1 cursor-pointer rounded"
                                    onclick="this.parentElement.remove()">
                                    x
                                </span>
                                <input type="hidden" name="existing_pictures[]" value="{{ $pic }}">
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Immagini aggiuntive --}}
                <div class="col-span-full">
                    <x-input-label for="pictures" value="Aggiungi nuove immagini (max 5)" />
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
            document.addEventListener('DOMContentLoaded', function () {
                const coordInput = document.getElementById('coordinates');
                const coordValue = coordInput.value.trim();
                let mapCenter = [42.2797, 12.1445]; // Coordinate Nepi default
                let marker = null;

                if (coordValue && coordValue.includes(',')) {
                    const [lat, lng] = coordValue.split(',').map(parseFloat);
                    if (!isNaN(lat) && !isNaN(lng)) {
                        mapCenter = [lat, lng];
                    }
                }

                const map = L.map('map').setView(mapCenter, 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(map);

                if (coordValue && coordValue.includes(',')) {
                    const [lat, lng] = coordValue.split(',').map(parseFloat);
                    if (!isNaN(lat) && !isNaN(lng)) {
                        marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                        marker.on('dragend', function (e) {
                            const pos = e.target.getLatLng();
                            coordInput.value = `${pos.lat.toFixed(6)},${pos.lng.toFixed(6)}`;
                        });
                    }
                }

                map.on('click', function (e) {
                    if (!marker) {
                        marker = L.marker(e.latlng, { draggable: true }).addTo(map);
                        marker.on('dragend', function (e) {
                            const pos = e.target.getLatLng();
                            coordInput.value = `${pos.lat.toFixed(6)},${pos.lng.toFixed(6)}`;
                        });
                    } else {
                        marker.setLatLng(e.latlng);
                    }
                    coordInput.value = `${e.latlng.lat.toFixed(6)},${e.latlng.lng.toFixed(6)}`;
                });
            });
        </script>
    @endpush


</x-app-layout>
