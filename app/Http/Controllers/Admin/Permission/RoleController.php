<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Http\Requests\Role\Store;
use App\Http\Requests\Role\Update;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function manage()
    {
        $roles = Role::query()->orderBy('id', 'desc')->paginate(10);
        $permissions = Permission::all();
        return view('admin.permission.role', compact('roles','permissions'));
    }
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

    public function edit($id)
    {
        $roles = Role::query()->orderBy('id', 'desc')->paginate(10);
        $edit_role = Role::findById($id);
        $permissions = Permission::all();
        return view('admin.permission.role-edit',compact('edit_role','roles','permissions'));
    }

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

    public function destroy(Request $request)
    {

    }
    public function search(Request $request)
    {

    }
}
