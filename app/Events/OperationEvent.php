<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use App\Models\User;


class OperationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var User 用户模型
     */
    protected $operator;

    /**
     *
     * @var string 操作名称
     */
    protected $operation;


    /**
     * @var string IP地址
     */
    protected $ip;

    /**
     * @var int 登录时间戳
     */
    protected $timestamp;


    /**
     * OperationEvent constructor.
     * @param $operator
     * @param $operation
     * @param $ip
     * @param $timestamp
     *
     */
    public function __construct($operator, $operation, $ip = '', $timestamp = '')
    {
        $this->operator = $operator;
        $this->operation = $operation;
        $this->ip = $ip;
        $this->timestamp = $timestamp;
    }

    /**
     * 获取操作者
     * @return User
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     *  获取操作
     * @return string
     */
    public function getOperation()
    {
        return $this->operation;
    }


    /**
     * 获取IP
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * 获取操作时间
     * @return int|string
     */
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
