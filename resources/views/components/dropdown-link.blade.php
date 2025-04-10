<a {{ $attributes->merge([
    'class' => 'block w-full px-4 py-2 text-start text-sm text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-600 transition duration-150 ease-in-out'
]) }}>
    {{ $slot }}
</a>
