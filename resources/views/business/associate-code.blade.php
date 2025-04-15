<x-app-layout>
    <div x-data="qrAssociator()" x-init="init()" class="max-w-6xl mx-auto mt-10 px-4">
        <h1 class="text-2xl font-semibold text-white mb-6">Associa Tessera</h1>

        <template x-if="successMessage">
            <div class="mb-4 text-green-400" x-text="successMessage"></div>
        </template>
        <template x-if="errorMessage">
            <div class="mb-4 text-red-500" x-text="errorMessage"></div>
        </template>

        <!-- Scanner Button -->
        <div class="mb-6 max-w-xl mx-auto">
            <button type="button" @click="openScanner()"
                    class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-4 rounded transition">
                <i class="fa-solid fa-link text-lg mr-2"></i> Scannerizza Tessera
            </button>
        </div>

        <!-- Scanner Result -->
        <template x-if="foundCode">
            <div class="max-w-xl mx-auto mb-6 space-y-3 bg-gray-700 p-4 rounded">
                <div><span class="font-semibold text-gray-300">Codice:</span> <span x-text="foundCode.code"></span></div>
                <div><span class="font-semibold text-gray-300">Status:</span> <span class="text-green-400">Attivo</span></div>

                <form @submit.prevent="submitAssociation">
                    <button type="submit" class="mt-4 w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-4 rounded">
                        <i class="fa-solid fa-check mr-2"></i> Conferma Associazione
                    </button>
                </form>
            </div>
        </template>

        <!-- QR Scanner Modal -->
        <div x-show="showScanner" class="fixed inset-0 bg-black bg-opacity-70 z-50 flex items-center justify-center">
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md relative">
                <button @click="closeScanner()" class="absolute top-3 right-3 text-gray-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
                <h2 class="text-white text-lg font-semibold mb-4"><i class="fa-solid fa-qrcode mr-2"></i> Scannerizza Tessera</h2>
                <div id="qr-reader" class="w-full h-64 bg-black rounded"></div>
            </div>
        </div>

        <!-- Elenco tessere già associate all’utente -->
        <div class="mt-12">
            <h2 class="text-xl font-semibold text-white mb-4">Le tue Tessere Associate</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <template x-for="code in userCodes" :key="code.id">
                    <div class="bg-gray-800 rounded-xl shadow p-5 hover:shadow-lg transition flex flex-col justify-between">
                        <h3 class="text-xl font-bold text-white mb-3 text-center" x-text="code.code"></h3>

                        <template x-if="code.qr">
                            <a :href="code.qr.startsWith('storage/') ? '{{ url('/') }}/' + code.qr : code.qr" 
                            target="_blank" title="Apri QR Code in nuova scheda">
                                <img :src="code.qr.startsWith('storage/') ? '{{ url('/') }}/' + code.qr : code.qr"
                                    alt="QR Code"
                                    class="w-full h-auto object-contain mb-4 rounded bg-white p-2 hover:scale-105 transition duration-200 ease-in-out">
                            </a>
                        </template>


                        <p class="text-sm text-gray-300"><strong>Punti:</strong> 
                            <span class="text-green-400">{{ auth()->user()->points }}</span>
                        </p>
                        <p class="text-sm text-gray-300"><strong>Stato:</strong> 
                            <span class="text-green-400">Attiva</span>
                        </p>
                    </div>
                </template>

                <template x-if="userCodes.length === 0">
                    <p class="text-gray-400 text-sm col-span-full">Nessuna tessera associata al tuo account.</p>
                </template>
            </div>
        </div>

    </div>

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function qrAssociator() {
            return {
                showScanner: false,
                foundCode: null,
                codes: [],
                userCodes: {!! $userCodes->toJson() !!},
                successMessage: '',
                errorMessage: '',

                init() {
                    this.codes = {!! $codes->map(fn($c) => [
                        'id' => $c->id,
                        'code' => $c->code,
                        'status' => $c->status,
                        'points' => $c->points,
                        'qr' => $c->qr,
                        'user_id' => $c->user,
                    ])->values()->toJson() !!};
                },

                openScanner() {
                    this.showScanner = true;
                    this.foundCode = null;

                    Html5Qrcode.getCameras().then(cameras => {
                        if (cameras && cameras.length > 0) {
                            const qr = new Html5Qrcode("qr-reader");
                            qr.start(
                                { deviceId: cameras[0].id },
                                { fps: 10, qrbox: 250 },
                                (decodedText) => {
                                    const match = this.codes.find(c => c.code === decodedText);
                                    if (match && !match.user_id) {
                                        this.foundCode = match;
                                    } else {
                                        this.errorMessage = "⚠️ Tessera non valida o già associata.";
                                    }
                                    qr.stop();
                                    this.showScanner = false;
                                },
                                () => {}
                            ).catch(err => console.error(err));
                        }
                    });
                },

                closeScanner() {
                    this.showScanner = false;
                    document.getElementById("qr-reader").innerHTML = "";
                },

                async submitAssociation() {
                    const formData = new FormData();
                    formData.append('code', this.foundCode.code);
                    formData.append('_token', '{{ csrf_token() }}');

                    const response = await fetch('{{ route('business.code-association.store') }}', {
                        method: 'POST',
                        body: formData
                    });

                    if (response.ok) {
                        this.userCodes.push(this.foundCode);
                        this.successMessage = "✅ Tessera associata con successo!";
                        this.foundCode = null;
                    } else {
                        this.errorMessage = "❌ Errore durante l'associazione.";
                    }
                }
            };
        }
    </script>
    @endpush
</x-app-layout>
