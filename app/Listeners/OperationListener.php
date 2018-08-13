<?php

namespace App\Listeners;

use App\Events\OperationEvent;
use App\Helpers\Extensions\Tool;
use Illuminate\Support\Facades\DB;

class OperationListener
{
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
     * @param  OperationEvent  $event
     * @return void
     */
    public function handle(OperationEvent $event)
    {
        //获取事件中保存的信息
        $operator = $event->getOperator();
        $operation = $event->getOperation();
        $ip = $event->getIp();
        $timestamp = $event->getTimestamp();

        $basic_info=[
            'operator' => $operator,
            'operation' => $operation,
            'ip' => $ip,
            'operation_time' => $timestamp,
        ];

        $basic_info['address']=Tool::ip2City($ip);
        // 提取agent信息
        $ua_info=Tool::getUA();
        $operation_info=array_merge($basic_info,$ua_info);
        //插入到数据库
        DB::table('operation_logs')->insert($operation_info);

    }
}
