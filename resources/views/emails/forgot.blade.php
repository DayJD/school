@component('mail::message')
    <p>
        Hello {{ $user->name }},

        We need a computer.

        @component('mail::button', ['url' => url('reset/' . $user->remember_token)])
            Reset Password
        @endcomponent

        In case you have any issues

        Thanks,<br>
    </p>
    {{ config('app.name') }}
@endcomponent
