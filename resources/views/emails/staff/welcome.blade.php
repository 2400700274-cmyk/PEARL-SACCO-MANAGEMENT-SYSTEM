<x-mail::message>
# Welcome to {{ $saccoName }}

Hello {{ $staff->name }},

An account has been created for you as **{{ $staff->role->name }}** at {{ $saccoName }}.

You can log in to the system using the following credentials:

**Email Address:** {{ $staff->email }}  
**Temporary Password:** {{ $plainPassword }}

<x-mail::button :url="route('login')">
Sign In to Your Account
</x-mail::button>

*For security reasons, we highly recommend changing your password after your first login.*

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
