@props([
    'name',
    'label' => null,
    'options' => [],
    'optionValue' => null,
    'optionLabel' => null,
    'selected' => null,
])

<div>
    @if ($label)
        <x-input-label :for="$name" :value="$label" />
    @endif

    <select name="{{ $name }}" id="{{ $name }}"
            {{ $attributes->merge(['class' => 'mt-1 mb-4 w-full rounded-md bg-gray-700 text-white border-gray-600 shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500']) }}>
        <option value="">-- Seleziona --</option>

        @foreach ($options as $item)
            @php
                $value = $optionValue
                    ? (is_array($item) ? data_get($item, $optionValue) : data_get($item, $optionValue))
                    : (is_array($item) ? $item : $item);

                $text = $optionLabel
                    ? (is_array($item) ? data_get($item, $optionLabel) : data_get($item, $optionLabel))
                    : (is_array($item) ? $item : $item);
            @endphp

            <option value="{{ $value }}" @selected($selected == $value)>
                {{ $text }}
            </option>
        @endforeach
    </select>

    <x-input-error :messages="$errors->get($name)" class="mt-2" />
</div>
