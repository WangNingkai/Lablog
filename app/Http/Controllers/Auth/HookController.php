<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HookController extends Controller
{
    public function push(Request $request,$type)
    {
        $data = $request->all();
        if ($type =='gitee') {
            $allow = $request->header('X-Gitee-Token') === env('GITEE_HOOK_PASSWORD') ?:false;
        } elseif ($type =='gogs') {
            $signature = $request->header('X-Gogs-Signature');
            $hash = hash_hmac ('sha256',$data,env('GOGS_HOOK_PASSWORD'));
            $allow = $signature === $hash?:false;
        }
        if ($allow)
            shell_exec('cd '.base_path().' && git pull && composer install');
    }
}
