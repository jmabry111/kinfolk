@component('mail::message')
# Welcome to Kinfolk, {{ $recipient->name }}! 🎉

You've been added as a member of **{{ $group->name }}**.

Kinfolk helps you keep track of the people you love — their birthdays, gift ideas, and the holidays you celebrate together.

Here's what you can do:

@component('mail::panel')
**🎂 Track Birthdays**
See upcoming birthdays for everyone in your group, organized by how soon they are.

**🎁 Share Gift Ideas**
Add gift ideas for contacts in your group. Mark them public so others can coordinate, or keep them private just for you.

**🎄 Christmas Lists**
Build a Christmas list for your group — add gifts and print or save it as a PDF.

**📧 Reminders**
You'll receive email reminders 30 days and 7 days before upcoming birthdays so you're never caught off guard.
@endcomponent

@component('mail::button', ['url' => route('family-groups.show', $group)])
View {{ $group->name }}
@endcomponent

---

*"{{ $verse['text'] }}"*
**— {{ $verse['reference'] }}**

Thanks for joining,
The Kinfolk Team
@endcomponent
