<?php

namespace App\Listeners;

use App\Events\OperationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Ip;
use DB;

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
        $operater = $event->getOperater();
        $operation = $event->getOperation();
        $ip = $event->getIp();
        $timestamp = $event->getTimestamp();

        $basic_info=[
            'operater' => $operater,
            'operation' => $operation,
            'ip' => $ip,
            'operation_time' => $timestamp,
        ];

        // zhuzhichao/ip-location-zh 包含的方法获取ip地理位置
        // $addresses = Ip::find($ip);
        // $basic_info['address'] = implode(' ', $addresses);
        $basic_info['address']=ip_to_city($ip);

        // 提取agent信息

        //设备名称
        $ua_info=get_ua();
        $operation_info=array_merge($basic_info,$ua_info);
        //插入到数据库
        DB::table('operation_logs')->insert($operation_info);

    }
}
