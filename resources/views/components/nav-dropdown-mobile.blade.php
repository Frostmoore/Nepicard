@props(['label', 'icon' => null])

<div x-data="{ open: false }" class="space-y-1">
    <button @click="open = !open"
            class="w-full flex justify-between items-center px-4 py-2 text-sm text-gray-300 hover:text-white transition">
        <span>
            @if($icon)
                <i class="fa-solid {{ $icon }} me-2 w-4 text-gray-400"></i>
            @endif
            {{ $label }}
        </span>
        <i class="fa-solid" :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
    </button>
    <div x-show="open" x-cloak class="space-y-1">
        {{ $slot }}
    </div>
</div>
