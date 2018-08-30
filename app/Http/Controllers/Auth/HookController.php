<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HookController extends Controller
{
    /**
     * @param Request $request
     * @param $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function push(Request $request,$type)
    {
        $data = $request->getContent();
        $allow = false;
        if ($type =='gitee') {
            $allow = $request->header('X-Gitee-Token') == config('global.gitee_hook_password') ?:false;
        } elseif ($type =='gogs') {
            $signature = $request->header('X-Gogs-Signature');
            $hash = hash_hmac ('sha256',$data,config('global.gogs_hook_password'));
            $allow = $signature == $hash?:false;
        }
        if ($allow) {
            // 先给shell脚本执行权限 chmod +x laravel.sh 确保日志文件的权限在php下
            $shellPath = '/root/project/shell/laravel.sh';
            $basePath =base_path();
            $command = "sudo /usr/bin/bash {$shellPath} update {$basePath} >> /data/wwwlogs/lablog_pull.log 2>&1 &";
            exec($command ,$log, $status);
            if ($status)
                return response()->json(['code' => 500,'msg' => 'Server Error']);
            else
                return response()->json(['code' => 200,'msg' => 'ok','data' => $log]);
        } else {
            return response()->json(['code' => 403,'msg' => 'permission denied']);
        }
    }

}
