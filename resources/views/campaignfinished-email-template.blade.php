@component('mail::message')
# Campaign Finished!

<p>Your campaign {{ $details['campaign_id']}} has been completed.</p>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
