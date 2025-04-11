<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">
            Dettagli Evento
        </h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <div class="bg-gray-800 text-white rounded-xl shadow-lg w-full max-w-4xl p-6 space-y-6">

            {{-- Titolo --}}
            <div class="text-2xl font-bold">{{ $event->name }}</div>

            {{-- Immagine --}}
            @if ($event->cover)
                <div>
                    <img src="{{ asset($event->cover) }}" alt="Copertina evento" class="rounded-lg shadow max-h-64 object-cover">
                </div>
            @endif

            {{-- Date --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-400">Data Inizio</p>
                    <p class="text-lg">{{ \Carbon\Carbon::parse($event->start)->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-400">Data Fine</p>
                    <p class="text-lg">{{ \Carbon\Carbon::parse($event->end)->format('d/m/Y') }}</p>
                </div>
            </div>

            {{-- Luogo --}}
            <div>
                <p class="text-sm text-gray-400">Luogo / Indirizzo</p>
                <p class="text-lg">{{ $event->address }}</p>
            </div>

            {{-- Punti --}}
            <div>
                <p class="text-sm text-gray-400">Punti Disponibili</p>
                <p class="text-lg">{{ $event->available_points }}</p>
            </div>

            {{-- Descrizione --}}
            <div>
                <p class="text-sm text-gray-400">Descrizione</p>
                <p class="text-base mt-1 whitespace-pre-line">{{ $event->description }}</p>
            </div>

            {{-- Azioni --}}
            <div class="flex justify-end gap-4">
                <a href="{{ route('admin.events.edit', $event) }}"
                   class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white text-sm rounded-md hover:bg-yellow-500">
                    <i class="fa-solid fa-pen-to-square me-2"></i> Modifica
                </a>
                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Confermi l\'eliminazione dell\'evento?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm rounded-md hover:bg-red-500">
                        <i class="fa-solid fa-trash me-2"></i> Elimina
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
