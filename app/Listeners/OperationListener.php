<?php

namespace App\Listeners;

use App\Events\OperationEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Jenssegers\Agent\Agent;
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
        $agent = $event->getAgent();
        $ip = $event->getIp();
        $timestamp = $event->getTimestamp();

        $operation_info=[
            'operater' => $operater,
            'operation' => $operation,
            'ip' => $ip,
            'operation_time' => $timestamp,
        ];

        // zhuzhichao/ip-location-zh 包含的方法获取ip地理位置
        $addresses = Ip::find($ip);
        $operation_info['address'] = implode(' ', $addresses);

        // 提取agent信息

        //设备名称
        $operation_info['device'] = $agent->device() ? $agent->device() : 'desktop';
        $browser = $agent->browser();
        //浏览器
        $operation_info['browser'] = $browser . ' ' . $agent->version($browser);
        $platform = $agent->platform();
        //操作系统
        $operation_info['platform'] = $platform . ' ' . $agent->version($platform);
        //语言
        $operation_info['language'] = implode(',', $agent->languages());
        //设备类型
        if ($agent->isTablet()) {
            // 平板
            $operation_info['device_type'] = 'tablet';
        } else if ($agent->isMobile()) {
            // 便捷设备
            $operation_info['device_type'] = 'mobile';
        } else if ($agent->isRobot()) {
            // 爬虫机器人
            $operation_info['device_type'] = 'robot';
            $operation_info['device'] = $agent->robot(); //机器人名称
        } else {
            // 桌面设备
            $operation_info['device_type'] = 'desktop';
        }
        //插入到数据库
        DB::table('operation_logs')->insert($operation_info);

    }
}
