<section>
    <header>
        <h2 class="text-lg font-medium text-white">Informazioni profilo</h2>
        <p class="mt-1 text-sm text-gray-400">Aggiorna i dati del tuo account.</p>
    </header>

    <!-- Punti disponibili -->
    <div class="mt-4 p-4 bg-gray-700 text-white rounded-lg shadow-inner text-sm">
        <i class="fa-solid fa-coins me-1 text-yellow-400"></i> Hai <strong>{{ $user->points ?? 0 }}</strong> punti disponibili.
    </div>

    <!-- Form verifica email -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Form aggiornamento profilo -->
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" value="Nome" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                          :value="old('name', $user->name)" required autofocus autocomplete="given-name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="surname" value="Cognome" />
            <x-text-input id="surname" name="surname" type="text" class="mt-1 block w-full"
                          :value="old('surname', $user->surname)" required autocomplete="family-name" />
            <x-input-error class="mt-2" :messages="$errors->get('surname')" />
        </div>

        <div>
            <x-input-label for="phone" value="Telefono" />
            <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                          :value="old('phone', $user->phone)" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('phone')" />
        </div>

        <div>
            <x-input-label for="address" value="Indirizzo" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                          :value="old('address', $user->address)" autocomplete="street-address" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                          :value="old('email', $user->email)" required autocomplete="email" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-400">
                        Il tuo indirizzo email non è verificato.
                        <button form="send-verification"
                                class="underline text-sm text-indigo-400 hover:text-indigo-200 rounded-md focus:outline-none">
                            Clicca qui per inviare nuovamente l'email di verifica.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-400">
                            Un nuovo link di verifica è stato inviato al tuo indirizzo email.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>Salva</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-gray-400">
                    Salvato.
                </p>
            @endif
        </div>
    </form>
</section>
