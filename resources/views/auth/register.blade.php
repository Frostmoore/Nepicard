<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Nome --}}
        <div>
            <x-input-label for="name" value="Nome" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="given-name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        {{-- Cognome --}}
        <div class="mt-4">
            <x-input-label for="surname" value="Cognome" />
            <x-text-input id="surname" class="block mt-1 w-full" type="text" name="surname" :value="old('surname')" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('surname')" class="mt-2" />
        </div>

        {{-- Username --}}
        <div class="mt-4">
            <x-input-label for="username" value="Username" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        {{-- Email --}}
        <div class="mt-4">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Password --}}
        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <div class="h-2 mt-2 rounded bg-gray-700 overflow-hidden">
                <div id="password-strength-bar" class="h-full transition-all duration-300 ease-in-out bg-red-600 w-0"></div>
            </div>
            <p id="password-strength-text" class="text-sm mt-1 text-gray-400"></p>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Conferma Password --}}
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Conferma Password" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <p id="password-match-message" class="text-sm mt-2 text-gray-400"></p>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Registrati come Business --}}
        <div class="mt-4">
            <label class="inline-flex items-center">
                <input id="is_business" type="checkbox" name="is_business" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                <span class="ml-2 text-sm text-gray-300">Registrati come Business</span>
            </label>
        </div>

        {{-- Nome Azienda (solo se business) --}}
        <div class="mt-4 hidden" id="company_name_container">
            <x-input-label for="company_name" value="Nome Azienda" />
            <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" :value="old('company_name')" />
            <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
        </div>

        {{-- Pulsante e messaggio --}}
        <div class="mt-4 flex flex-col items-end space-y-2">
            <div class="flex items-center justify-between w-full">
                <a class="underline text-sm text-gray-400 hover:text-white focus:outline-none" href="{{ route('login') }}">
                    Hai già un account?
                </a>

                <x-primary-button class="ms-4 opacity-50 cursor-not-allowed" id="submit-button" disabled>
                    Registrati
                </x-primary-button>
            </div>

            <p id="submit-help" class="text-sm text-gray-400 w-full text-center">
                Inserisci una password valida e assicurati che le password coincidano.
            </p>
        </div>
    </form>

    {{-- Script visibilità nome azienda --}}
    <script>
        document.getElementById('is_business').addEventListener('change', function () {
            document.getElementById('company_name_container').classList.toggle('hidden', !this.checked);
        });
    </script>

    {{-- Script password strength + confronto --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const password = document.getElementById('password');
            const confirm = document.getElementById('password_confirmation');
            const strengthBar = document.getElementById('password-strength-bar');
            const strengthText = document.getElementById('password-strength-text');
            const matchMessage = document.getElementById('password-match-message');
            const submitBtn = document.getElementById('submit-button');
            const help = document.getElementById('submit-help');

            let passwordStrength = 0;
            let passwordsMatch = false;
            let passwordStartedTyping = false;

            const updateSubmitState = () => {
                if (passwordStrength >= 2 && passwordsMatch) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    help.textContent = '';
                    help.classList.add('hidden');
                } else {
                    submitBtn.disabled = true;
                    submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    if (passwordStartedTyping) {
                        help.textContent = 'Inserisci una password valida e assicurati che le password coincidano.';
                        help.classList.remove('hidden');
                    } else {
                        help.classList.add('hidden');
                    }
                }
            };

            password.addEventListener('input', () => {
                if (!passwordStartedTyping) {
                    passwordStartedTyping = true;
                }

                const val = password.value;
                passwordStrength = 0;
                if (val.length >= 8) passwordStrength++;
                if (/[A-Z]/.test(val)) passwordStrength++;
                if (/[0-9]/.test(val)) passwordStrength++;
                if (/[\W]/.test(val)) passwordStrength++;

                // Barra e testo forza
                if (passwordStrength <= 1) {
                    strengthBar.style.width = '25%';
                    strengthBar.style.backgroundColor = '#dc2626';
                    strengthText.textContent = 'Password debole';
                    strengthText.className = 'text-sm mt-1 text-red-500';
                } else if (passwordStrength <= 3) {
                    strengthBar.style.width = '66%';
                    strengthBar.style.backgroundColor = '#f59e0b';
                    strengthText.textContent = 'Password media';
                    strengthText.className = 'text-sm mt-1 text-yellow-500';
                } else {
                    strengthBar.style.width = '100%';
                    strengthBar.style.backgroundColor = '#16a34a';
                    strengthText.textContent = 'Password forte';
                    strengthText.className = 'text-sm mt-1 text-green-500';
                }

                if (confirm.value.length > 0) {
                    passwordsMatch = password.value === confirm.value;
                }

                updateSubmitState();
            });

            confirm.addEventListener('input', () => {
                passwordsMatch = confirm.value === password.value;
                matchMessage.textContent = passwordsMatch
                    ? '✅ Le password coincidono'
                    : '❌ Le password non coincidono';

                matchMessage.className = passwordsMatch
                    ? 'text-sm mt-2 text-green-500'
                    : 'text-sm mt-2 text-red-500';

                updateSubmitState();
            });

            // Nasconde il messaggio guida inizialmente
            help.classList.add('hidden');
        });
    </script>

</x-guest-layout>
