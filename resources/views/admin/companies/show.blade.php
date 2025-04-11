<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Dettagli Azienda</h2>
    </x-slot>

    <div class="mt-6 flex justify-center">
        <div class="bg-gray-800 rounded-xl shadow-lg w-full max-w-4xl p-6 text-white space-y-4">
            <h3 class="text-lg font-semibold">Informazioni Azienda</h3>

            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><dt class="font-semibold">Nome:</dt><dd>{{ $company->name }}</dd></div>
                <div><dt class="font-semibold">Email:</dt><dd>{{ $company->email }}</dd></div>
                <div><dt class="font-semibold">Telefono:</dt><dd>{{ $company->phone }}</dd></div>
                <div><dt class="font-semibold">Indirizzo:</dt><dd>{{ $company->address }}</dd></div>
                <div><dt class="font-semibold">Coordinate:</dt><dd>{{ $company->coordinates }}</dd></div>
                <div><dt class="font-semibold">Sito Web:</dt><dd>{{ $company->website }}</dd></div>
                <div><dt class="font-semibold">Categoria:</dt><dd>{{ $company->category }}</dd></div>
                <div><dt class="font-semibold">Partita IVA:</dt><dd>{{ $company->piva }}</dd></div>
                <div><dt class="font-semibold">Codice Fiscale:</dt><dd>{{ $company->cf }}</dd></div>
                <div><dt class="font-semibold">PEC:</dt><dd>{{ $company->pec }}</dd></div>
                <div><dt class="font-semibold">Codice Univoco:</dt><dd>{{ $company->codice_univoco }}</dd></div>
                <div><dt class="font-semibold">Punti:</dt><dd>{{ $company->points }}</dd></div>
                <div><dt class="font-semibold">Stato:</dt>
                    <dd>
                        @if($company->status)
                            <span class="text-green-400">Attiva</span>
                        @else
                            <span class="text-red-400">Disattiva</span>
                        @endif
                    </dd>
                </div>
            </dl>

            <div class="pt-4 text-right space-x-3">
                <a href="{{ route('admin.companies.edit', $company) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded hover:bg-yellow-500">
                    <i class="fa-solid fa-pen-to-square me-2"></i> Modifica
                </a>
                <a href="{{ route('admin.companies.index') }}" class="text-sm text-gray-400 hover:text-white">← Torna alla lista</a>
            </div>
        </div>
    </div>
</x-app-layout>
