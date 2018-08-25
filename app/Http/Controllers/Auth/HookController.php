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
            $allow = $request->header('X-Gitee-Token') == env('GITEE_HOOK_PASSWORD') ?:false;
        } elseif ($type =='gogs') {
            $signature = $request->header('X-Gogs-Signature');
            $hash = hash_hmac ('sha256',$data,env('GOGS_HOOK_PASSWORD'));
            $allow = $signature == $hash?:false;
        }
        if ($allow) {
            $basePath =base_path();
            $command = "sudo /usr/bin/bash /root/blog.sh update {$basePath} >> /data/wwwlogs/pull.log 2>&1 &";
            exec($command ,$log, $status);
            if ($status)
                return response()->json(['code' => 403,'msg' => 'permission denied','data' => null]);
            else
                return response()->json(['code' => 200,'msg' => 'ok','data' => $log]);
        } else {
            return response()->json(['code' => 403,'msg' => 'permission denied','data' => null]);
        }
    }

}
