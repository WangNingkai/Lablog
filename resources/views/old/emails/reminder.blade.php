@component('mail::message')
# 站长，您好！

您的个人博客现有新的留言，请注意查看审核。

@component('mail::button', ['url' => route('login')])
登陆后台
@endcomponent

谢谢,<br>
{{ config('app.name') }}
@endcomponent
