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
        // 先给shell脚本执行权限 chmod +x laravel.sh
        $shellPath = '/root/project/shell/laravel.sh';
        $basePath = base_path();
        $command = "sudo /usr/bin/bash {$shellPath} update {$basePath} >> /data/wwwlogs/lablog_pull.log 2>&1 &";
        $this->info('[' . date('Y-m-d H:i:s') . '] =====执行命令=====');
        $process = new Process($command);
        $process->run();
        $this->info('[' . date('Y-m-d H:i:s') . '] [' . $command . ']');
        $result = $process->isSuccessful();
        $this->info('[' . date('Y-m-d H:i:s') . '] =====执行完毕=====');
        $this->info('[' . date('Y-m-d H:i:s') . '] 执行结果：' . $result);
        $this->info('[' . date('Y-m-d H:i:s') . '] 输出结果：' . $process->getOutput());

    }
}
