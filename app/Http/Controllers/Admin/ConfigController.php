<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Support\Facades\Cache;
use App\Helpers\Extensions\Tool;

class ConfigController extends Controller
{
    /**
     * 列举配置目录.
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        return view('admin.config');
    }

    /**
     * 更新配置.
     * @param Request $request
     * @param Config $config
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Config $config)
    {
        $data = $request->except('_token');
        $editData = [];
        foreach ($data as $k => $v) {
            $editData[] = [
                'name' => $k,
                'value' => $v
            ];
        }
        $config->updateBatch($editData);
        Tool::recordOperation(auth()->user()->name, '修改配置文件');
        // 更新缓存
        Cache::forget('cache:config');
        Cache::forget('cache:config:site_status');
        Cache::forget('cache:config:site_allow_message');
        Cache::forget('cache:config:site_allow_subscribe');
        return redirect()->back();
    }

    /**
     * 上传水印图片
     */
    public function uploadImage()
    {
        $field = 'water_mark';
        $rule = [$field => 'required|max:1024|image|dimensions:max_width=200,max_height=200'];
        if (file_exists($file = public_path('img/water_mark.png'))) {
            @unlink($file);
        } // TODO：水印问题
        $uploadPath = 'img';
        $fileName = 'water_mark';
        $result = Tool::uploadFile($field, $rule, $uploadPath, $fileName, false);
        $result['status_code'] == 200 ? Tool::showMessage('水印上传成功') : Tool::showMessage($result['message'], false);
        return redirect()->back();
    }
}
