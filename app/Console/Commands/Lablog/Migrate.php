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
    protected $description = '初始化迁移文件';

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
        $this->warn('========== 请手动执行注册用户 ==========');
        $this->info('php artisan lablog:register');
    }
}
