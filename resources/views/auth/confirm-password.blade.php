<x-guest-layout>
    <div class="mb-4 text-sm text-gray-400">
        Questa è un'area protetta dell'applicazione. Conferma la tua password per continuare.
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                Conferma
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
