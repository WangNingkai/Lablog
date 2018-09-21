<?php

namespace App\Console\Commands\Lablog;

use Illuminate\Console\Command;

class Migrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lablog:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lablog Migrate';

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
     * 执行迁移
     *
     */
    public function handle()
    {
        $this->call('migrate');
        $this->warn('========== 正在执行注册用户 ==========');
        $this->call('lablog:register');
        $this->warn('========== 正在执行迁移文件 ==========');
        $this->call('db:seed');
        $this->warn('========== 安装完成 ==========');
        $this->warn('更多配置项请访问根目录.env文件');
    }
}
