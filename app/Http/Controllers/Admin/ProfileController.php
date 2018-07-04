<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UpdatePassword;
use App\Http\Requests\Admin\UpdateProfile;
use App\Http\Controllers\Controller;
use App\Models\User as Admin;
use Auth;
use Hash;

class ProfileController extends Controller
{
    /**
     * 个人资料管理
     *
     * @return \Illuminate\Http\Response
     */
    public function manage()
    {
        $admin = Auth::user();
        return view('admin.profile.manage', compact('admin'));
    }

    /**
     * 更新密码
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UpdatePassword $request)
    {
        $admin = Auth::user();
        if (Hash::check($request->get('old_password'), $admin->password)) {
            $admin->password = bcrypt($request->get('password'));
            $admin->save();
            show_message('成功修改密码');
            operation_event(auth()->user()->name,'修改密码');
            return redirect()->back();
        }
        show_message('修改密码失败', false);
        return redirect()->back();
    }

    /**
     * 更新个人资料
     *
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(UpdateProfile $request)
    {
        $id = Auth::user()->id;
        $data = $request->all();
        $admin = Admin::findOrFail($id);
        $admin->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
        show_message('成功修改信息');
        operation_event(auth()->user()->name,'修改个人信息');
        return redirect()->back();
    }
}
