<?php
namespace App\Helpers\Extensions;

use App\Jobs\SendEmail;
use App\Models\Article;
use App\Models\Subscribe;
use Illuminate\Support\Facades\Mail;
use App\Events\OperationEvent;
use WangNingkai\SimpleDictionary\SimpleDictionary;
use HyperDown\Parser;
use Jenssegers\Agent\Agent;
use Zhuzhichao\IpLocationZh\Ip;

class Tool
{
    /**
     * 操作成功或者失败的提示
     *
     * @param string $message 消息内容
     * @param bool $success 成功/失败
     */
    public static function showMessage($message = '成功', $success = true)
    {
        $alertType = $success ? 'success' : 'error';
        session()->flash('alertMessage', $message);
        session()->flash('alertType', $alertType);
    }

    /**
     * 推送消息
     *
     * @param mixed $who 接收用户
     * @param string $name 用户名
     * @param string $content 内容
     * @param string $url 链接
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
     *
     * @param string $content  内容
     * @param string $url      链接
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

    /**
     * 过滤敏感词
     *
     * @param $content
     * @return int
     */
    public static function hasFilter($content)
    {
        $filterFile = storage_path('app/data').'/dict.bin';
        $dict = new SimpleDictionary($filterFile);
        $re = $dict->search($content);
        return count($re) > 0 ? 1 : 0;
    }

    /**
     * 字符串截取，支持中文和其他编码
     *
     * @param string $str 需要转换的字符串
     * @param integer $start 开始位置
     * @param string $length 截取长度
     * @param boolean $suffix 截断显示字符
     * @param string $charset 编码格式
     * @return string
     */
    public static function subStr($str, $start, $length, $suffix = true, $charset = "utf-8")
    {
        $slice = mb_substr($str, $start, $length, $charset);
        $omit = mb_strlen($str) >= $length ? '...' : '';
        return $suffix ? $slice . $omit : $slice;
    }
    /**
     * 文件大小转换
     *
     * @param int $size 文件原大小
     * @return string
     */
    public static function transformSize($size)
    {
        $units = [' B', ' KB', ' MB', ' GB', ' TB'];
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $units[2];
    }

    /**
     * 优化时间显示
     *
     * @param mixed $sTime 源时间
     * @param int $format
     * @return false|string
     */
    public static function transformTime($sTime,$format = 0)
    {
        # 如果是日期格式的时间;则先转为时间戳
        if (!is_integer($sTime)) {
            $sTime = strtotime($sTime);
        }
        //sTime=源时间，cTime=当前时间，dTime=时间差
        $cTime        =    time();
        $dTime        =    $cTime - $sTime;
        // 计算两个时间之间的日期差
        $date1 = date_create(date("Y-m-d",$cTime));
        $date2 = date_create(date("Y-m-d",$sTime));
        $diff = date_diff($date1,$date2);
        $dDay = $diff->days;

        if($dTime == 0){
            return "1秒前";
        }elseif( $dTime < 60 && $dTime > 0 ){
            return $dTime."秒前";
        }
        elseif( $dTime < 3600 && $dTime > 0 ){
            return intval($dTime/60)."分钟前";
        }
        elseif( $dTime >= 3600 && $dDay == 0 )
        {
            return intval($dTime/3600)."小时前";
        }
        elseif( $dDay == 1 )
        {
            return date("昨天 H:i",$sTime);
        }
        elseif( $dDay == 2 )
        {
            return date("前天 H:i",$sTime);
        }
        elseif($format == 1){
            return date("m-d H:i",$sTime);
        }else{
            if(date('Y',$cTime)!=date('Y',$sTime)) // 不是今年
                return date("Y-n-j",$sTime);
            else
                return date("n-j",$sTime);
        }
    }
    /**
     * 发送邮件函数
     *
     * @param  string $email           邮箱  如果群发 则传入数组
     * @param string $name             名称
     * @param string $subject          标题
     * @param array $data              邮件模板中用的变量 示例：['name'=>'xxx','content'=>'xxx']
     * @param string $template         邮件模板
     * @return array                   发送状态
     */
    public static  function sendEmail($email, $name, $subject, $data = [], $template = 'emails.base')
    {
        Mail::send($template, $data, function ($message) use ($email, $name, $subject) {
            if (is_array($email)) {
                foreach ($email as $k => $v) {
                    $message->to($v, $name)->subject($subject);
                }
            } else {
                $message->to($email, $name)->subject($subject);
            }
        });
        return (count(Mail::failures()) > 0)?['status_code' => 500, 'message' => '邮件发送失败']:['status_code' => 200, 'message' => '邮件发送成功'];
    }

