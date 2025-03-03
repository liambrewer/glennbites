<x-mail::message>
# Your one-time login code is:

<x-mail::panel>
<div style="font-size: 24px; text-align: center; letter-spacing: 8px; font-weight: bold;">
    {{ $code }}
</div>
</x-mail::panel>

This code will expire in 5 minutes.

If you didn't request this code, you can safely ignore this email.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
