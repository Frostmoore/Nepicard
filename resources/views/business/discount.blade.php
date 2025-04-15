<x-app-layout>
    <div x-data="userSelector()" x-init="init()" class="max-w-2xl mx-auto mt-10 p-6 bg-gray-800 rounded shadow text-white">
        <h1 class="text-2xl font-semibold mb-6">Emetti Sconto a un Utente</h1>

        <form method="POST" action="{{ route('business.discount.store') }}">
            @csrf

            <!-- Messaggio errore QR -->
            <div class="mb-4 text-sm text-red-500" x-show="qrInvalidMessage">
                <span x-text="qrInvalidMessage"></span>
            </div>

            <!-- Selettore utente -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-1">Utente</label>
                <input type="text" x-model="search" placeholder="Cerca nome utente..." 
                    class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white" 
                    :disabled="qrAssigned">

                <div x-show="filtered.length > 0 && !qrAssigned" class="bg-gray-700 border border-gray-600 rounded mt-1 max-h-40 overflow-y-auto">
                    <template x-for="user in filtered" :key="user.id">
                        <div @click="selectUser(user)" class="px-3 py-2 cursor-pointer hover:bg-gray-600 text-sm" 
                            x-text="user.name + ' ' + user.surname + ' (' + user.email + ')'">
                        </div>
                    </template>
                </div>

                <input type="hidden" name="user_id" :value="selectedId">
                <div class="mt-1 text-sm text-gray-400" x-text="selectedName"></div>
            </div>

            <!-- Bottone Scansiona Tessera -->
            <div class="mb-6">
                <button type="button" @click="openScanner()" 
                        class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-4 rounded transition">
                    <i class="fa-solid fa-qrcode mr-2"></i> Scansiona Tessera
                </button>
            </div>

            <!-- Modale Scanner QR -->
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

            <!-- Campo punti -->
            <div class="mb-6">
                <label for="points" class="block text-sm font-medium text-gray-300 mb-1">Punti da sottrarre</label>
                <input type="number" name="points" id="points" required min="1" 
                    class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white" 
                    x-model.number="assignedPoints"
                    @input="updatePointsCheck">
                <p class="text-red-500 text-sm mt-2" x-show="!hasEnoughPoints">
                    ⚠️ <span x-text="selectedName || 'La tessera selezionata'"></span> non ha punti sufficienti per eseguire l'operazione.
                </p>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        :disabled="!hasEnoughPoints"
                        class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-6 rounded transition disabled:opacity-50 disabled:cursor-not-allowed">
                    Sottrai Punti
                </button>
            </div>
        </form>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        <script>
            function userSelector() {
                return {
                    search: '',
                    selectedId: null,
                    selectedName: '',
                    showScanner: false,
                    qrAssigned: false,
                    assignedPoints: 1,
                    qrInvalidMessage: '',
                    hasEnoughPoints: false,
                    currentPoints: 0,
                    users: [],
                    codes: [],

                    init() {
                        this.users = {!! json_encode($users->map(fn($u) => [
                            'id' => $u->id,
                            'name' => $u->name,
                            'surname' => $u->surname,
                            'email' => $u->email,
                            'points' => (int) $u->points
                        ])->values()->all()) !!};

                        this.codes = {!! $codes->map(fn($c) => [
                            'id' => $c->id,
                            'code' => $c->code,
                            'status' => $c->status,
                            'points' => (int)($c->points ?? 0),
                            'user_id' => is_object($c->user) ? $c->user->id : (is_numeric($c->user) ? (int)$c->user : null)
                        ])->values()->toJson() !!};
                    },

                    get filtered() {
                        if (this.search === '') return [];
                        return this.users.filter(u => 
                            (u.name + ' ' + u.surname).toLowerCase().includes(this.search.toLowerCase())
                        );
                    },

                    selectUser(user) {
                        this.selectedId = user.id;
                        this.selectedName = user.name + ' ' + user.surname;
                        this.currentPoints = user.points;
                        this.qrAssigned = false;
                        this.qrInvalidMessage = '';
                        this.updatePointsCheck();
                    },

                    openScanner() {
                        this.qrInvalidMessage = '';
                        this.showScanner = true;

                        Html5Qrcode.getCameras().then(cameras => {
                            if (cameras && cameras.length > 0) {
                                const qr = new Html5Qrcode("qr-reader");
                                qr.start({ deviceId: cameras[0].id }, { fps: 10, qrbox: 250 },
                                    (decodedText) => {
                                        const found = this.codes.find(c => c.code === decodedText);
                                        if (found) {
                                            if (found.status !== 'active') {
                                                this.qrInvalidMessage = '❌ Questa tessera è stata disattivata.';
                                                this.resetSelection();
                                            } else {
                                                const matchedUser = this.users.find(u => u.id === found.user_id);
                                                this.selectedId = found.user_id ? matchedUser?.id : found.id;
                                                this.selectedName = found.user_id ? (matchedUser ? matchedUser.name + ' ' + matchedUser.surname : 'Utente sconosciuto') : 'Tessera al Portatore';
                                                this.currentPoints = matchedUser ? matchedUser.points : found.points;
                                                this.qrAssigned = true;
                                                this.updatePointsCheck();
                                            }
                                        }
                                        qr.stop();
                                        this.showScanner = false;
                                    }).catch(err => console.error(err));
                            }
                        });
                    },

                    updatePointsCheck() {
                        this.hasEnoughPoints = this.currentPoints >= this.assignedPoints && this.currentPoints > 0;
                    },

                    resetSelection() {
                        this.selectedId = null;
                        this.selectedName = '';
                        this.currentPoints = 0;
                        this.qrAssigned = false;
                        this.hasEnoughPoints = false;
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
