<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Http\Requests\User\Store;
use App\Http\Requests\User\Update;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    /**
     * 用户管理列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage()
    {
        $users = User::query()->orderBy('id', 'desc')->paginate(10);
        return view('admin.permission.user', compact('users'));

    }

    /**
     * 注册用户
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.permission.user-create',compact('roles'));
    }

    /**
     * @param Store $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Store $request)
    {
        event(new Registered($creatOrFail = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'status' => $request['status']
        ])));
        $roles = $request->get('roles');
        $creatOrFail->assignRole($roles);
        $creatOrFail?show_message('添加成功'):show_message('添加失败',false);
        operation_event(auth()->user()->name,'注册用户');
        return redirect()->route('user_manage');
    }

    /**
     * 用户修改
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if(Auth::id() != User::SUPERUSER)
        {
            show_message('非超级管理员禁止编辑',false);
            return redirect()->back();
        }
        $roles = Role::all();
        $user = User::findOrFail($id);
        return view('admin.permission.user-edit',compact('roles','user'));

    }

    /**
     * @param Update $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Update $request, $id)
    {
        $user = User::findOrFail($id);
        $roles = $request->get('roles');
        $saveOrFail = $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'status' => $request['status'],
        ]);
        $user->syncRoles($roles);
        $saveOrFail?show_message('编辑成功'):show_message('编辑失败',false);
        operation_event(auth()->user()->name,'编辑用户');
        return redirect()->route('user_manage');
    }

    /**
     * 用户软删除
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $data = $request->only('uid');
        $arr = explode(',', $data['uid']);
        foreach($arr as $uid)
        {
            if($uid == User::SUPERUSER)
            {
                show_message('超级管理员禁止删除' ,false);
                return redirect()->back();
            }
        }
        $users = User::query()->whereIn('id',$arr);
        $deleteOrFail = $users->delete();
        $deleteOrFail ? show_message('删除成功') : show_message('删除失败',false);
        operation_event(auth()->user()->name,'删除用户');
        return redirect()->back();

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function trash()
    {
        $users = User::query()
            ->orderBy('deleted_at', 'desc')
            ->onlyTrashed()
            ->paginate(10);
        return view('admin.permission.user-trash', compact('users'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Request $request)
    {
        $data = $request->only('uid');
        $arr = explode(',', $data['uid']);
        if (!User::query()->whereIn('id', $arr)->restore()) {
            show_message('恢复失败', false);
            return redirect()->back();
        }
        show_message('恢复成功');
        operation_event(auth()->user()->name,'恢复软删除用户');
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $data = $request->only('uid');
        $arr = explode(',', $data['uid']);
        $users = User::query()->whereIn('id',$arr);
        foreach ($users->get() as $user)
        {
            // 判断用户有哪些角色和权限， 删除用户关联角色记录
            DB::table('model_has_roles')->where('model_id',$user->id)->delete();
            DB::table('model_has_permissions')->where('model_id',$user->id)->delete();
        }
        $destroyOrFail = $users->forceDelete();
        $destroyOrFail ? show_message('删除成功') : show_message('删除失败',false);
        operation_event(auth()->user()->name,'完全删除用户');
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
        $users = User::query()->where($map)->orderBy('id', 'desc')->paginate(10);
        return view('admin.permission.user', compact('users'));
    }
}
