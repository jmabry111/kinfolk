@component('mail::message')
# 🎂 Birthday Reminder

Hi there!

Just a reminder that **{{ $contact->name }}** has a birthday coming up in **{{ $daysUntil }} {{ Str::plural('day', $daysUntil) }}**!

@component('mail::panel')
**Name:** {{ $contact->name }}
**Birthday:** {{ $contact->birthday->format('F j') }}@if(!$contact->birth_year_unknown) {{ $contact->birthday->format('Y') }}@endif
@if($contact->birth_year_unknown)
**Generation:** {{ $contact->generation ?? 'Unknown' }}
@else
**Turning:** {{ $contact->birthday->age + 1 }}
@endif
**Relationship:** {{ $contact->relationship_type }}
@if($contact->interest_tags)
**Interests:** {{ implode(', ', $contact->interest_tags) }}
@endif
@endcomponent

@component('mail::button', ['url' => route('contacts.show', [$contact->family_group_id, $contact])])
View Gift Ideas
@endcomponent

---

@if(count($upcomingHolidays) > 0)
## 🗓️ Upcoming Holidays

Don't forget these holidays are coming up too:

@foreach($upcomingHolidays as $holiday)
- **{{ $holiday['name'] }}** — {{ $holiday['formatted'] }}
@if($holiday['days_away'] === 0)
  *(Today!)*
@elseif($holiday['days_away'] === 1)
  *(Tomorrow)*
@else
  *(in {{ $holiday['days_away'] }} days)*
@endif
@endforeach

@endif

Thanks,
{{ config('app.name') }}
@endcomponent
