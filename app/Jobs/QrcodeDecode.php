<?php

namespace App\Jobs;

use App\Helpers\Extensions\Tool;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class QrcodeDecode implements ShouldQueue
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
     * 二维码地址
     *
     * @var
     */
    protected $img;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($img)
    {
        $this->img = $img;
    }

    /**
     * Execute the job.
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        Tool::qrcodeDecode($this->img);
    }
}
