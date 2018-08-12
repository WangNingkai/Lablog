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
    protected $description = 'Lablog Migration';

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
     * 执行迁移填充
     *
     */
    public function handle()
    {
        $this->call('key:generate');
        $this->call('migrate');
        $this->call('db:seed');
        $this->info('*************** 安装完成 ***************');
        $this->line('后台链接：/admin');
        $this->line('超级管理员邮箱：admin@admin.com ');
        $this->line('超级管理员密码：12345678');
    }
}
