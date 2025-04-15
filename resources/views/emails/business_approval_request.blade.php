@component('mail::message')
# Nuovo account Business da approvare

Un nuovo utente business ha richiesto la registrazione:

- **Nome:** {{ $user->name }} {{ $user->surname }}
- **Email:** {{ $user->email }}
- **Azienda:** {{ optional($user->companyRel)->name ?? 'Non specificata' }}

@component('mail::button', ['url' => route('admin.approve.business', ['user' => $user->id])])
Approva Account
@endcomponent

Grazie,<br>
{{ config('app.name') }}
@endcomponent
