<x-mail::message>
# Loan Application Approved

Dear {{ $loan->member->name }},

We are pleased to inform you that your loan application has been approved!

<x-mail::panel>
**Loan Details:**
- **Loan Number:** {{ $loan->loan_number }}
- **Principal Amount:** {{ \App\Models\Setting::getValue('currency', 'UGX') }} {{ number_format($loan->principal_amount, 2) }}
- **Interest Rate:** {{ $loan->interest_rate }}%
- **Duration:** {{ $loan->duration_months }} months
- **Expected Repayment Date:** {{ $loan->end_date->format('M d, Y') }}
</x-mail::panel>

The funds will be disbursed to you shortly according to your requested payout method. If you have any questions, please contact our office.

Thanks,<br>
{{ \App\Models\Setting::getValue('sacco_name', 'Kulima Agri-SACCO') }}
</x-mail::message>
