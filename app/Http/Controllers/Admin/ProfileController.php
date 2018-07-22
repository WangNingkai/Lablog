<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UpdatePassword;
use App\Http\Requests\Admin\UpdateProfile;
use App\Http\Controllers\Controller;
use App\Models\OauthInfo;
use App\Models\User as Admin;
use http\Env\Request;
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
        $uid = Auth::id();
        $admin = Admin::where('id',$uid)->with('oauthinfos')->first();
        // 添加绑定判断
        foreach($admin->oauthinfos as $oauthinfo)
        {
            switch ($oauthinfo->type)
            {
                case OauthInfo::TYPE_QQ :
                    $admin['bindQQ'] = true;
                    $admin['qqName'] = $oauthinfo->name;
                    break;
                case OauthInfo::TYPE_WEIBO :
                    $admin['bindWeibo'] = true;
                    $admin['weiboName'] = $oauthinfo->name;
                    break;
                case OauthInfo::TYPE_GITHUB :
                    $admin['bindGithub'] = true;
                    $admin['githubName'] = $oauthinfo->name;
                    break;
            }

        }
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
        $uid = Auth::id();
        $data = $request->all();
        $admin = Admin::findOrFail($uid);
        $admin->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
        show_message('修改信息成功');
        operation_event(auth()->user()->name,'修改个人信息');
        return redirect()->back();
    }

    public function unbindThirdLogin(Request $request)
    {
        $uid = Auth::id();
        $param = [
            'qq'     => OauthInfo::TYPE_QQ,
            'weibo'  => OauthInfo::TYPE_WEIBO,
            'github' => OauthInfo::TYPE_GITHUB
        ];
        $type = $request->route('type');
        if (!empty($type) && !array_key_exists($type, $param)) {
            return abort(404, '对不起，找不到相关页面');
        }
        OauthInfo::whereMap([
            'user_id' => $uid,
            'type'    => $param[$type]
        ])->delete();
        operation_event(auth()->user()->name,'解除关联第三方登录');
        return redirect()->back();

    }

}
