<?php
namespace App\Helpers\Extensions;
use App\Jobs\SendEmail;
use App\Models\Subscribe;

class Tool
{

    /**
     * 操作成功或者失败的提示
     *
     * @param string $message
     * @param bool $success
     */
    public static function showMessage($message = '成功', $success = true)
    {
        $alertType = $success ? 'success' : 'error';
        session()->flash('alertMessage', $message);
        session()->flash('alertType', $alertType);
    }

    /**
     * 推送消息
     * @param $who
     * @param $name
     * @param $content
     * @param $url
     */
    public static function pushMessage($who,$name,$content,$url)
    {
        $param = [
            'email' => $who,
            'name' => $name,
            'subject' => config('app.name').'站点推送消息',
            'data' => [
                'name' => $name,
                'content' => $content,
                'url' => $url
            ]
        ];
        SendEmail::dispatch($param);
    }

    /**
     * 推送订阅
     * @param $content
     * @param $url
     */
    public static function pushSubscribe($content = '',$url = '')
    {
        $emails = Subscribe::query()->pluck('email');
        foreach($emails as $email)
        {
            $param = [
                'email' => $email,
                'name' => '亲爱的订阅用户',
                'subject' => config('app.name').'站点订阅提醒',
                'data' => [
                    'name' => '亲爱的订阅用户',
                    'content' => blank($content) ? config('app.name').'有新文章发布了，快来瞧瞧吧': $content,
                    'url' => $url,
                ]
            ];
            SendEmail::dispatch($param);
        }
    }
}
