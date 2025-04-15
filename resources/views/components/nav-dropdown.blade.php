@props(['label', 'icon'])

<div class="relative group">
    <button class="text-gray-300 hover:text-white text-sm font-medium transition flex items-center gap-1">
        <i class="fa-solid {{ $icon }}"></i> {{ $label }}
        <i class="fa-solid fa-chevron-down text-xs"></i>
    </button>
    <div class="absolute hidden group-hover:block bg-gray-800 shadow-md rounded mt-2 w-52 z-50">
        {{ $slot }}
    </div>
</div>
