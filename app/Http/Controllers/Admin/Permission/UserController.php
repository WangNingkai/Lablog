<?php

namespace App\Http\Controllers\Admin\Permission;

use App\Http\Requests\User\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * @var User
     */
    protected $user;

    /**
     * PermissionController constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * 用户管理列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage()
    {
        $users = $this->user->query()->orderBy('id', 'desc')->paginate(10);
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

    public function store(Store $request)
    {
        event(new Registered($user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ])));
        $roles = $request->get('roles');
        $user->assignRole($roles);
        show_message('添加成功');
        return redirect()->route('user_manage');
    }
    // 用户修改
    public function edit()
    {}
    public function update()
    {}
    // 用户删除
    public function destroy(Request $request)
    {}
    public function search()
    {}
}
