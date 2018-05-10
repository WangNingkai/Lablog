@component('mail::message')
# 您好

您在我站的留言，站长已经回复，请注意查看.

@component('mail::button', ['url' => route('message')])
查看
@endcomponent

谢谢,<br>
{{ config('app.name') }}
@endcomponent
