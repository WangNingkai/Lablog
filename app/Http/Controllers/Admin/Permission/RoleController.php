<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Http\Requests\Role\Store;
use App\Http\Requests\Role\Update;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * 角色列表管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage()
    {
        $roles = Role::query()->orderBy('id', 'desc')->paginate(10);
        $permissions = Permission::query()->orderBy('route')->get();
        return view('admin.permission.role', compact('roles','permissions'));
    }

    /**
     * @param Store $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Store $request)
    {
        $name = $request->get('name');
        $permissions = $request->get('permissions');
        $createOrFail = Role::create(['name' => $name]);
        // 同步权限
        if($permissions)
        {
            $createOrFail->syncPermissions($permissions);
        }
        $createOrFail ? show_message('添加成功') : show_message('添加失败',false) ;
        operation_event(auth()->user()->name,'添加角色');
        return redirect()->back();
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $roles = Role::query()->orderBy('id', 'desc')->paginate(10);
        $edit_role = Role::findById($id);
        $permissions = Permission::query()->orderBy('name')->get();
        return view('admin.permission.role-edit',compact('edit_role','roles','permissions'));
    }

    /**
     * @param Update $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Update $request, $id)
    {
        $name=$request->get('name');
        $permissions = $request->get('permissions');
        $edit_role = Role::findById($id);
        $edit_role->name = $name;
        $saveOrFail = $edit_role->save();
        // 同步权限
        if($permissions)
        {
            $edit_role->syncPermissions($permissions);
        }
        $saveOrFail ? show_message('修改成功'): show_message('修改失败',false);
        operation_event(auth()->user()->name,'修改角色');
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $data = $request->only('rid');
        $arr = explode(',', $data['rid']);
        // 判断该角色是否存在用户，确定删除将用户角色移除，同时移除关联权限
        $roles = Role::query()->whereIn('id',$arr);
        foreach ($roles->get() as $role)
        {
            if($role->name == User::SUPERADMIN)
            {
                show_message('超级管理员角色无法删除',false);
                return redirect()->back();
            }
            // 返回要删除角色的用户.移除用户角色
            $users = User::role($role)->get();
            foreach($users as $user )
            {
                $user->removeRole($role);
            }
        }
        // 删除角色
        $deleteOrFail = $roles->delete();
        $deleteOrFail ? show_message('删除成功') : show_message('删除失败',false);
        operation_event(auth()->user()->name,'删除角色');
        return redirect()->back();

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $keyword = $request->get('keyword');
        $map = [
            ['name', 'like', '%' . $keyword . '%'],
        ];
        $roles = Role::query()->where($map)->orderBy('id', 'desc')->paginate(10);
        $permissions = Permission::all();
        return view('admin.permission.role', compact('roles','permissions'));
    }
}
