<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务最大尝试次数。
     *
     * @var int
     */
    public $tries = 5;

    /**
     * 任务运行的超时时间。
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * 收件人邮箱地址
     *
     * @var
     */
    protected $email;

    /**
     * 收件人名称
     *
     * @var
     */
    protected $name;

    /**
     * 邮件标题
     *
     * @var
     */
    protected $subject;

    /**
     * 邮件内容数据
     *
     * @var $content
     */
    protected $data;

    /**
     * SendEmail constructor.
     * @param $param
     */
    public function __construct($param)
    {
        $this->email = $param['email'];
        $this->name = $param['name'];
        $this->subject = $param['subject'];
        $this->data = $param['data'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        send_email($this->email, $this->name, $this->subject, $this->data, 'emails.base');
    }
}
