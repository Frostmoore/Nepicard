@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['class' => 'text-sm text-red-400 space-y-1 mt-2']) }}>
        @foreach ((array) $messages as $message)
            <li><i class="fa-solid fa-circle-exclamation me-1"></i> {{ $message }}</li>
        @endforeach
    </ul>
@endif
