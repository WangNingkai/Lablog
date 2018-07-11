<?php

namespace App\Listeners;

use App\Events\ArticleViewEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Redis;
use App\Models\Article;

class ArticleEventListener
{

     /**
     * 一个帖子的最大访问数
     */
    const VIEW_LIMIT = 30;

    /**
     * 同一用户浏览同一个帖子的过期时间
     */
    const VIEW_EXPIRE = 300;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ArticleViewEvent  $event
     * @return void
     */
    public function handle(ArticleViewEvent $event)
    {
        $article = $event->getArticle();
        $ip = $event->getIp();
        $id = $article->id;
        //首先判断下 VIEW_EXPIRE = 300秒时间内,同一IP访问多次,仅仅作为1次访问量
        if($this->ipViewLimit($id, $ip)){
            //一个IP在300秒时间内访问第一次时,刷新下该篇article的浏览量
            $this->updateCacheViewCount($id, $ip);
        }
    }

    /**
     * 限制同一IP一段时间内得访问,防止增加无效浏览次数
     * @param $id
     * @param $ip
     * @return bool
     */
    public function ipViewLimit($id, $ip)
    {
        $ipArticleViewKey = 'article:ip:limit:'.$id;
        //Redis命令SISMEMBER检查集合类型Set中有没有该键,Set集合类型中值都是唯一
        $existsInRedisSet = Redis::command('SISMEMBER', [$ipArticleViewKey, $ip]);
        //如果集合中不存在这个建 那么新建一个并设置过期时间
        if(!$existsInRedisSet){
            //SADD,集合类型指令,向ipArticleViewKey键中加一个值ip
            Redis::command('SADD', [$ipArticleViewKey, $ip]);
            //并给该键设置生命时间,这里设置300秒,300秒后同一IP访问就当做是新的浏览量了
            Redis::command('EXPIRE', [$ipArticleViewKey, self::VIEW_EXPIRE]);
            return true;
        }
        return false;
    }
    /**
     * 达到要求更新数据库的浏览量
     * @param $id
     * @param $count
     */
    public function updateModelViewCount($id, $count)
    {
        //访问量达到300,再进行一次SQL更新
        $article = Article::find($id);
        $article->click += $count;
        $article->save();
    }

    /**
     * 不同用户访问,更新缓存中浏览次数
     * @param $id
     * @param $ip
     */
    public function updateCacheViewCount($id, $ip)
    {
        $cacheKey = 'article:view:'.$id;
        //这里以Redis哈希类型存储键,就和数组类似,$cacheKey就类似数组名 如果这个key存在
        if(Redis::command('HEXISTS', [$cacheKey, $ip])){
            //哈希类型指令HINCRBY,就是给$cacheKey[$ip]加上一个值,这里一次访问就是1
            $save_count = Redis::command('HINCRBY', [$cacheKey, $ip, 1]);
            //redis中这个存储浏览量的值达到30后,就去刷新一次数据库
            if($save_count == self::VIEW_LIMIT){
                $this->updateModelViewCount($id, $save_count);
                //本篇article,redis中浏览量刷进MySQL后,就把该篇article的浏览量清空,重新开始计数
                Redis::command('HDEL', [$cacheKey, $ip]);
                Redis::command('DEL', ['laravel:article:cache:'.$id]);
            }
        }else{
        //哈希类型指令HSET,和数组类似,就像$cacheKey[$ip] = 1;
        Redis::command('HSET', [$cacheKey, $ip, '1']);
        }
    }
}
