@component('mail::message')
# The status of an idea you voted has updated

Idea: {{ $idea->title }} <br />
Updated Status: {{ $idea->status->name }}

@component('mail::button', ['url' => route("idea.show", $idea)])
View Idea
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent