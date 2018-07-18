@component('mail::message')
# 站长，您好！

{{ $content }}

@component('mail::button', ['url' => route('login')])
登陆后台
@endcomponent

谢谢,<br>
{{ config('app.name') }}
@endcomponent
