@component('mail::message')
    Hello {{ $user->name }}
    <p>
        {!! $user->send_message !!}
        
    Thank you,<br>
    </p>


    {{ config('app.name') }}
@endcomponent
