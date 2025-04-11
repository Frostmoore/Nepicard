<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">
            Modifica Evento
        </h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <form method="POST" action="{{ route('admin.events.update', $event) }}" enctype="multipart/form-data"
              class="bg-gray-800 rounded-xl shadow-lg w-full max-w-3xl p-6 space-y-6 text-white">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Titolo Evento --}}
                <div class="col-span-full">
                    <x-input-label for="name" value="Titolo Evento" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                                  :value="old('name', $event->name)" required autofocus />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                {{-- Data Inizio --}}
                <div>
                    <x-input-label for="start" value="Data Inizio" />
                    <x-text-input id="start" name="start" type="date" class="mt-1 block w-full"
                                  :value="old('start', \Carbon\Carbon::parse($event->start)->format('Y-m-d'))" required />
                    <x-input-error :messages="$errors->get('start')" class="mt-2" />
                </div>

                {{-- Data Fine --}}
                <div>
                    <x-input-label for="end" value="Data Fine" />
                    <x-text-input id="end" name="end" type="date" class="mt-1 block w-full"
                                  :value="old('end', \Carbon\Carbon::parse($event->end)->format('Y-m-d'))" required />
                    <x-input-error :messages="$errors->get('end')" class="mt-2" />
                </div>

                {{-- Indirizzo --}}
                <div class="col-span-full">
                    <x-input-label for="address" value="Luogo / Indirizzo" />
                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full"
                                  :value="old('address', $event->address)" required />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>

                {{-- Immagine Copertina --}}
                <div class="col-span-full">
                    <x-input-label for="cover" value="Cambia Immagine di Copertina" />
                    <input type="file" name="cover" id="cover"
                           class="mt-1 block w-full text-white bg-gray-700 rounded-md border border-gray-600 focus:border-indigo-500 focus:ring-indigo-500">
                    <x-input-error :messages="$errors->get('cover')" class="mt-2" />
                </div>

                {{-- Punti Disponibili --}}
                <div class="col-span-full">
                    <x-input-label for="available_points" value="Punti Disponibili" />
                    <x-text-input id="available_points" name="available_points" type="number"
                                  class="mt-1 block w-full" min="0"
                                  :value="old('available_points', $event->available_points)" required />
                    <x-input-error :messages="$errors->get('available_points')" class="mt-2" />
                </div>

                {{-- Descrizione --}}
                <div class="col-span-full">
                    <x-input-label for="description" value="Descrizione" />
                    <textarea id="description" name="description" rows="4"
                              class="mt-1 block w-full bg-gray-700 text-white rounded-md border border-gray-600 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $event->description) }}</textarea>
                    <x-input-error :messages="$errors->get('description')" class="mt-2" />
                </div>
            </div>

            <div class="flex justify-end gap-4">
                <x-primary-button>
                    <i class="fa-solid fa-floppy-disk me-2"></i> Salva Modifiche
                </x-primary-button>
                <a href="{{ route('admin.events.index') }}" class="text-sm text-gray-400 hover:text-white mt-2">Annulla</a>
            </div>
        </form>
    </div>
</x-app-layout>
