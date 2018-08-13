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
        Tool::recordOperation(auth()->user()->name,'修改配置文件');
        // 更新缓存
        Cache::forget('cache:config');
        return redirect()->back();
    }
}
