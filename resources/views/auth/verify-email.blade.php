<x-guest-layout>
    <div class="mb-4 text-sm text-gray-400">
        Grazie per esserti registrato! Prima di iniziare, verifica il tuo indirizzo email cliccando sul link che ti abbiamo appena inviato. Se non hai ricevuto l'email, possiamo inviarne un'altra.
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-400">
            Un nuovo link di verifica è stato inviato all'indirizzo email fornito.
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <x-primary-button>
                Invia nuovamente email di verifica
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-400 hover:text-white focus:outline-none">
                Esci
            </button>
        </form>
    </div>
</x-guest-layout>
