@component('mail::message')
# HR posted the following job

#### Title:
{{ $job->title }}

#### Description:
{{ $job->description }}


Select desired action for this job:
1. [Publish it]({{ url('/jobs/approve/'.$job->moderate_token) }})
2. [Send to spam]({{ url('/jobs/spam/'.$job->moderate_token) }})

Thanks,<br>
{{ config('app.name') }}
@endcomponent
