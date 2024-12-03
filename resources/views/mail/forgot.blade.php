@component('mail::message')
Hello  {{ $user->name}}

<p>We understand it happens. </p>

@component('mail::button', ['url' => url('reset/'.$user->remember_token)])
Reset your Passwword
@endcomponent

<p> In case you have any issues recovering your password, Pleaase contact us</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent



