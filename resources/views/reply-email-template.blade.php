@component('mail::message')
# Introduction

The body of your message.
<h1>{{ $details['first_name']}}</h1>
<h1>{{ $details['last_name']}}</h1>
<h1>{{ $details['email']}}</h1>
<h1>{{ $details['message']}}</h1>


@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
