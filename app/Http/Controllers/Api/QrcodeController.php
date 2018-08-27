<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use Endroid\QrCode\QrCode;

class QrcodeController extends Controller
{
    public function generate()
    {
        $size = Input::get('size');
        $text = Input::get('text');
        $token = Input::get('token');
        if ($token == config('global.qrcode_token')) {
            if(!$size || !$text) return abort(404);
            $qrCode = new Qrcode();
            $qrCode->setText($text);
            $qrCode->setSize($size);
            $qrCode->setMargin(5);
            $response = Response::make($qrCode->writeString(), 200);
            $response->header('content-type', 'image/png');
            return $response;
        } else {
            return abort(403);
        }

    }
}
