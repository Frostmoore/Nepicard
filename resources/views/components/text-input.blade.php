@props(['disabled' => false])

<input
    @disabled($disabled)
    {{ $attributes->merge([
        'class' => 'bg-gray-800 border border-gray-600 text-white text-sm rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 placeholder-gray-400 disabled:opacity-60 disabled:cursor-not-allowed'
    ]) }}
>
