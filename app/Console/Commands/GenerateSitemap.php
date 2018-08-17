<?php

namespace App\Console\Commands;

use App\Helpers\Extensions\SitemapService;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Sitemap';

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
        $this->info('[' . date('Y-m-d H:i:s', time()) . ']开始执行sitemap生成脚本');
        try {
            $sitemapService = new SitemapService();
            $sitemapService->buildIndex();
        } catch (\Exception $exception) {
            $this->error('生成sitemap失败：' . $exception->getMessage());
            return;
        }
        $this->info('[' . date('Y-m-d H:i:s', time()) . ']生成sitemap成功!');
    }
}
