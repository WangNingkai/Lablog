<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class ImageController extends Controller
{
    public function list()
    {
        $client = new Client();
        $response = $client->get('https://sm.ms/api/list');
        $content = json_decode($response->getBody()->getContents(), true);
        $list = [];
        if ($content['code'] == 'success')
        {
            $list = $content['data'];
        }
        return view('admin.image',compact('list'));
    }
    /**
     * @param Request $request
     * @return array
     */
    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|max:5096|image'
        ]);
        if ($validator->fails()) {
            return $this->fail($validator->errors()->first());
        }
        /** @var UploadedFile $file */
        $file = $request->file();
        try {
            $url = $this->uploadToSM($file);
            return $this->success($url);
        } catch (\Exception $e) {
            return $this->fail($e->getMessage());
        }
    }
    /**
     *
     * @param $file UploadedFile
     * @return array
     */
    private function uploadToSM($file)
    {
        $client = new Client();
        $response = $client->post('https://sm.ms/api/upload', [
            'multipart' => [
                [
                    'name' => 'smfile',
                    'contents' => fopen($file->getRealPath(), 'r'),
                    'filename' => $file->getClientOriginalName()
                ]
            ]
        ]);
        return json_decode($response->getBody()->getContents(), true);
    }
    public function success($data = [], $code = 200)
    {
        return ['code' => $code, 'data' => $data];
    }
    public function fail($data = [], $code = 500)
    {
        return ['code' => $code, 'data' => $data];
    }
}
