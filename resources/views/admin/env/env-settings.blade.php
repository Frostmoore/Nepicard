<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-white leading-tight">Impostazioni di Sistema (.env)</h2>
    </x-slot>

    <div class="mt-6 max-w-4xl mx-auto bg-gray-800 rounded-xl shadow p-6 text-white">
        <form method="POST" action="{{ route('admin.env.update') }}">
            @csrf

            @php
                $sections = [
                    'Informazioni di Base' => $appSettings,
                    'Database' => $dbSettings,
                    'Email' => $mailSettings,
                ];
            @endphp

            <div x-data="{ open: null }" class="space-y-6">
                @foreach ($sections as $title => $group)
                    <div class="border border-gray-600 rounded-md overflow-hidden">
                        <button type="button"
                                class="w-full bg-gray-700 px-4 py-3 text-left text-white font-semibold hover:bg-gray-600 transition"
                                @click="open === '{{ $title }}' ? open = null : open = '{{ $title }}'">
                            {{ $title }}
                        </button>
                        <div x-show="open === '{{ $title }}'" x-transition class="p-4 space-y-4 bg-gray-800">
                            @foreach ($group as $key => $val)
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1" for="{{ $key }}">{{ $key }}</label>
                                    <input type="text" name="{{ $key }}" id="{{ $key }}" value="{{ $val }}"
                                           class="w-full bg-gray-700 border border-gray-600 text-white rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 text-right">
                <x-primary-button>
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Salva Impostazioni
                </x-primary-button>
            </div>
        </form>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @endpush
</x-app-layout>
