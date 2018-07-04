<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\User;
use Jenssegers\Agent\Agent;
use Ip;



class OperationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User 用户模型
     */
    protected $user;

    /**
     *
     * @var string 操作名称
     */
    protected $operation;


    /**
     * @var Agent Agent对象
     */
    protected $agent;

    /**
     * @var string IP地址
     */
    protected $ip;

    /**
     * @var int 登录时间戳
     */
    protected $timestamp;


    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($operater,$operation, $agent, $ip, $timestamp)
    {
            $this->operater = $operater;
            $this->operation = $operation;
            $this->agent = $agent;
            $this->ip = $ip;
            $this->timestamp = $timestamp;
    }

    // 获取操作者
    public function getOperater()
    {
        return $this->operater;
    }

    // 获取操作
    public function getOperation()
    {
        return $this->operation;
    }

    // 获取Agent信息
    public function getAgent()
    {
        return $this->agent;
    }

    // 获取IP
    public function getIp()
    {
        return $this->ip;
    }

    // 获取操作时间
    public function getTimestamp()
    {
        return $this->timestamp;
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
