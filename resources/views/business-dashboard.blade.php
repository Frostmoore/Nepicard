<x-app-layout>
    <div class="bg-gray-900 min-h-screen text-white px-4 py-10">
        <h1 class="text-3xl md:text-4xl font-bold mb-10 text-center">Benvenuto nella tua Dashboard Business</h1>

        {{-- 🔷 Tessere Aziendali e Le mie Tessere (affiancati su mobile e desktop) --}}
        <div class="flex flex-wrap justify-center gap-4 mb-6">
            <a href="{{ route('business.mycodes') }}" 
                class="flex-1 min-w-[150px] max-w-[300px] bg-sky-700 hover:bg-sky-600 text-white text-lg font-semibold py-5 px-6 rounded-lg flex items-center justify-center gap-3 shadow transition">
                <i class="fa-solid fa-layer-group text-xl"></i>
                Tessere Aziendali
            </a>

            <a href="{{ route('business.code-association') }}" 
                class="flex-1 min-w-[150px] max-w-[300px] bg-yellow-700 hover:bg-yellow-600 text-white text-lg font-semibold py-5 px-6 rounded-lg flex items-center justify-center gap-3 shadow transition">
                <i class="fa-solid fa-address-card text-xl"></i>
                Le mie Tessere
            </a>
        </div>

        {{-- 🟢 Assegna Punti --}}
        <a href="{{ route('business.assign') }}" 
            class="w-full sm:w-2/3 md:w-1/2 mx-auto bg-emerald-600 hover:bg-emerald-500 text-white text-2xl font-bold py-10 rounded-lg flex items-center justify-center gap-4 shadow-lg transition mb-6">
            <i class="fa-solid fa-coins text-4xl"></i>
            Assegna Punti
        </a>

        {{-- 🟣 Emetti Sconto --}}
        <a href="{{ route('business.discount') }}" 
            class="w-full sm:w-2/3 md:w-1/2 mx-auto bg-indigo-600 hover:bg-indigo-500 text-white text-2xl font-bold py-10 rounded-lg flex items-center justify-center gap-4 shadow-lg transition mb-6">
            <i class="fa-solid fa-ticket text-4xl"></i>
            Emetti Sconto
        </a>

        {{-- 🟡 Verifica Tessera --}}
        <a href="{{ route('business.verify') }}" 
            class="w-full sm:w-2/3 md:w-1/2 mx-auto bg-yellow-600 hover:bg-yellow-500 text-white text-2xl font-bold py-10 rounded-lg flex items-center justify-center gap-4 shadow-lg transition mb-6">
            <i class="fa-solid fa-id-card-clip text-4xl"></i>
            Verifica Tessera
        </a>

        {{-- 🔴 Riscatta Tessera --}}
        <a href="{{ route('business.burn') }}" 
            class="w-full sm:w-2/3 md:w-1/2 mx-auto bg-red-600 hover:bg-red-500 text-white text-2xl font-bold py-10 rounded-lg flex items-center justify-center gap-4 shadow-lg transition">
            <i class="fa-solid fa-fire text-4xl"></i>
            Brucia Tessera
        </a>
    </div>
</x-app-layout>
