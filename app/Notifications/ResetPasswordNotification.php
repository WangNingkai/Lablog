<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * ResetPasswordNotification constructor.
     * @param $token
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @return array
     */
    public function via()
    {
        return ['mail'];
    }

    /**
     * @return MailMessage
     */
    public function toMail()
    {
        return (new MailMessage)
            ->subject('密码重置')
            ->greeting('您好！')
            ->salutation('谢谢！')
            ->line('由于您发送了密码重置的请求，我们为您发送了此邮件。')
            ->action('密码重置', url(config('app.url') . route('password.reset', $this->token, false)))
            ->line('如果您未进行密码重置，请忽略此邮件。');

    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [

        ];
    }
}
