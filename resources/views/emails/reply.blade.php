@component('mail::message')
# 您好

{{ $content }}

@component('mail::button', ['url' => $url])
查看
@endcomponent

谢谢,<br>
{{ config('app.name') }}
@endcomponent
