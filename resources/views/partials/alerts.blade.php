@if (session('success'))
    <div id="alert-success" class="flex items-center p-4 mb-4 text-sm text-green-300 rounded-lg bg-green-800 relative" role="alert">
        <svg class="flex-shrink-0 w-4 h-4 me-2" data-lucide="check-circle"></svg>
        <div class="mr-6">{{ session('success') }}</div>
        <button type="button" class="absolute top-2 end-2 text-green-200 hover:text-white" data-dismiss-target="#alert-success" aria-label="Chiudi">
            <svg class="w-4 h-4" data-lucide="x"></svg>
        </button>
    </div>
@endif

@if (session('error'))
    <div id="alert-error" class="flex items-center p-4 mb-4 text-sm text-red-300 rounded-lg bg-red-800 relative" role="alert">
        <svg class="flex-shrink-0 w-4 h-4 me-2" data-lucide="x-circle"></svg>
        <div class="mr-6">{{ session('error') }}</div>
        <button type="button" class="absolute top-2 end-2 text-red-200 hover:text-white" data-dismiss-target="#alert-error" aria-label="Chiudi">
            <svg class="w-4 h-4" data-lucide="x"></svg>
        </button>
    </div>
@endif

@if (session('info'))
    <div id="alert-info" class="flex items-center p-4 mb-4 text-sm text-blue-300 rounded-lg bg-blue-800 relative" role="alert">
        <svg class="flex-shrink-0 w-4 h-4 me-2" data-lucide="info"></svg>
        <div class="mr-6">{{ session('info') }}</div>
        <button type="button" class="absolute top-2 end-2 text-blue-200 hover:text-white" data-dismiss-target="#alert-info" aria-label="Chiudi">
            <svg class="w-4 h-4" data-lucide="x"></svg>
        </button>
    </div>
@endif

@if (session('warning'))
    <div id="alert-warning" class="flex items-center p-4 mb-4 text-sm text-yellow-300 rounded-lg bg-yellow-800 relative" role="alert">
        <svg class="flex-shrink-0 w-4 h-4 me-2" data-lucide="alert-triangle"></svg>
        <div class="mr-6">{{ session('warning') }}</div>
        <button type="button" class="absolute top-2 end-2 text-yellow-200 hover:text-white" data-dismiss-target="#alert-warning" aria-label="Chiudi">
            <svg class="w-4 h-4" data-lucide="x"></svg>
        </button>
    </div>
@endif
