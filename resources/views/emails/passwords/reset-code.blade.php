@component('mail::message')
# 🔐 Réinitialisation de mot de passe

Bonjour,

Vous avez demandé à réinitialiser votre mot de passe.
Voici votre **code de sécurité** à usage unique :

@component('mail::panel')
## {{ $code }}
@endcomponent

Ce code est valable pendant **15 minutes**.
Si vous n’avez pas fait cette demande, vous pouvez ignorer ce message.

@component('mail::subcopy')
Ce message vous a été envoyé automatiquement suite à une demande de réinitialisation sur votre compte.
@endcomponent

Cordialement,
L’équipe {{ config('app.name') }}
@endcomponent
