<x-app-layout>
    <div x-data="userSelector()" x-init="init()" class="max-w-2xl mx-auto mt-10 p-6 bg-gray-800 rounded shadow text-white">
        <h1 class="text-2xl font-semibold mb-6">Assegna Punti a un Utente</h1>

        <form method="POST" action="{{ route('business.assign.store') }}">
            @csrf

            <!-- Selettore utente -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-300 mb-1">Utente</label>

                <input 
                    type="text"
                    x-model="search"
                    placeholder="Cerca nome utente..."
                    class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white"
                    :disabled="qrAssigned"
                >

                <div x-show="filtered.length > 0 && !qrAssigned" class="bg-gray-700 border border-gray-600 rounded mt-1 max-h-40 overflow-y-auto">
                    <template x-for="user in filtered" :key="user.id">
                        <div 
                            @click="selectUser(user)"
                            class="px-3 py-2 cursor-pointer hover:bg-gray-600 text-sm"
                            x-text="user.name + ' ' + user.surname + ' (' + user.email + ')'">
                        </div>
                    </template>
                </div>

                <input type="hidden" name="user_id" :value="selectedId">
                <div class="mt-1 text-sm text-gray-400" x-text="selectedName"></div>
                <div class="mt-1 text-sm text-red-500" x-show="qrInvalidMessage" x-text="qrInvalidMessage"></div>
            </div>

            <!-- Bottone Scansiona Tessera -->
            <div class="mb-6">
                <button type="button"
                        @click="openScanner()"
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
            <div class="mb-6" x-show="companyPoints > 0">
                <label for="points" class="block text-sm font-medium text-gray-300 mb-1">
                    Punti da assegnare <span class="text-xs text-gray-400">(Max: <span x-text="companyPoints"></span>)</span>
                </label>
                <input type="number"
                    name="points"
                    id="points"
                    min="1"
                    :max="companyPoints"
                    x-model="assignedPoints"
                    class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded text-white"
                    @input="validatePoints"
                    required>
                <p class="text-sm mt-1 text-red-500" x-show="assignedPoints > companyPoints">
                    Hai superato i punti disponibili (<span x-text="companyPoints"></span>)
                </p>
            </div>

            <!-- Nessun punto -->
            <div class="mb-6 text-red-400 text-sm" x-show="companyPoints <= 0">
                Non hai punti da poter assegnare.
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        x-bind:disabled="companyPoints <= 0"
                        class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 px-6 rounded transition disabled:opacity-50 disabled:cursor-not-allowed">
                    Assegna Punti
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
                companyPoints: 0,
                qrInvalidMessage: '',
                users: [],
                codes: [],
                companies: [],
                init() {
                    this.users = {!! json_encode(
                        $users->map(fn($u) => [
                            'id' => $u->id,
                            'name' => $u->name,
                            'surname' => $u->surname,
                            'email' => $u->email
                        ])->values()->all()
                    ) !!};

                    this.codes = {!! $codes->map(function($c) {
                        return [
                            'id' => $c->id,
                            'code' => $c->code,
                            'status' => $c->status,
                            'user_id' => $c->user
                        ];
                    })->values()->toJson() !!};

                    this.companies = {!! json_encode($companies) !!};
                    const myCompanyId = {{ auth()->user()->company ?? 'null' }};
                    const myCompany = this.companies.find(c => c.id == myCompanyId);
                    this.companyPoints = myCompany?.points ?? 0;
                },
                validatePoints() {
                    if (this.assignedPoints > this.companyPoints) {
                        this.assignedPoints = this.companyPoints;
                    }
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
                    this.search = this.selectedName;
                    this.qrInvalidMessage = '';
                },
                openScanner() {
                    this.qrInvalidMessage = '';
                    this.showScanner = true;
                    Html5Qrcode.getCameras().then(cameras => {
                        if (cameras && cameras.length > 0) {
                            const qr = new Html5Qrcode("qr-reader");
                            qr.start(
                                { deviceId: cameras[0].id },
                                { fps: 10, qrbox: 250 },
                                (decodedText) => {
                                    const found = this.codes.find(c => c.code === decodedText);
                                    if (found) {
                                        if (found.status !== 'active') {
                                            this.qrInvalidMessage = '❌ Questa tessera è stata disattivata, prova con un\'altra tessera o cercando lo Username dal relativo campo.';
                                            this.selectedId = null;
                                            this.selectedName = '';
                                            this.search = '';
                                            this.qrAssigned = false;
                                            qr.stop();
                                            this.showScanner = false;
                                            return;
                                        }

                                        if (found.user_id) {
                                            const matchedUser = this.users.find(u => Number(u.id) === Number(found.user_id));
                                            if (matchedUser) {
                                                this.selectedId = matchedUser.id;
                                                this.selectedName = matchedUser.name + ' ' + matchedUser.surname;
                                            } else {
                                                this.selectedId = found.user_id;
                                                this.selectedName = 'Utente ID #' + found.user_id;
                                            }
                                        } else {
                                            this.selectedId = found.id;
                                            this.selectedName = 'Tessera al Portatore';
                                        }

                                        this.search = this.selectedName;
                                        this.qrAssigned = true;
                                    }
                                    qr.stop();
                                    this.showScanner = false;
                                },
                                (err) => {}
                            ).catch(err => {
                                console.error("Errore scanner:", err);
                            });
                        }
                    }).catch(err => {
                        console.error("Errore accesso camera:", err);
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
