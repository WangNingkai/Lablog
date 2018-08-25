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
            $command = "sudo /usr/bin/nohup /usr/bin/bash /root/blog.sh update {$basePath}  > /root/push.log 2>&1 &";
            exec($command,$log,$status);
            if ($status == 0)
                return response()->json(['code' => 200,'msg' => 'ok','data' => $log]);
            else
                return response()->json(['code' => 500,'msg' => 'failed','data' => $log]);
        } else {
            return response()->json(['code' => 403,'msg' => 'permission denied','data' => null]);
        }
    }
/* blog.sh 脚本

#!/usr/bin/env bash
PATH=/bin:/sbin:/usr/bin:/usr/sbin:/usr/local/bin:/usr/local/php/bin:/usr/local/sbin:~/bin
export PATH

msg=$1

path=$2

cd ${path}

case ${msg} in
  pull)
  git fetch --all
  git reset --hard origin/master
;;
  clear)
  /usr/local/php/bin/php artisan clear
/usr/local/php/bin/php artisan cache:clear
/usr/local/php/bin/php artisan config:clear
;;
  update)
  git pull
/usr/local/bin/composer update
;;
 esac

*/

}
