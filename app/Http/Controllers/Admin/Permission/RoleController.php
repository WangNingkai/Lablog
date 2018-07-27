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
    protected $role;

    public function __construct(Role $role)
    {
        $this->role = $role;
    }
    // 角色管理

    // 角色增加

    // 角色修改

    // 角色删除
    public function manage()
    {
        $roles = $this->role->query()->orderBy('id', 'desc')->paginate(10);
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
        $roles = $this->role->query()->orderBy('id', 'desc')->paginate(10);
        $edit_role = $this->role->findById($id);
        $permissions = Permission::all();
        return view('admin.permission.role-edit',compact('edit_role','roles','permissions'));
    }

    public function update(Update $request, $id)
    {
        $name=$request->get('name');
    }
    public function destroy(){}
    public function search(){}
}
