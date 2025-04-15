@php
    $user = auth()->user();
@endphp

@if($user && $user->role === 'business')
    <div class="hidden md:flex space-x-8">
        <x-nav-link route="dashboard" icon="fa-house" label="Dashboard" />
        <x-nav-link route="business.company.edit" icon="fa-building" label="Azienda" />
        <x-nav-link route="business.analytics" icon="fa-chart-line" label="Statistiche" />
        <x-nav-link route="business.assign-user" icon="fa-user-plus" label="Utenti Collegati" />
        {{-- Aggiungi qui altri link business-specifici --}}
    </div>
@endif
