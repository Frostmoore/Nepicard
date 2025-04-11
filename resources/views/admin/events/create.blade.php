<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">
            Crea Nuovo Evento
        </h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data"
              class="bg-gray-800 rounded-xl shadow-lg w-full max-w-3xl p-6 space-y-6 text-white">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Titolo Evento --}}
                <div class="col-span-full">
                    <x-input-label for="name" value="Titolo Evento" />
                    <x-text-input id="name" name="name" type="text"
                                  class="mt-1 block w-full"
                                  :value="old('name')" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Data Inizio --}}
                <div>
                    <x-input-label for="start" value="Data Inizio" />
                    <x-text-input id="start" name="start" type="date"
                                  class="mt-1 block w-full"
                                  :value="old('start')" required />
                    <x-input-error :messages="$errors->get('start')" class="mt-2" />
                </div>

                {{-- Data Fine --}}
                <div>
                    <x-input-label for="end" value="Data Fine" />
                    <x-text-input id="end" name="end" type="date"
                                  class="mt-1 block w-full"
                                  :value="old('end')" required />
                    <x-input-error :messages="$errors->get('end')" class="mt-2" />
                </div>

                {{-- Indirizzo --}}
                <div class="col-span-full">
                    <x-input-label for="address" value="Luogo / Indirizzo" />
                    <x-text-input id="address" name="address" type="text"
                                  class="mt-1 block w-full"
                                  :value="old('address')" required />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                {{-- Immagine di Copertina --}}
                <div>
                    <x-input-label for="cover" value="Immagine di copertina" />
                    <input type="file" name="cover" id="cover"
                        class="block w-full mt-1 text-sm text-gray-300 file:bg-gray-700 file:border-0 file:text-sm file:text-white file:rounded file:px-4 file:py-2 hover:file:bg-gray-600" />
                    <x-input-error :messages="$errors->get('cover')" class="mt-2" />
                </div>

                {{-- Punti disponibili --}}
                <div class="col-span-full">
                    <x-input-label for="available_points" value="Punti Disponibili" />
                    <x-text-input id="available_points" name="available_points" type="number"
                                  class="mt-1 block w-full"
                                  :value="old('available_points')" required min="0" />
                    <x-input-error :messages="$errors->get('available_points')" class="mt-2" />
                </div>

                {{-- Descrizione --}}
                <div class="col-span-full">
                    <x-input-label for="description" value="Descrizione" />
                    <textarea id="description" name="description" rows="4"
                              class="mt-1 block w-full bg-gray-700 text-white rounded-md border border-gray-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description') }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <x-primary-button>
                    <i class="fa-solid fa-plus me-2"></i> Crea Evento
                </x-primary-button>
                <a href="{{ route('admin.events.index') }}" class="text-sm text-gray-400 hover:text-white mt-2">Annulla</a>
            </div>
        </form>
    </div>
</x-app-layout>
