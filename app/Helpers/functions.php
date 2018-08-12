<?php

use Illuminate\Support\Facades\Mail;
use HyperDown\Parser;
use Jenssegers\Agent\Agent;
use App\Events\OperationEvent;
use Zhuzhichao\IpLocationZh\Ip;
use WangNingkai\SimpleDictionary\SimpleDictionary;

if (!function_exists('operation_event')) {
    /**
     * 操作日志事件
     * @param $operator
     * @param $operation
     */
    function operation_event($operator,$operation){
        event(new OperationEvent($operator,$operation,request()->getClientIp(), time()));
    }
}
if (!function_exists('get_tree')) {
    /**
     * 获取子孙目录树
     *
     * @param array $data 要转换的数据集
     * @param string $pid parent标记字段
     * @param string $count 获取个数
     * @return  array
     */
    function get_tree($data, $pid, $count = null)
    {
        //每次都声明一个新数组用来放子元素
        $tree = [];
        foreach ($data as $v) {
            if ($v['parent_id'] == $pid) {
                //匹配子记录
                $v['children'] = get_tree($data, $v['id'], null);
                //递归获取子记录
                if ($v['children'] == null) {
                    unset($v['children']);
                    //如果子元素为空则unset()进行删除，说明已经到该分支的最后一个元素了（可选）
                }
                //将记录存入新数组
                $tree[] = $v;
                if ($count === count($tree)) {
                    break;
                } elseif (is_null($count)) {
                    return [];
                }
            }
        }
        return $tree;
        //返回新数组
    }
}
if (!function_exists('get_select')) {
    /**
     * 获取树形下拉框数据
     *
     * @param array $data 数据
     * @param integer $selected_id 所选id
     * @return string
     */
    function get_select($data, $selected_id = 0)
    {
        $select = new \App\Helpers\Extensions\Select($data);
        return $select->make_option_tree_for_select($selected_id);
    }
}
if (!function_exists('get_ua')) {
    /**
     * 获取客户端UA
     *
     * @return array
     */
    function get_ua()
    {
        $agent=new Agent;
        $ua_info['device'] = $agent->device() ? $agent->device() : 'desktop';
        $browser = $agent->browser();
        //浏览器
        $ua_info['browser'] = $browser . ' ' . $agent->version($browser);
        $platform = $agent->platform();
        //操作系统
        $ua_info['platform'] = $platform . ' ' . $agent->version($platform);
        //语言
        $ua_info['language'] = implode(',', $agent->languages());
        //设备类型
        if ($agent->isTablet()) {
            // 平板
            $ua_info['device_type'] = 'tablet';
        } else if ($agent->isMobile()) {
            // 便捷设备
            $ua_info['device_type'] = 'mobile';
        } else if ($agent->isRobot()) {
            // 爬虫机器人
            $ua_info['device_type'] = 'robot';
            $ua_info['device'] = $agent->robot(); //机器人名称
        } else {
            // 桌面设备
            $ua_info['device_type'] = 'desktop';
        }
        return $ua_info;
    }
}
if( !function_exists('ip_is_private')) {
    /**
     * 判断IP是否为内网IP
     * @param $ip
     * @return bool
     */
    function ip_is_private($ip){
        $pri_addrs = [
            '10.0.0.0|10.255.255.255',
            '172.16.0.0|172.31.255.255',
            '192.168.0.0|192.168.255.255',
            '169.254.0.0|169.254.255.255',
            '127.0.0.0|127.255.255.255'
        ];
        $long_ip = ip2long($ip);
        if($long_ip != -1) {
            foreach($pri_addrs as $pri_addr) {
                list($start, $end) = explode('|', $pri_addr);
                // IF IS PRIVATE
                if($long_ip >= ip2long($start) && $long_ip <= ip2long($end))
                    return true;
            }
        }
        return false;
    }
}
if (!function_exists('ip_to_city')) {
    /**
     * 根据ip获取城市
     *
     * @param string $ip
     * @return string
     */
    function ip_to_city($ip)
    {
        if (!ip_is_private($ip))
        {
            $data = Ip::find($ip);
            return $data[0].$data[1].$data[2];
        }else{
            return '内网IP';
        }
    }

}
if (!function_exists('markdown_to_html')) {
    /**
     * markdown 转 html
     *
     * @param string $markdown
     * @return array
     */
    function markdown_to_html($markdown)
    {
        preg_match_all('/&lt;iframe.*iframe&gt;/', $markdown, $iframe);
        // 如果有 iframe 则先替换为临时字符串
        if (!empty($iframe[0])) {
            $tmp = [];
            // 组合临时字符串
            foreach ($iframe[0] as $k => $v) {
                $tmp[] = '【iframe' . $k . '】';
            }
            // 替换临时字符串
            $markdown = str_replace($iframe[0], $tmp, $markdown);
            // 讲 iframe 转义
            $replace = array_map(function ($v) {
                return htmlspecialchars_decode($v);
            }, $iframe[0]);
        }
        // markdown转html
        $parser = new Parser();
        $html = $parser->makeHtml($markdown);
        $html = str_replace('<code class="', '<code class="lang-', $html);
        // 将临时字符串替换为iframe
        if (!empty($iframe[0])) {
            $html = str_replace($tmp, $replace, $html);
        }
        return $html;
    }
}
if (!function_exists('send_email')) {
    /**
     * 发送邮件函数
     *
     * @param  string $email           邮箱  如果群发 则传入数组
     * @param string $name             名称
     * @param string $subject          标题
     * @param array $data              邮件模板中用的变量 示例：['name'=>'帅白','phone'=>'110']
     * @param string $template         邮件模板
     * @return array                   发送状态
     */
    function send_email($email, $name, $subject, $data = [], $template = 'emails.base')
    {
        Mail::send($template, $data, function ($message) use ($email, $name, $subject) {
            //如果是数组；则群发邮件
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
}
if (!function_exists('upload_file') ) {
	/**
	 * 上传文件函数
	 *
	 * @param string $file            表单的name名
     * @param array  $rule           规则
	 * @param string $path           上传的路径
     * @param mixed  $isRandName     是否自定义名
	 * @param bool $childPath        是否根据日期生成子目录
	 * @return array                 上传的状态
	 */
	function upload_file($file, $rule ,$path = 'upload', $isRandName = null,$childPath = false)
	{
		//判断请求中是否包含name=file的上传文件
		if (!request()->hasFile($file)) {
			$data = ['status_code' => 500, 'message' => '上传文件为空'];
			return $data;
		}
		$file = request()->file($file);
        // 判断文件上传条件
        $validator = \Illuminate\Support\Facades\Validator::make(request()->all(), $rule);
        if ($validator->fails()) {
            $data = ['status_code' => 500, 'message' => $validator->errors()->first()];
            return $data;
        }
        //判断文件上传过程中是否出错
		if (!$file->isValid()) {
			$data = ['status_code' => 500, 'message' => '文件上传出错'];
			return $data;
		}
		//兼容性的处理路径的问题
		if ($childPath == true) {
			$path = './' . trim($path, './') . '/' . date('Ymd') . '/';
		} else {
			$path = './' . trim($path, './') . '/';
		}
		if (!is_dir($path)) {
			mkdir($path, 0755, true);
		}
		//获取上传的文件名
		$oldName = $file->getClientOriginalName();
		//组合新的文件名
        $newName =  $isRandName ? $isRandName.'.' . 'png' : uniqid() . '.' . 'png';
		//上传失败
		if (!$file->move($path, $newName)) {
			return ['status_code' => 500, 'message' => '保存文件失败'];
		}
		//上传成功
		return ['status_code' => 200, 'message' => '上传成功', 'data' => ['old_name' => $oldName, 'new_name' => $newName, 'path' => trim($path, '.')]];
	}
}
if (!function_exists('bd_push')) {
    /**
     * 百度推广推送
     *
     * @param string|array $id 文章id
     * @param string $type 推送类型 添加urls 1更新update 2删除del
     */
    function bd_push($id,$type = 'urls')
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
}
if (!function_exists('set_active')) {
    /**
     * 设置导航栏状态
     *
     * @param string $route
     * @return bool
     */
    function set_active($route)
    {
        return (request()->is($route . '/*') || request()->is($route)) ? "active" : '';
    }
}
if (!function_exists('show_message')) {
    /**
     * 操作成功或者失败的提示
     *
     * @param string $message
     * @param bool $success
     */
    function show_message($message = '成功', $success = true)
    {
        $alertType = $success ? 'success' : 'error';
        session()->flash('alertMessage', $message);
        session()->flash('alertType', $alertType);
    }
}
if (!function_exists('ajax_return')) {
    /**
     * ajax返回数据
     *
     * @param string $data 需要返回的数据
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    function ajax_return($code = 200, $data = '')
    {
        //如果如果是错误 返回错误信息
        if ($code != 200) {
            $data = ['status_code' => $code, 'message' => $data,];
            return response()->json($data, $code);
        }
        //如果是对象 先转成数组
        if (is_object($data)) {
            $data = $data->toArray();
        }
        /**
         * 将数组递归转字符串
         * @param  array $arr 需要转的数组
         * @return array       转换后的数组
         */
        function to_string($arr)
        {
            // app 禁止使用和为了统一字段做的判断
            $reserved_words = [];
            foreach ($arr as $k => $v) {
                //如果是对象先转数组
                if (is_object($v)) {
                    $v = $v->toArray();
                }
                //如果是数组；则递归转字符串
                if (is_array($v)) {
                    $arr[$k] = to_string($v);
                } else {
                    //判断是否有移动端禁止使用的字段
                    in_array($k, $reserved_words, true) && die('不允许使用【' . $k . '】这个键名 —— 此提示是helper.php 中的ajaxReturn函数返回的');
                    //转成字符串类型
                    $arr[$k] = strval($v);
                }
            }
            return $arr;
        }

        //判断是否有返回的数据
        if (is_array($data)) {
            //先把所有字段都转成字符串类型
            $data = to_string($data);
        }
        return response()->json($data, $code);
    }
}
if (!function_exists('transform_time')) {
    /**
     * 优化时间显示
     * @param $sTime
     * @param int $format
     * @return false|string
     */
    function transform_time($sTime,$format=0)
    {
        // 如果是日期格式的时间;则先转为时间戳
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
}
if (!function_exists('transform_size')) {
    /**
     * 文件大小转换
     * @param $size
     * @return string
     */
    function transform_size($size)
    {
        $units = [' B', ' KB', ' MB', ' GB', ' TB'];
        return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $units[2];
    }

}
if (!function_exists('re_substr')) {
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
    function re_substr($str, $start = 0, $length, $suffix = true, $charset = "utf-8")
    {
        $slice = mb_substr($str, $start, $length, $charset);
        $omit = mb_strlen($str) >= $length ? '...' : '';
        return $suffix ? $slice . $omit : $slice;
    }
}
if (!function_exists('has_filter')) {
    /**
     * 过滤敏感词
     * @param $content
     * @return int
     */
    function has_filter($content)
    {
        $filterFile = storage_path('app/data').'/dict.bin';
        $dict = new SimpleDictionary($filterFile);
        $re = $dict->search($content);
        return count($re) > 0 ? 1 : 0;
    }
}

if (!function_exists('get_tree_index')) {
    /**
     * @param $data
     * @param int $id
     * @param int $deep
     * @return array
     */
    function get_tree_index($data, $id = 0, $deep = 0) {
        $tempArr = [];
        foreach ($data as $k => $v) {
            if($v['parent_id'] == $id){
                $v['deep'] = $deep;
                if($v['parent_id']!==0)
                {
                    $v['name'] = str_repeat("&nbsp;&nbsp;", $v['deep'] * 2) . '|-' . $v['name'];
                }
                $tempArr[] = $v;
                $tempArr = array_merge($tempArr,get_tree_index($data,$v['id'], $deep + 1));
            }
        }
        return $tempArr;
    }
}


