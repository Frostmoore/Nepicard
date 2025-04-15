<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Dettagli Sponsor</h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <div class="bg-gray-800 rounded-xl shadow-lg w-full max-w-4xl p-6 text-white space-y-6">

            <h3 class="text-lg font-semibold">Informazioni</h3>

            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><dt class="font-semibold">Nome:</dt><dd>{{ $sponsor->name }}</dd></div>
                <div><dt class="font-semibold">Azienda:</dt><dd>{{ $sponsor->company }}</dd></div>
                <div><dt class="font-semibold">Categoria:</dt><dd>{{ $sponsor->category }}</dd></div>
                <div><dt class="font-semibold">Tipo:</dt><dd>{{ $sponsor->type }}</dd></div>
                <div><dt class="font-semibold">Punti:</dt><dd>{{ $sponsor->points }}</dd></div>
                <div><dt class="font-semibold">Indirizzo:</dt><dd>{{ $sponsor->address }}</dd></div>
                <div><dt class="font-semibold">Link:</dt><dd><a href="{{ $sponsor->url }}" target="_blank" class="text-indigo-400 hover:underline">{{ $sponsor->url }}</a></dd></div>
                <div><dt class="font-semibold">Stato:</dt>
                    <dd>
                        @if($sponsor->status)
                            <span class="text-green-400">Attivo</span>
                        @else
                            <span class="text-red-400">Inattivo</span>
                        @endif
                    </dd>
                </div>
                <div><dt class="font-semibold">Data Inizio:</dt><dd>{{ $sponsor->start }}</dd></div>
                <div><dt class="font-semibold">Data Fine:</dt><dd>{{ $sponsor->end }}</dd></div>
            </dl>

            <div>
                <h4 class="font-semibold mt-4">Descrizione Breve:</h4>
                <p class="text-sm text-gray-300">{{ $sponsor->short_description }}</p>
            </div>

            <div>
                <h4 class="font-semibold mt-4">Descrizione Estesa:</h4>
                <p class="text-sm text-gray-300 whitespace-pre-line">{{ $sponsor->description }}</p>
            </div>

            @if($sponsor->picture)
                <div>
                    <h4 class="font-semibold mt-4">Immagine:</h4>
                    <img src="{{ asset($sponsor->picture) }}" class="mt-2 w-full max-h-72 object-cover rounded shadow" />
                </div>
            @endif

            @if($sponsor->coordinates)
                <div class="mt-10">
                    <h3 class="text-lg font-semibold text-white mb-2">Posizione su Mappa</h3>
                    <div id="map" class="rounded shadow-md" style="height: 300px;"></div>
                </div>
            @endif

            <div class="pt-6 text-right space-x-3">
                <a href="{{ route('admin.sponsors.edit', $sponsor) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-500">
                    <i class="fa-solid fa-pen-to-square me-2"></i> Modifica
                </a>
                <a href="{{ route('admin.sponsors.index') }}" class="text-sm text-gray-400 hover:text-white">← Torna alla lista</a>
            </div>
        </div>
    </div>

    @if($sponsor->coordinates)
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const coords = "{{ $sponsor->coordinates }}".split(',').map(parseFloat);
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
                    maxZoom: 18,
                }).addTo(map);

                const marker = L.marker(coords).addTo(map);

                const image = @json($sponsor->picture);
                const imageHTML = image ? `<img src='{{ asset('') }}${image}' class='w-40 h-24 object-cover rounded mb-2'>` : '';

                const tooltip = `
                    <div class='text-sm text-white text-center'>
                        <strong>{{ $sponsor->name }}</strong><br>
                        ${imageHTML}
                        <a href='https://www.google.com/maps?q={{ $sponsor->coordinates }}'
                            target='_blank'
                            id="tasto-tooltip"
                            class='inline-block mt-2 px-4 py-1 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-500'>
                            <i class="fa-solid fa-location-dot me-1"></i> Guidami qui
                        </a>
                    </div>
                `;

                marker.bindPopup(tooltip).openPopup();
            });
        </script>

        <style>
            .leaflet-popup-content-wrapper {
                background-color: #1f2937;
                color: white;
                border-radius: 8px;
                padding: 12px;
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
