<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Extensions\Tool;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;


class ImageController extends Controller
{
    /**
     * 上传历史列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list()
    {
        $client = new Client();
        $response = $client->get('https://sm.ms/api/list');
        $content = json_decode($response->getBody()->getContents(), true);
        $list = [];
        if ($content['code'] == 'success') {
            $list = $content['data'];
        }

        return view('admin.image', compact('list'));
    }

    /**
     * 上传
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function upload()
    {
        $rule = ['smfile' => 'required|max:5096|image'];
        $result = Tool::uploadFile('smfile', $rule, 'uploads/tmp/');
        $file = $result['status_code'] == 200 ? $result['data'] : null;
        $filePath = $file['absolutePath'];
        if (Tool::config('water_mark_status')) // 加水印
        {
            Tool::addImgWater($filePath, config('global.image_water_mark'));
        }
        try {
            $response = $this->uploadToSM($file);
            @unlink($filePath);

            return $response;
        } catch (\Exception $e) {
            return response()->json([
                'code' => 'error',
                'msg'  => $e->getMessage(),
            ]);
        }
    }

    /**
     * 上传到SM.MS
     *
     * @param $file
     *
     * @return mixed
     */
    private function uploadToSM($file)
    {
        $client = new Client();
        $response = $client->post('https://sm.ms/api/upload', [
            'multipart' => [
                [
                    'name' => 'smfile',
                    'contents' => fopen($file['absolutePath'], 'r'),
                    'filename' => $file['old_name'],
                ],
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
