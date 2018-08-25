<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

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
            $command = "sudo nohup /usr/local/php/bin/php {$basePath}/artisan git:pull >> /root/push.log 2>&1 &";
            $process = new Process($command);
            $process ->run();
            if (!$process->isSuccessful())
                throw new ProcessFailedException($process);
            else
                return response()->json(['code' => 200,'msg' => 'ok','data' => $process->getOutput()]);
        } else {
            return response()->json(['code' => 403,'msg' => 'permission denied','data' => null]);
        }
    }

}
