@props(['route', 'icon' => null, 'label'])

<a href="{{ route($route) }}"
   class="block px-4 py-2 text-sm text-gray-300 hover:text-white transition">
    @if($icon)
        <i class="fa-solid {{ $icon }} me-2 w-4 text-gray-400"></i>
    @endif
    {{ $label }}
</a>
