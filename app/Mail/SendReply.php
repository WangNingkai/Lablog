<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendReply extends Mailable
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
     * @var string 跳转链接
     */
    public $url = '';

    /**
     * SendReply constructor.
     * @param $subject
     * @param $content
     * @param $url
     */
    public function __construct($subject,$content,$url)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subject)->with([
            'content' => $this->content,
            'url'     => $this->url
        ])->markdown('emails.reply');
    }
}
