<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Endroid\QrCode\QrCode;
use Zxing\QrReader;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

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
    public function decode(Request $request)
    {
        ini_set('memory_limit', '-1');
        $token = $request->get('token');
        $img = $request->get('img');
        if ($token == config('global.qrcode_token')) {
            if(!$img) return abort(404);
            $path = public_path('uploads/tmp/'.md5($img).'.png');
            try {
                $client = new Client(['verify' => false]);
                $client->request('GET', $img, [
                    'sink' => $path
                ]);
            } catch (ClientException $e) {
                return abort(500);
            }
            $key = 'qrcode_text'.$img;
            $text = Cache::remember($key,1440,function () use ($path){
                $qrcode = new QrReader($path);
                return $qrcode->text();
            });
            @unlink($path);
            return response()->json(['code'=>200,'msg'=>'ok','data'=>$text]);
        } else {
            return abort(403);
        }
    }
}
