<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Dettagli Azienda</h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <div class="bg-gray-800 rounded-xl shadow-lg w-full max-w-4xl p-6 text-white space-y-6">

            <h3 class="text-lg font-semibold">Informazioni Azienda</h3>
            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><dt class="font-semibold">Nome:</dt><dd>{{ $company->name }}</dd></div>
                <div><dt class="font-semibold">Email:</dt><dd>{{ $company->email }}</dd></div>
                <div><dt class="font-semibold">Telefono:</dt><dd>{{ $company->phone }}</dd></div>
                <div><dt class="font-semibold">Indirizzo:</dt><dd>{{ $company->address }}</dd></div>
                <div><dt class="font-semibold">Coordinate:</dt><dd>{{ $company->coordinates }}</dd></div>
                <div><dt class="font-semibold">Sito Web:</dt><dd>{{ $company->website }}</dd></div>
                <div><dt class="font-semibold">Categoria:</dt><dd>{{ $company->category }}</dd></div>
                <div><dt class="font-semibold">Partita IVA:</dt><dd>{{ $company->piva }}</dd></div>
                <div><dt class="font-semibold">Codice Fiscale:</dt><dd>{{ $company->cf }}</dd></div>
                <div><dt class="font-semibold">PEC:</dt><dd>{{ $company->pec }}</dd></div>
                <div><dt class="font-semibold">Codice Univoco:</dt><dd>{{ $company->codice_univoco }}</dd></div>
                <div><dt class="font-semibold">Punti:</dt><dd>{{ $company->points }}</dd></div>
                <div>
                    <dt class="font-semibold">Stato:</dt>
                    <dd>
                        @if($company->status)
                            <span class="text-green-400">Attiva</span>
                        @else
                            <span class="text-red-400">Disattiva</span>
                        @endif
                    </dd>
                </div>
            </dl>

            @php
                $pictures = $company->pictures ? json_decode($company->pictures, true) : [];
            @endphp

            @if($pictures && count($pictures))
                <div 
                    x-data="{ 
                        lightboxOpen: false, 
                        currentImage: 0, 
                        images: {{ Js::from($pictures) }},
                        showImage(index) {
                            this.currentImage = index;
                            this.lightboxOpen = true;
                        },
                        prev() {
                            if (this.currentImage > 0) this.currentImage--;
                        },
                        next() {
                            if (this.currentImage < this.images.length - 1) this.currentImage++;
                        },
                        handleKey(e) {
                            if (!this.lightboxOpen) return;
                            if (e.key === 'ArrowRight') this.next();
                            if (e.key === 'ArrowLeft') this.prev();
                            if (e.key === 'Escape') this.lightboxOpen = false;
                        }
                    }"
                    x-init="window.addEventListener('keydown', handleKey)"
                >
                    <h3 class="text-lg font-semibold mt-6 mb-2">Galleria Immagini</h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                        <template x-for="(img, index) in images" :key="index">
                            <div class="w-full aspect-square bg-gray-700 rounded overflow-hidden shadow cursor-pointer"
                                @click="showImage(index)">
                                <img :src="'{{ asset('') }}' + img"
                                    class="w-full h-full object-cover"
                                    alt="Anteprima immagine">
                            </div>
                        </template>
                    </div>

                    <!-- LIGHTBOX -->
                    <div x-show="lightboxOpen" x-transition
                        class="fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center"
                        style="display: none;">
                        <!-- X -->
                        <button @click="lightboxOpen = false"
                                class="absolute top-4 right-6 text-white text-3xl z-50 hover:text-red-500">
                            &times;
                        </button>

                        <!-- Freccia sinistra -->
                        <button @click="prev"
                                class="absolute left-4 text-white text-4xl z-50 hover:text-indigo-300">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>

                        <!-- Immagine centrale -->
                        <img :src="'{{ asset('') }}' + images[currentImage]" 
                            class="max-w-5xl max-h-[90vh] rounded-lg shadow-lg object-contain">

                        <!-- Freccia destra -->
                        <button @click="next"
                                class="absolute right-4 text-white text-4xl z-50 hover:text-indigo-300">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
            @endif

            @if($company->coordinates)
                <div class="mt-10">
                    <h3 class="text-lg font-semibold text-white mb-2">Posizione su Mappa</h3>
                    <div id="map" class="rounded shadow-md" style="height: 300px;"></div>
                </div>
            @endif




            <div class="pt-6 text-right space-x-3">
                <a href="{{ route('admin.companies.edit', $company) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-500">
                    <i class="fa-solid fa-pen-to-square me-2"></i> Modifica
                </a>
                <a href="{{ route('admin.companies.index') }}" class="text-sm text-gray-400 hover:text-white">← Torna alla lista</a>
            </div>
        </div>
    </div>

    @if($company->coordinates)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const coords = "{{ $company->coordinates }}".split(',').map(parseFloat);
                const map = L.map('map', {
                    center: coords,
                    zoom: 15,
                    zoomControl: false,
                    dragging: false,
                    scrollWheelZoom: false,
                    doubleClickZoom: false,
                    boxZoom: false,
                    keyboard: false,
                    tap: false,
                });

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(map);

                const marker = L.marker(coords).addTo(map);

                const img = {!! json_encode($company->pictures ? json_decode($company->pictures)[0] ?? null : null) !!};
                const imageHTML = img ? `<img src='{{ asset('') }}${img}' class='w-40 h-24 object-cover rounded mb-2'>` : '';

                const tooltip = `
                    <div style="width: 100%;" class="text-white text-center">
                        ${imageHTML}
                        <div class="text-sm font-semibold mb-2">{{ $company->name }}</div>
                        <a href='https://www.google.com/maps?q={{ $company->coordinates }}'
                        target='_blank'
                        id="tasto-tooltip"
                        class='inline-block w-full bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-medium px-3 py-2 rounded transition'>
                        <i class="fa-solid fa-location-dot me-1"></i> Guidami qui
                        </a>
                    </div>
                `;


                marker.bindPopup(tooltip).openPopup();
            });
        </script>

        <style>
            .leaflet-popup-content-wrapper {
                background-color: #1f2937; /* bg-gray-800 */
                color: #fff;
                border-radius: 8px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.5);
            }
            .leaflet-popup-tip {
                background-color: #1f2937;
            }

            #tasto-tooltip {
                color: white!important;
            }
        </style>
    @endif
</x-app-layout>
