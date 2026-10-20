<x-mail::message>
# Welcome to {{ \App\Models\Setting::getValue('sacco_name', 'Pearl SACCO Management System') }}, {{ $member->name }}!

We are thrilled to welcome you as a member of our SACCO. Your registration is complete and your Member Number is **{{ $member->member_number }}**.

<x-mail::panel>
**Member Details:**
- **Name:** {{ $member->name }}
- **Member Number:** {{ $member->member_number }}
- **Registration Date:** {{ $member->registered_at->format('M d, Y') }}
</x-mail::panel>

We look forward to growing together. Please keep your member number safe as you will need it for transactions.

Thanks,<br>
{{ \App\Models\Setting::getValue('sacco_name', 'Pearl SACCO Management System') }}
</x-mail::message>
