@props(['route', 'icon', 'label'])

<a href="{{ route($route) }}"
   class="block px-4 py-2 text-sm text-gray-300 hover:bg-gray-700 hover:text-white">
    <i class="fa-solid {{ $icon }} me-2"></i> {{ $label }}
</a>
