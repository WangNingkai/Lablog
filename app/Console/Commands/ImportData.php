<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '调试导入数据';

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
        $this->info('========== 导入数据开始 ==========');
        $articles = DB::table('articles')->select('id','content','html')->get();
        foreach ($articles as $article) {
            DB::table('feeds')->insert([
                'target_type' => '0',
                'target_id' => $article->id,
                'content' => $article->content,
                'html' => $article->html,
            ]);
            $this->info('article_' . $article->id . '_import_done');
        }
        $pages = DB::table('pages')->select('id','content','html')->get();
        foreach ($pages as $page) {
            DB::table('feeds')->insert([
                'target_type' => '1',
                'target_id' => $page->id,
                'content' => $page->content,
                'html' => $page->html,
            ]);
            $this->info('page_' . $page->id . '_import_done');
        }
        $this->info('========== 导入数据结束 ==========');
    }
}
