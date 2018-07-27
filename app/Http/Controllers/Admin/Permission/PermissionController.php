<?php

namespace App\Http\Controllers\Admin\Permission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Permission\Store;
use App\Http\Requests\Permission\Update;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{

    /**
     * 权限管理列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage()
    {
        $permissions = Permission::query()->orderBy('id', 'desc')->paginate(10);
        return view('admin.permission.permission', compact('permissions'));

    }

    /**
     * 权限增加
     * @param Store $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Store $request)
    {
        $name = $request->get('name');
        $route = $request->get('route');
        $createOrFail = Permission::create(['name' => $name, 'route' => $route]);
        $createOrFail ? show_message('添加成功') : show_message('添加失败',false) ;
        operation_event(auth()->user()->name,'添加权限');
        return redirect()->back();
    }

    /**
     * 权限修改
     * @param null $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit( $id = null )
    {
        if (is_null($id)) {
            return abort(404, '对不起，找不到相关页面');
        }
        if (!$response = Permission::query()->find($id)) {
            return ajax_return(404, ['alert' => '未找到相关数据']);
        }
        return ajax_return(200, $response);
    }

    /**
     * @param Update $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Update $request)
    {
        $id = $request->get('id');
        $name=$request->get('edit_name');
        $route=$request->get('edit_route');
        $permission = Permission::query()->findOrFail($id);
        if(!$permission)
        {
            show_message('未查到相关，添加失败', false);
            return redirect()->back();
        }
        $permission->name = $name;
        $permission->route = $route;
        $saveOrFail = $permission->save();
        $saveOrFail ? show_message('修改成功'): show_message('修改失败',false);
        operation_event(auth()->user()->name,'修改权限');
        return redirect()->back();

    }

    /**
     * 权限删除
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $data = $request->only('pid');
        $arr = explode(',', $data['pid']);
         // TODO:同步删除权限相关
        DB::table('model_has_permissions')->whereIn('permission_id',$arr)->delete();
        DB::table('role_has_permissions')->whereIn('permission_id',$arr)->delete();
        $deleteOrFail = Permission::query()->whereIn('id',$arr)->delete();
        $deleteOrFail ? show_message('删除成功') : show_message('删除失败',false);
        operation_event(auth()->user()->name,'删除权限');
        return redirect()->back();
    }

    /**
     * 搜索
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $map = [
            ['name', 'like', '%' . $keyword . '%'],
        ];
        $permissions = Permission::query()->where($map)->orderBy('id', 'desc')->paginate(10);
        return view('admin.permission.permission', compact('permissions'));
    }
}
