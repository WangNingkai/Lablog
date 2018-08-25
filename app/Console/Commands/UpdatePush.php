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
        $command = "sudo nohup /usr/bin/bash /root/blog.sh update {$basePath} >> /root/push.log 2>&1 &";
        $this->info('[' . date('Y-m-d H:i:s', time()) . '] =====执行命令=====');
        $process = new Process($command);
        $process ->run();
        $this->info('[' . date('Y-m-d H:i:s', time()) . '] [' . $command . ']');
        $result = $process->isSuccessful();
        $this->info('[' . date('Y-m-d H:i:s', time()) . '] =====执行完毕=====');
        $this->info('[' . date('Y-m-d H:i:s', time()) . '] 执行结果：'.$result);
        $this->info('[' . date('Y-m-d H:i:s', time()) . '] 输出结果：'.$process->getOutput());

    }
/* blog.sh 脚本

#!/usr/bin/env bash
PATH=/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/php/bin:/usr/local/sbin:~/bin
export PATH

msg=$1

path=$2

cd ${path}

case ${msg} in
  pull)
  git fetch --all
  git reset --hard origin/master
;;
  clear)
  /usr/local/php/bin/php artisan clear
/usr/local/php/bin/php artisan cache:clear
/usr/local/php/bin/php artisan config:clear
;;
  update)
  git pull
/usr/local/bin/composer update
;;
 esac

*/
}
