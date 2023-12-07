@component('mail::message')
<h1>Hallo {{$name}}</h1>

Je ontvangt deze e-mail omdat we een wachtwoordherstel verzoek hebben ontvangen voor je account.

@component('mail::button',  ['url' => $url])
Wachtwoord herstellen
@endcomponent

Deze link om je wachtwoord te herstellen verloopt over 60 minuten.

Als je geen wachtwoordherstel hebt aangevraagd, hoef je verder niets te doen.
<p>
Met vriendelijke groet, <br/>
{{ config('app.name') }}
</p>
@endcomponent
