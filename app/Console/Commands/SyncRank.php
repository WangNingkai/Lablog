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
        $articles =Article::query()->where('status',Article::PUBLISHED)->get();
        foreach ($articles as $article) {
            $score = pow(intval($article->getAttributeValue('comment_count')),2) + intval($article->getAttributeValue('click')) + 1;
            $t = intval((time() - strtotime($article->getAttributeValue('feed_updated_at'))) / 3600);
            $rank = $score - 1 / (pow(($t + 2),1.8));
            $article->rank = $rank;
            $article->save();
            $this->info($rank);
        }
    }
}
