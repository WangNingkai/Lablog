<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'console:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Console Test';

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
        $command = "sudo nohup /usr/bin/bash /root/blog.sh update {$basePath} >> /root/push.log 2>&1 &";
        $this->info('[' . date('Y-m-d H:i:s', time()) . '] =====执行命令=====');
        $this->info('[' . date('Y-m-d H:i:s', time()) . '] [' . $command . ']');
        $this->info('[' . date('Y-m-d H:i:s', time()) . '] ==========');
        $process = new Process($command);
        $process ->run();
        $result =  $process->isSuccessful();
        $this->info('[' . date('Y-m-d H:i:s', time()) . '] 执行结果：'.$result);
        $this->info('[' . date('Y-m-d H:i:s', time()) . '] 输出结果：'.$process->getOutput());

    }
}
