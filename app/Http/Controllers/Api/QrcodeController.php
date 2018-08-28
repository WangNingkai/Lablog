<?php
namespace App\Http\Controllers\Api;

use App\Helpers\Extensions\Tool;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
           return Tool::qrcodeGenerate($text,$size);
        } else {
            return response()->json(['code' => 403,'msg' => 'Permission Denied']);
        }
    }

    /**
     * 二维码解码
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function decode(Request $request)
    {
        $token = $request->get('token');
        $img = $request->get('img');
        if ($token == config('global.qrcode_token')) {
          return Tool::qrcodeDecode($img);
        } else {
            return response()->json(['code'=>403,'msg'=>'Permission Denied']);
        }
    }
}
