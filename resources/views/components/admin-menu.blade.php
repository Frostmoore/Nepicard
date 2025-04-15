@php
    $user = auth()->user();
@endphp

@if($user && in_array($user->role, ['admin', 'superadmin']))
    {{-- Desktop Admin Menu --}}
    <div class="hidden md:flex space-x-8">
        <x-nav-link route="dashboard" icon="fa-house" label="Dashboard" />

        <x-nav-dropdown label="Utenze" icon="fa-users-gear">
            <x-nav-dropdown-link route="roles.index" icon="fa-key" label="Ruoli" />
            <x-nav-dropdown-link route="admin.users.index" icon="fa-users" label="Utenti" />
        </x-nav-dropdown>

        <x-nav-dropdown label="Aziende" icon="fa-building">
            <x-nav-dropdown-link route="admin.companies.index" icon="fa-building" label="Elenco Aziende" />
            <x-nav-dropdown-link route="admin.categories.index" icon="fa-layer-group" label="Categorie Merci" />
        </x-nav-dropdown>

        <x-nav-link route="admin.events.index" icon="fa-calendar-days" label="Eventi" />
        <x-nav-link route="admin.sponsors.index" icon="fa-money-bill-transfer" label="Sponsor" />

        <x-nav-dropdown label="Punti e Tessere" icon="fa-address-card">
            <x-nav-dropdown-link route="admin.codes.index" icon="fa-address-card" label="Tessere" />
            <x-nav-dropdown-link route="admin.packages.index" icon="fa-boxes-stacked" label="Pacchetti Punti" />
        </x-nav-dropdown>
    </div>
@endif
