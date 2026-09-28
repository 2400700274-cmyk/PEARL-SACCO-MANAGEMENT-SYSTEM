<x-mail::message>
# Welcome to Kulima Agri-SACCO

Dear {{ $user->name }},

Your administrative workspace for **{{ $saccoName }}** has been successfully created. 

You can now start managing your cooperative, adding members, and recording transactions.

<x-mail::button :url="route('login')">
Go to Dashboard
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
