@php
    $user = auth()->user();
@endphp

@if($user && $user->role === 'user')
    <div class="hidden md:flex space-x-8">
        <x-nav-link route="dashboard" icon="fa-house" label="Dashboard" />
        <x-nav-link route="profile.edit" icon="fa-user" label="Profilo" />
        {{-- Aggiungi qui altri link user-specifici --}}
    </div>
@endif
