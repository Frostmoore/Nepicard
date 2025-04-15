<x-app-layout>
    <div x-data="qrVerifier()" x-init="init()" class="max-w-2xl mx-auto mt-10 p-6 bg-gray-800 rounded shadow text-white">
        <h1 class="text-2xl font-semibold mb-6">Verifica Tessera</h1>

        <!-- Bottone Scansiona -->
        <div class="mb-6">
            <button type="button"
                    @click="openScanner()"
                    class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-4 rounded transition">
                <i class="fa-solid fa-qrcode mr-2"></i> Scannerizza Tessera
            </button>
        </div>

        <!-- Modale Scanner -->
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

        <!-- Risultato -->
        <div x-show="found" class="mt-8 space-y-4 border-t border-gray-600 pt-6">
            <div>
                <span class="text-gray-400">Intestatario:</span>
                <span class="font-semibold" x-text="ownerName"></span>
            </div>

            <div>
                <span class="text-gray-400">Saldo Punti:</span>
                <span class="font-semibold" x-text="points"></span>
            </div>

            <div>
                <span class="text-gray-400">Stato:</span>
                <span :class="status === 'active' ? 'text-green-400' : 'text-red-400'" x-text="statusLabel"></span>
            </div>
        </div>

        <!-- Nessun codice trovato -->
        <div x-show="errorMessage" class="text-red-500 text-sm mt-4" x-text="errorMessage"></div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        <script>
            function qrVerifier() {
                return {
                    showScanner: false,
                    found: false,
                    errorMessage: '',
                    ownerName: '',
                    points: '',
                    status: '',
                    statusLabel: '',
                    codes: [],
                    users: [],

                    init() {
                        this.codes = {!! $codes->map(fn($c) => [
                            'id' => $c->id,
                            'code' => $c->code,
                            'status' => $c->status,
                            'points' => $c->points,
                            'user_id' => $c->user,
                        ])->values()->toJson() !!};

                        this.users = {!! json_encode($users->map(fn($u) => [
                            'id' => $u->id,
                            'name' => $u->name,
                            'surname' => $u->surname,
                            'points' => $u->points
                        ])->values()->all()) !!};
                    },

                    openScanner() {
                        this.showScanner = true;
                        this.found = false;
                        this.errorMessage = '';
                        Html5Qrcode.getCameras().then(cameras => {
                            if (cameras && cameras.length > 0) {
                                const qr = new Html5Qrcode("qr-reader");
                                qr.start(
                                    { deviceId: cameras[0].id },
                                    { fps: 10, qrbox: 250 },
                                    (decodedText) => {
                                        const foundCode = this.codes.find(c => c.code === decodedText);
                                        if (!foundCode) {
                                            this.errorMessage = '❌ Codice non trovato.';
                                            this.closeScanner();
                                            return;
                                        }

                                        this.status = foundCode.status;
                                        this.statusLabel = (foundCode.status === 'active') ? 'Attiva' : 'Disattivata';

                                        if (foundCode.user_id) {
                                            const user = this.users.find(u => u.id == foundCode.user_id);
                                            if (user) {
                                                this.ownerName = user.surname + ' ' + user.name;
                                                this.points = user.points;
                                            } else {
                                                this.ownerName = 'Tessera assegnata a utente sconosciuto';
                                                this.points = foundCode.points;
                                            }
                                        } else {
                                            this.ownerName = 'Tessera al Portatore';
                                            this.points = foundCode.points;
                                        }

                                        this.found = true;
                                        qr.stop();
                                        this.showScanner = false;
                                    },
                                    () => {}
                                ).catch(console.error);
                            }
                        });
                    },

                    closeScanner() {
                        this.showScanner = false;
                        document.getElementById("qr-reader").innerHTML = "";
                    }
                };
            }
        </script>
    @endpush
</x-app-layout>
