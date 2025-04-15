@php
    $user = auth()->user();
@endphp

@if($user && $user->role === 'business')
    <div class="md:hidden px-4 pb-4 space-y-2">
        <x-nav-link-mobile route="dashboard" icon="fa-house" label="Dashboard" />
        <x-nav-link-mobile route="business.company.edit" icon="fa-building" label="Azienda" />
        <x-nav-link-mobile route="business.analytics" icon="fa-chart-line" label="Statistiche" />
        <x-nav-link-mobile route="business.assign-user" icon="fa-user-plus" label="Utenti Collegati" />
        {{-- Aggiungi altri link business-specifici qui se serve --}}
    </div>
@endif
