<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\QrcodeDecode;
use App\Jobs\QrcodeGenerate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class QrcodeController extends Controller
{
    /**
     * 二维码生成
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generate(Request $request)
    {
        $size = $request->get('size');
        $text = $request->get('text');
        $token = $request->get('token');
        if ($token == config('global.qrcode_token')) {
            if(!$text) return response()->json(['code' => 400,'msg' => 'Param Error']);
            $key = 'qrcode_'.$text;
            if (!Cache::has($key)) {
                // 入队处理
                QrcodeGenerate::dispatch(['size' => $size ,'text' => $text])->onConnection('redis');
                return response()->json(['code' => 202,'msg' => 'Processing...Please refresh the page later.']);
            } else {
                $url = Cache::get($key);
            }
            if ($url) return response()->json(['code' => 200,'msg' => 'OK','data' => $url]);
        } else {
            return response()->json(['code' => 403,'msg' => 'Permission Denied']);
        }
    }

    /**
     * 二维码解码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function decode(Request $request)
    {
        $token = $request->get('token');
        $img = $request->get('img');
        if ($token == config('global.qrcode_token')) {
            if(!$img) return response()->json(['code' => 400,'msg' => 'Param Error']);
            $key = 'qrcode_text'.$img;
            if (!Cache::has($key)) {
                // 入队处理
                QrcodeDecode::dispatch($img)->onConnection('redis');
                return response()->json(['code' => 202,'msg' => 'Processing...Please refresh the page later.']);
            } else {
                $text = Cache::get($key);
            }
            if ($text) return response()->json(['code' => 200,'msg' => 'OK','data' => $text]);
        } else {
            return response()->json(['code'=>403,'msg'=>'Permission Denied']);
        }
    }
}