    /**
     * 上传文件函数
     *
     * @param string $file           表单的name名
     * @param array  $rule           验证规则
     * @param string $path           上传的路径
     * @param mixed  $isRandName     是否自定义名
     * @param bool $childPath        是否根据日期生成子目录
     * @return array                 上传的状态
     */
    public static function uploadFile($file, $rule ,$path = 'upload', $isRandName = null, $childPath = false)
    {
        if (!request()->hasFile($file)) {
            $data = ['status_code' => 500, 'message' => '上传文件为空'];
            return $data;
        }
        $file = request()->file($file);
        $validator = \Illuminate\Support\Facades\Validator::make(request()->all(), $rule);
        if ($validator->fails()) {
            $data = ['status_code' => 500, 'message' => $validator->errors()->first()];
            return $data;
        }
        if (!$file->isValid()) {
            $data = ['status_code' => 500, 'message' => '文件上传出错'];
            return $data;
        }
        # 兼容性的处理路径的问题
        if ($childPath == true) {
            $path = './' . trim($path, './') . '/' . date('Ymd') . '/';
        } else {
            $path = './' . trim($path, './') . '/';
        }
        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }
        $oldName = $file->getClientOriginalName();
        $newName =  $isRandName ? $isRandName.'.' . 'png' : uniqid() . '.' . 'png';
        if (!$file->move($path, $newName)) {
            return ['status_code' => 500, 'message' => '保存文件失败'];
        }
        return ['status_code' => 200, 'message' => '上传成功', 'data' => ['old_name' => $oldName, 'new_name' => $newName, 'path' => trim($path, '.')]];
    }

    /**
     * 百度链接推送
     *
     * @param string|array $id 文章id
     * @param string $type 推送类型 添加urls 1更新update 2删除del
     */
    public static function bdPush($id,$type = 'urls')
    {
        $urls = [];
        if(is_array($id))
        {
            foreach ($id as $value) {
                $urls[]=route('article',$value);
            }
        }else {
            $urls[]=route('article',$id);
        }
        $api = 'http://data.zz.baidu.com/'.$type.'?site='.env('APP_URL').'&token='.env('BD_PUSH_TOKEN');
        $ch = curl_init();
        $options=[
            CURLOPT_URL => $api,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => implode("\n", $urls),
            CURLOPT_HTTPHEADER => ['Content-Type: text/plain'],
        ];
        curl_setopt_array($ch, $options);
        $result = curl_exec($ch);
        $msg = json_decode($result, true);
        if (array_key_exists('error',$msg)) {
            curl_exec($ch);
        }
        curl_close($ch);
    }

    /**
     * 设置导航栏状态
     *
     * @param string $route 路由地址
     * @return bool
     */
    public static function setActive($route)
    {
        return (request()->is($route . '/*') || request()->is($route)) ? "active" : '';
    }

    /**
     * ajax 返回数据
     *
     * @param int $code 返回代码
     * @param mixed $data 需要返回的数据
     * @return \Illuminate\Http\JsonResponse
     */
    public static function ajaxReturn($code, $data)
    {
        if ($code !== 200) {
            $data = ['status_code' => $code, 'message' => $data,];
            return response()->json($data, $code);
        }
        if (is_object($data)) {
            $data = $data->toArray();
        }
        return response()->json($data, $code);
    }
    /**
     * 记录操作日志事件
     * @param $operator
     * @param $operation
     */
    public static function recordOperation($operator,$operation){
        event(new OperationEvent($operator,$operation,request()->getClientIp(), time()));
    }

    /**
     * 递归获取子孙目录树
     *
     * @param array $data 要转换的数据集
     * @param int $parent_id parent_id 字段
     * @return  array
     */
    public static function getRecursiveData($data, $parent_id = 0)
    {
        $new_arr = [];
        foreach($data as $k => $v){
            if($v['parent_id'] == $parent_id){
                $new_arr[] = $v;
                unset($data[$k]);
            }
        }
        foreach($new_arr as &$a){
            $a['children'] = self::getRecursiveData($data, $a['id']);
            if (count($a['children']) === 0)
            {
                unset($a['children']);
            }
        }
        return $new_arr;
    }

    /**
     * 获取树形下拉框数据
     *
     * @param array $data 数据
     * @param integer $selected_id 选中id
     * @return string
     */
    public static function getSelect($data, $selected_id = 0)
    {
        $select = new Select($data);
        return $select->make_option_tree_for_select($selected_id);
    }

    /**
     * 获取客户端UA
     *
     * @return array
     */
    public static function getUA()
    {
        $agent=new Agent;
        $ua_info['device'] = $agent->device() ? $agent->device() : 'desktop';
        $browser = $agent->browser();
        $ua_info['browser'] = $browser . ' ' . $agent->version($browser);
        $platform = $agent->platform();
        $ua_info['platform'] = $platform . ' ' . $agent->version($platform);
        $ua_info['language'] = implode(',', $agent->languages());
        if ($agent->isTablet()) {
            $ua_info['device_type'] = 'tablet';
        } else if ($agent->isMobile()) {
            $ua_info['device_type'] = 'mobile';
        } else if ($agent->isRobot()) {
            $ua_info['device_type'] = 'robot';
            $ua_info['device'] = $agent->robot();
        } else {
            $ua_info['device_type'] = 'desktop';
        }
        return $ua_info;
    }

    /**
     * 根据ip获取城市
     *
     * @param string $ip
     * @return string
     */
    public static function ip2City($ip)
    {
        $data = Ip::find($ip);
        return $data[0].$data[1].$data[2];
    }

    /**
     * markdown 转 html
     *
     * @param string $markdown
     * @return array
     */
    public static function markdown2Html($markdown)
    {
        preg_match_all('/&lt;iframe.*iframe&gt;/', $markdown, $iframe);
        // 如果有 i_frame 则先替换为临时字符串
        if (!empty($iframe[0])) {
            $tmp = [];
            // 组合临时字符串
            foreach ($iframe[0] as $k => $v) {
                $tmp[] = '【iframe' . $k . '】';
            }
            // 替换临时字符串
            $markdown = str_replace($iframe[0], $tmp, $markdown);
            // 转义 i_frame
            $replace = array_map(function ($v) {
                return htmlspecialchars_decode($v);
            }, $iframe[0]);
        }
        // markdown转html
        $parser = new Parser();
        $html = $parser->makeHtml($markdown);
        $html = str_replace('<code class="', '<code class="lang-', $html);
        // 将临时字符串替换为 i_frame
        if (!empty($iframe[0])) {
            $html = str_replace($tmp, $replace, $html);
        }
        return $html;
    }
}
