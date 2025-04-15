<x-app-layout>
    <div x-data="qrAssociator()" x-init="init()" class="max-w-xl mx-auto mt-10 p-6 bg-gray-800 rounded shadow text-white">
        <h1 class="text-2xl font-semibold mb-6">Associa Tessera</h1>

        <div class="mb-6">
            <button type="button" @click="openScanner()" 
                    class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-4 rounded transition">
                <i class="fa-solid fa-link text-lg mr-2"></i> Scannerizza Tessera
            </button>
        </div>

        <!-- Messaggio o informazioni -->
        <template x-if="foundCode">
            <div class="space-y-3 bg-gray-700 p-4 rounded">
                <div>
                    <span class="font-semibold text-gray-300">Codice:</span>
                    <span x-text="foundCode.code"></span>
                </div>

                <div>
                    <span class="font-semibold text-gray-300">Status:</span>
                    <span :class="{
                        'text-green-400': foundCode.status === 'active',
                        'text-red-400': foundCode.status !== 'active'
                    }" x-text="foundCode.status"></span>
                </div>

                <template x-if="foundCode.user_id">
                    <div class="text-yellow-400 text-sm">⚠️ Questa tessera è già associata a un utente.</div>
                </template>

                <template x-if="!foundCode.user_id && foundCode.status === 'active'">
                    <form method="POST" action="{{ route('business.code-association') }}">
                        @csrf
                        <input type="hidden" name="code" :value="foundCode.code">
                        <button type="submit"
                                class="mt-4 w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-4 rounded">
                            <i class="fa-solid fa-check mr-2"></i> Conferma Associazione
                        </button>
                    </form>
                </template>
            </div>
        </template>

        <!-- Scanner QR -->
        <div x-show="showScanner" class="fixed inset-0 bg-black bg-opacity-70 z-50 flex items-center justify-center">
            <div class="bg-gray-800 rounded-lg shadow-lg p-6 w-full max-w-md relative">
                <button @click="closeScanner()" class="absolute top-3 right-3 text-gray-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
                <h2 class="text-white text-lg font-semibold mb-4">
                    <i class="fa-solid fa-qrcode mr-2"></i> Scannerizza Tessera
                </h2>
                <div id="qr-reader" class="w-full h-64 bg-black rounded"></div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function qrAssociator() {
            return {
                showScanner: false,
                codes: [],
                foundCode: null,

                init() {
                    this.codes = {!! $codes->map(fn($c) => [
                        'id' => $c->id,
                        'code' => $c->code,
                        'status' => $c->status,
                        'points' => $c->points,
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
                                    if (match) this.foundCode = match;
                                    qr.stop();
                                    this.showScanner = false;
                                },
                                (err) => {}
                            ).catch(err => console.error(err));
                        }
                    });
                },

                closeScanner() {
                    this.showScanner = false;
                    document.getElementById("qr-reader").innerHTML = "";
                }
            }
        }
    </script>
    @endpush
</x-app-layout>
