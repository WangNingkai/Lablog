<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReminder extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var string 主题
     */
    public $subject = '';

    /**
     * @var string 内容
     */
    public $content = '';

    /**
     * SendReminder constructor.
     * @param $subject
     * @param $content
     */
    public function __construct($subject,$content)
    {
        $this->subject = $subject;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->with([
            'content' => $this->content
        ])->markdown('emails.reminder');
    }
}
