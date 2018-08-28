<?php
namespace App\Http\Controllers\Api;

use App\Helpers\Extensions\Tool;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class QrcodeController extends Controller
{
    public function generate(Request $request)
    {
        $size = $request->get('size');
        $text = $request->get('text');
        $token = $request->get('token');
        if ($token == config('global.qrcode_token')) {
           return Tool::qrcodeGenerate($text,$size);
        } else {
            return response()->json(['code' => 403,'msg' => 'Permission Denied']);
        }
    }
    public function decode(Request $request)
    {
        ini_set('memory_limit', '-1');
        $token = $request->get('token');
        $img = $request->get('img');
        if ($token == config('global.qrcode_token')) {
          return Tool::qrcodeDecode($img);
        } else {
            return response()->json(['code'=>403,'msg'=>'Permission Denied']);
        }
    }
}
