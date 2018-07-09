<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Config;
use Artisan;
use Auth;
use Cache;

class ConfigController extends Controller
{
    /**
     * 列举配置目录.
     *
     * @param  int $id
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
        show_message('修改完成');
        // 更新缓存
        Cache::forget('app:config');
        return redirect()->back();
    }

    /**
     * 编辑关于站点页面
     *
     * @return  \Illuminate\Http\Response
     */
    public function manageAbout()
    {
        $content = Config::where('name', 'site_about')->pluck('value', 'name')->first();
        return view('admin.config-about', compact('content'));
    }

    /**
     * 更新关于站点页面
     *
     * @return  \Illuminate\Http\Response
     */
    public function updateAbout(Request $request)
    {
        $content = $request->input('content');
        Config::where('name', 'site_about')->update(['value' => $content]);
        show_message('提交成功');
        Artisan::call('cache:clear');
        operation_event(auth()->user()->name,'修改关于页面');
        // 更新缓存
        Cache::forget('app:config');
        return redirect()->back();
    }
}
