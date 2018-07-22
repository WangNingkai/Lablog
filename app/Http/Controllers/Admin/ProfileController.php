<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UpdatePassword;
use App\Http\Requests\Admin\UpdateProfile;
use App\Http\Controllers\Controller;
use App\Models\OauthInfo;
use App\Models\User as Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * 资料管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function manage()
    {
        $admin = Auth::user();
        return view('admin.profile', compact('admin'));
    }

    /**
     * 更新密码
     * @param UpdatePassword $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(UpdatePassword $request)
    {
        $admin = Auth::user();
        if (Hash::check($request->get('old_password'), $admin->password)) {
            $admin->password = bcrypt($request->get('password'));
            $admin->save();
            show_message('修改密码成功');
            operation_event(auth()->user()->name,'修改密码');
            return redirect()->back();
        }
        show_message('原密码错误，修改密码失败', false);
        return redirect()->back();
    }

    /**
     * 更新个人资料
     * @param UpdateProfile $request
     * @return \Illuminate\Http\RedirectResponse
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
        show_message('修改信息成功');
        operation_event(auth()->user()->name,'修改个人信息');
        return redirect()->back();
    }

    public function getOauthInfo(OauthInfo $oauthInfo, $type, $open_id)
    {
        $authData = $oauthInfo->whereMap([
            'type'   => $type,
            'openid' => $open_id
        ])->first();

    }
}
