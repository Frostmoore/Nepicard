@props(['status'])

@if ($status)
    <div {{ $attributes->merge([
        'class' => 'text-sm font-medium text-green-400 mt-2 flex items-center gap-2'
    ]) }}>
        <i class="fa-solid fa-circle-check"></i> {{ $status }}
    </div>
@endif
