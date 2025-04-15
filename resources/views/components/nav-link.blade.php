@props(['route', 'icon', 'label'])

<a href="{{ route($route) }}"
   class="{{ request()->routeIs($route) ? 'text-white border-b-2 border-white pb-1' : 'text-gray-300 hover:text-white' }} text-sm font-medium transition">
    <i class="fa-solid {{ $icon }} me-1"></i> {{ $label }}
</a>
