@php
    $user = auth()->user();
@endphp

@if($user && in_array($user->role, ['admin', 'superadmin']))
    <div class="md:hidden py-2 space-y-2">

        <x-nav-link-mobile route="dashboard" icon="fa-house" label="Dashboard" />

        <x-nav-dropdown-mobile label="Utenze" icon="fa-users-gear">
            <x-nav-dropdown-link-mobile route="roles.index" icon="fa-key" label="Ruoli" />
            <x-nav-dropdown-link-mobile route="admin.users.index" icon="fa-users" label="Utenti" />
        </x-nav-dropdown-mobile>

        <x-nav-dropdown-mobile label="Aziende" icon="fa-building">
            <x-nav-dropdown-link-mobile route="admin.companies.index" icon="fa-building" label="Elenco Aziende" />
            <x-nav-dropdown-link-mobile route="admin.categories.index" icon="fa-layer-group" label="Categorie Merci" />
        </x-nav-dropdown-mobile>

        <x-nav-dropdown-mobile label="Eventi & Sponsor" icon="fa-calendar-days">
            <x-nav-dropdown-link-mobile route="admin.events.index" icon="fa-calendar-days" label="Eventi" />
            <x-nav-dropdown-link-mobile route="admin.sponsors.index" icon="fa-money-bill-transfer" label="Sponsor" />
        </x-nav-dropdown-mobile>

        <x-nav-dropdown-mobile label="Punti e Tessere" icon="fa-address-card">
            <x-nav-dropdown-link-mobile route="admin.codes.index" icon="fa-address-card" label="Tessere" />
            <x-nav-dropdown-link-mobile route="admin.packages.index" icon="fa-boxes-stacked" label="Pacchetti Punti" />
        </x-nav-dropdown-mobile>

    </div>
@endif
