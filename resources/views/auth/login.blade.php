<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <x-input-label for="email" value="Username o Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="text" name="email"
                        :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>


        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-600 bg-gray-800 text-indigo-500 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-300">Ricordami</span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-4 gap-4">
            <div class="flex flex-col sm:flex-row gap-2 sm:gap-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-400 hover:text-white focus:outline-none"
                    href="{{ route('password.request') }}">
                        Hai dimenticato la password?
                    </a>
                @endif
            </div>

            <x-primary-button>
                Accedi
            </x-primary-button>
        </div>

        <div class="mt-6 text-center">
            <a href="{{ route('register') }}" class="underline text-sm text-gray-400 hover:text-white transition">
                Non hai un account? Registrati
            </a>
        </div>


    </form>
</x-guest-layout>
