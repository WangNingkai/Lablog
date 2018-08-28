<?php

namespace App\Console\Commands\Lablog;

use Illuminate\Console\Command;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lablog:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lablog Init';

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
     * 安装开始
     */
    public function handle()
    {
        /**
         * 获取并替换 .env 中的数据库账号密码
         */
        $this->warn('========== 初始化配置 ==========');
        $this->call('lablog:init');
        $this->warn('========== 请手动执行 ==========');
        $this->info('php artisan lablog:migrate');


    }
}
