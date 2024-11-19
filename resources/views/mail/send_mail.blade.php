@component('mail::message')
Hello  {{ $user->name}} {{ $user->last_name}}

{!! $user->send_message !!}


Thanks,<br>
{{ config('app.name') }}
@endcomponent