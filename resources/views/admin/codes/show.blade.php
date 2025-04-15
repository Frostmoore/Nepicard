<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Dettagli Codice</h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <div class="bg-gray-800 rounded-xl shadow-lg w-full max-w-3xl p-6 text-white space-y-6">
            <h3 class="text-lg font-semibold mb-4">Informazioni Codice</h3>

            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="font-semibold">Codice:</dt>
                    <dd>{{ $code->code }}</dd>
                </div>
                <div>
                    <dt class="font-semibold">Utente:</dt>
                    <dd>{{ $code->user ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold">Azienda:</dt>
                    <dd>{{ $code->company ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold">Punti:</dt>
                    <dd>{{ $code->points ?? '0' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold">Stato:</dt>
                    <dd>
                        @if($code->status === 'active')
                            <span class="text-green-400">Attivo</span>
                        @else
                            <span class="text-red-400">Disattivo</span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="font-semibold">Creato il:</dt>
                    <dd>{{ $code->created_at->format('d/m/Y H:i') }}</dd>
                </div>
            </dl>

            @if($code->qr)
                <div class="mt-6">
                    <h4 class="text-lg font-semibold mb-2">QR Code</h4>
                    <img src="{{ asset($code->qr) }}" alt="QR Code"
                         class="w-48 h-48 object-contain rounded shadow bg-gray-700 p-2">
                </div>
            @endif

            <div class="pt-6 text-right">
                <a href="{{ route('admin.codes.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-700 text-white text-sm rounded-md hover:bg-gray-600 shadow">
                    ← Torna alla lista
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
