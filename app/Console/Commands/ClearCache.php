<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flush:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear All Cache';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('[' . date('Y-m-d H:i:s', time()) . ']开始清理');
        $this->call('view:clear');
        $this->call('view:cache');
        $this->call('cache:clear');
        $this->call('config:clear');
        $this->call('config:cache');
        $this->info('[' . date('Y-m-d H:i:s', time()) . ']清理结束');
    }
}
