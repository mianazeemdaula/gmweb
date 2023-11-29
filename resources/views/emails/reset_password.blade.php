<x-mail::message>
# Reset Password

Your reset password verification code is.

<x-mail::button :url="''">
{{ $code }}
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
