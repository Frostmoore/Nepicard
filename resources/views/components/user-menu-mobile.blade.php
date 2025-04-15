@php
    $user = auth()->user();
@endphp

@if($user && $user->role === 'user')
    <div class="md:hidden px-4 pb-4 space-y-2">
        <x-nav-link-mobile route="dashboard" icon="fa-house" label="Dashboard" />
        <x-nav-link-mobile route="profile.edit" icon="fa-user" label="Profilo" />
        {{-- Aggiungi altri link user-specifici qui se serve --}}
    </div>
@endif
