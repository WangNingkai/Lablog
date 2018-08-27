<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Endroid\QrCode\QrCode;

class QrcodeController extends Controller
{
    public function generate(Request $request)
    {
        $size = $request->get('size');
        $text = $request->get('text');
        $token = $request->get('token');
        if ($token == config('global.qrcode_token')) {
            if(!$size || !$text) return abort(404);
            $key = 'qrcode_'.$text;
            $url = Cache::remember($key,1440,function () use ($text,$size){
                $qrCode = new Qrcode();
                $qrCode->setText($text);
                $qrCode->setSize($size);
                $qrCode->setMargin(10);
                return $qrCode->writeDataUri();
            });
            return response()->json(['code'=>200,'msg'=>'ok','data'=>$url]);
        } else {
            return abort(403);
        }

    }
}
