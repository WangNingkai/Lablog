<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ArticleViewEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var class Article
     */
    protected $article;

    /**
     * @var string IP
     */
    protected $ip;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($article, $ip)
    {
        $this->article = $article;
        $this->ip = $ip;
    }


    // 获取操作
    public function getArticle()
    {
        return $this->article;
    }


    // 获取IP
    public function getIp()
    {
        return $this->ip;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-default');
    }
}
