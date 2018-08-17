<?php
namespace App\Helpers\Extensions;

use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use App\Models\Tag;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

class SitemapService
{
    public function init()
    {
        $sitemap = App::make ("sitemap");
        if ($this->createHome()) {
            $sitemap->addSitemap(config('app.url') . '/sitemap/home.xml', date(DATE_RFC3339, time()));
        }
        if ($this->createArchive()) {
            $sitemap->addSitemap(config('app.url') . '/sitemap/archive.xml', date(DATE_RFC3339, time()));
        }
        if ($lastModTime = $this->createTags()) {
            $sitemap->addSitemap(config('app.url') . '/sitemap/tags.xml', date(DATE_RFC3339, $lastModTime));
        }
        if ($lastModTime = $this->createCategories()) {
            $sitemap->addSitemap(config('app.url') . '/sitemap/categories.xml', date(DATE_RFC3339, $lastModTime));
        }
        if ($lastModTime = $this->createPages()) {
            $sitemap->addSitemap(config('app.url') . '/sitemap/pages.xml', date(DATE_RFC3339, $lastModTime));
        }
        if ($lastModTimes = $this->createArticles()) {
            foreach ($lastModTimes as $name => $time) {
                $sitemap->addSitemap(config('app.url') . '/sitemap/articles-' . $name . '.xml', date(DATE_RFC3339, $time));
            }
        }
        $sitemap->store('sitemapindex', 'sitemap');

    }

    public function createHome()
    {
        $sitemap = App::make("sitemap");
        $sitemap->add(route('home'), date(DATE_RFC3339, time()), '1.0', 'daily');
        $info = $sitemap->store('xml', 'home', public_path('sitemap'));
        Log::info($info);
        return true;
    }
    public function createArchive()
    {
        $sitemap = App::make("sitemap");
        $sitemap->add(route('archive'), date(DATE_RFC3339, time()), '1.0', 'daily');
        $info = $sitemap->store('xml', 'archive', public_path('sitemap'));
        Log::info($info);
        return true;
    }
    public function createArticles(){
        $sitemap = App::make("sitemap");
        $sitemapName = '';
        $articlesData = [];
        Article::query()->select('id', 'created_at', 'updated_at')->chunk(100,function ($articles) use (&$articlesData, &$sitemapName) {
            foreach ($articles as $article) {
                $sitemapName = date('Y-m', strtotime($article->feed->created_at));
                $articlesData[$sitemapName][] = [
                    'url' => route('article', ['id' => $article->id]),
                    'lastmod' => strtotime($article->feed->updated_at)
                ];
            }
        });
        $lastModTimes = [];
        foreach ($articlesData as $name => $data) {
            $lastModTime = 0;
            foreach ($data as $_data) {
                if ($_data['lastmod'] > $lastModTime) {
                    $lastModTime = $_data['lastmod'];
                }
                $sitemap->add($_data['url'], date(DATE_RFC3339, $_data['lastmod']), '0.8', 'daily');
            }
            $info = $sitemap->store('xml','articles-' . $name, public_path('sitemap'));
            $lastModTimes[$name] = $lastModTime;
            Log::info($info);
            $sitemap->model->resetItems();
        }
        return $lastModTimes;
    }

    public function createPages()
    {
        $sitemap = App::make("sitemap");
        $lastModTime = 0;

        $pages = Page::query()->select('id','title','updated_at')->get();
        foreach ($pages as $page) {
            $pageLastModTime = strtotime($page->feed->updated_at);
            if ($pageLastModTime > $lastModTime) {
                $lastModTime = $pageLastModTime;
            }
            $url = route('page', ['id' => $page->id]);
            $sitemap->add($url, date(DATE_RFC3339, strtotime($page->feed->updated_at)), '0.6', 'weekly');
        }
        $info = $sitemap->store('xml','pages', public_path('sitemap'));
        Log::info($info);
        return $lastModTime;

    }

    public function createTags()
    {
        $sitemap = App::make("sitemap");
        $lastModTime = 0;

        Tag::query()->select('id','name','updated_at')->chunk(100, function ($tags) use ($sitemap, &$lastModTime) {
            foreach ($tags as $tag) {
                $tagLastModTime = strtotime($tag->updated_at);
                if ($tagLastModTime > $lastModTime) {
                    $lastModTime = $tagLastModTime;
                }
                $url = route('tag', ['id' => $tag->id]);
                $sitemap->add($url, date(DATE_RFC3339, strtotime($tag->updated_at)), '0.5', 'weekly');
            }
        });

        $info = $sitemap->store('xml','tags', public_path('sitemap'));
        Log::info($info);
        return $lastModTime;

    }

    public function createCategories()
    {
        $sitemap = App::make("sitemap");
        $lastModTime = 0;

        Category::query()->select('id','name','updated_at')->chunk(100, function ($categories) use ($sitemap, &$lastModTime) {
            foreach ($categories as $category) {
                $tagLastModTime = strtotime($category->updated_at);
                if ($tagLastModTime > $lastModTime) {
                    $lastModTime = $tagLastModTime;
                }
                $url = route('category', ['id' => $category->id]);
                $sitemap->add($url, date(DATE_RFC3339, strtotime($category->updated_at)), '0.5', 'weekly');
            }
        });

        $info = $sitemap->store('xml','categories', public_path('sitemap'));
        Log::info($info);
        return $lastModTime;
    }
}
