<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Eventi</h2>
    </x-slot>

    <div class="mt-6 flex justify-end">
        <a href="{{ route('admin.events.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-500">
            <i class="fa-solid fa-plus me-2"></i> Aggiungi Evento
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        @forelse($events as $event)
            <div class="bg-gray-800 rounded-xl shadow p-5 hover:shadow-lg transition flex flex-col justify-between">
            <div>
                @if ($event->cover)
                    <div class="w-full h-48 rounded-lg overflow-hidden mb-4">
                        <img src="{{ asset($event->cover) }}"
                            alt="Copertina evento"
                            class="w-full h-full object-cover object-center">
                    </div>
                @endif

                <h3 class="text-lg font-semibold text-white mb-2">{{ $event->name }}</h3>
                <p class="text-sm text-gray-300 mb-1"><strong>Data:</strong> {{ \Carbon\Carbon::parse($event->start)->format('d/m/Y') }} – {{ \Carbon\Carbon::parse($event->end)->format('d/m/Y') }}</p>
                <p class="text-sm text-gray-300 mb-1"><strong>Luogo:</strong> {{ $event->address }}</p>
                <p class="text-sm text-gray-300"><strong>Punti disponibili:</strong> {{ $event->available_points ?? 0 }}</p>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <a href="{{ route('admin.events.show', $event) }}"
                class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs rounded-md hover:bg-indigo-500">
                    <i class="fa-solid fa-eye me-1"></i> Vedi
                </a>
                <a href="{{ route('admin.events.edit', $event) }}"
                class="inline-flex items-center px-3 py-1.5 bg-yellow-600 text-white text-xs rounded-md hover:bg-yellow-500">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Modifica
                </a>
                <form action="{{ route('admin.events.destroy', $event) }}" method="POST" onsubmit="return confirm('Confermi eliminazione?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-xs rounded-md hover:bg-red-500">
                        <i class="fa-solid fa-trash me-1"></i> Elimina
                    </button>
                </form>
            </div>
        </div>

        @empty
            <div class="col-span-full text-center text-gray-500">
                Nessun evento disponibile.
            </div>
        @endforelse
    </div>
</x-app-layout>
