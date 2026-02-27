@component('mail::message')
# 🎂 Birthday Reminder

Hi there!

Just a reminder that **{{ $contact->name }}** has a birthday coming up in **{{ $daysUntil }} {{ Str::plural('day', $daysUntil) }}**!

@component('mail::panel')
**Name:** {{ $contact->name }}
**Birthday:** {{ $contact->birthday->format('F j') }}
**Turning:** {{ $contact->age + 1 }}
**Relationship:** {{ $contact->relationship_type }}
@if($contact->interest_tags)
**Interests:** {{ implode(', ', $contact->interest_tags) }}
@endif
@endcomponent

@component('mail::button', ['url' => route('contacts.show', [$contact->family_group_id, $contact])])
View Gift Ideas
@endcomponent

Thanks,
{{ config('app.name') }}
@endcomponent
