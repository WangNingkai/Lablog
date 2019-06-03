<?php

namespace App\Console\Commands;

use App\Models\Article;
use Illuminate\Console\Command;

class SyncRank extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:rank';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Rank';

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
        $this->info('[' . date('Y-m-d H:i:s') . ']开始执行热度排序');
        $articles = Article::query()->where('status', Article::PUBLISHED)
            ->get();
        foreach ($articles as $article) {
            $score = (int)$article->getAttributeValue('comment_count') ** 2 + (int)$article->getAttributeValue('click') + 1;
            $t = (int)((time()
                    - strtotime($article->getAttributeValue('feed_updated_at')))
                / 3600);
            $rank = $score - 1 / (($t + 2) ** 1.8);
            $article->rank = $rank;
            $article->save();
            $this->info($article->id . '_' . $rank);
        }
        $this->info('[' . date('Y-m-d H:i:s') . ']热度排序执行完成');
    }
}
