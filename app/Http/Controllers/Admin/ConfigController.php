<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Config;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

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
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Config $configModel)
    {
        $data = $request->except('_token');
        $editData = [];
        foreach ($data as $k => $v) {
            $editData[] = [
                'name' => $k,
                'value' => $v
            ];
        }
        $configModel->updateBatch($editData);
        operation_event(auth()->user()->name,'修改配置文件');
        // 更新缓存
        Cache::forget('cache:config');
        return redirect()->back();
    }
}
