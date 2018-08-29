<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class UpdatePush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'git:pull';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pull Git Repo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $basePath =base_path();
        $command = "sudo /usr/bin/bash /root/blog.sh update {$basePath} >> /data/wwwlogs/lablog/pull.log 2>&1 &";
        $this->info('[' . date('Y-m-d H:i:s', time()) . '] =====执行命令=====');
        $process = new Process($command);
        $process ->run();
        $this->info('[' . date('Y-m-d H:i:s', time()) . '] [' . $command . ']');
        $result = $process->isSuccessful();
        $this->info('[' . date('Y-m-d H:i:s', time()) . '] =====执行完毕=====');
        $this->info('[' . date('Y-m-d H:i:s', time()) . '] 执行结果：'.$result);
        $this->info('[' . date('Y-m-d H:i:s', time()) . '] 输出结果：'.$process->getOutput());

    }
}
