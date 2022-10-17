@component('mail::message')
# Introduction

<h2>Hello Mr. {{ $user->name }}</h2>
Thank you Mr {{ $user->name }} for join wih us. you get all update {{ $user->email }} this mail.

The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
