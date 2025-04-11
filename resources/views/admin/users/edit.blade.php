<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">
            Modifica Utente
        </h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <form method="POST" action="{{ route('admin.users.update', $user) }}"
              class="bg-gray-800 rounded-xl shadow-lg w-full max-w-4xl p-6 space-y-6 text-white">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-form-field id="name" label="Nome" :value="old('name', $user->name)" required />
                <x-form-field id="surname" label="Cognome" :value="old('surname', $user->surname)" />
                <x-form-field id="username" label="Username" :value="old('username', $user->username)" required />
                <x-form-field id="email" label="Email" type="email" :value="old('email', $user->email)" required />
                <x-form-field id="phone" label="Telefono" :value="old('phone', $user->phone)" />
                <x-form-field id="company" label="Azienda" :value="old('company', $user->company)" />
                <x-select
                    name="role"
                    label="Ruolo"
                    :options="$roles"
                    optionValue="name"
                    optionLabel="name"
                    :selected="old('role', $user->role)"
                />
            </div>

            <div class="flex justify-end gap-4">
                <x-primary-button>
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Salva
                </x-primary-button>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-400 hover:text-white">
                    Annulla
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
