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
     * @param int $code
     * @param string $data  需要返回的数据
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
                    in_array($k, $reserved_words, true) && die('不允许使用【' . $k . '】这个键名');
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


