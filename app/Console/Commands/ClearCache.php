<?php

namespace App\Console\Commands;

use App\Models\Config;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

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
        $this->info('[' . date('Y-m-d H:i:s', time()) . ']开始清理重建缓存');
        $this->call('view:clear');
        $this->call('view:cache');
        $this->call('config:cache');
        Cache::forget('cache:config');
        Cache::remember('cache:config', 1440, function () {
            return Config::query()->pluck('value', 'name');
        });
        $this->info('[' . date('Y-m-d H:i:s', time()) . ']操作结束');
    }
}
