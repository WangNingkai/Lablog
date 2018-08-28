<?php

namespace App\Jobs;

use App\Helpers\Extensions\Tool;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class QrcodeGenerate implements ShouldQueue
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
    public $timeout = 300;

    /**
     * 二维码内容
     *
     * @var
     */
    protected $text;

    /**
     * 二维码大小
     *
     * @var
     */
    protected $size;

    /**
     * 初始化二维码
     *
     * QrcodeGenerate constructor.
     * @param array $param 参数
     */
    public function __construct($param)
    {
        $this->text = $param['text'];
        $this->size = $param['size'];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Tool::qrcodeGenerate($this->text,$this->size);
    }
}
