<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Extensions\Tool;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\User\UpdatePassword;
use App\Http\Requests\User\UpdateProfile;
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
        $uid = Auth::id();
        $admin = Admin::query()->where('id',$uid)->with('oauthinfos')->first();
        foreach($admin->oauthinfos as $oauthinfo) {
            switch ($oauthinfo->type) {
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

    public function uploadAvatar()
    {
        $uid = Auth::id();
        $path = 'uploads/avatar';
        $rule = ['avatar' => 'required|max:2048|image|dimensions:max_width=200,max_height=200'];
        $avatarName = md5('user_'.$uid.'_avatar');
        // 先删除原图片再上传 ,上传失败恢复默认图片
        @unlink(public_path('uploads/avatar') . $avatarName.'.png');
        $response = Tool::uploadFile('avatar', $rule, $path, $avatarName);
        $avatarPath = '/uploads/avatar' . $avatarName.'.png';
        if (200 === $response['status_code'])
        {
            $avatarPath = $response['data']['publicPath'];
            Tool::showMessage('头像上传成功');
        }else{
            Tool::showMessage($response['message'],false);
        }
        $user = User::query()->find($uid);
        $user->update([
            'avatar' => $avatarPath
        ]);
        return redirect()->route('profile_manage');
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
            Tool::showMessage('修改密码成功');
            Tool::recordOperation(auth()->user()->name,'修改密码');
            return redirect()->back();
        }
        Tool::showMessage('原密码错误，修改密码失败', false);
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
        $admin = Admin::query()->findOrFail($uid);
        $admin->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);
        Tool::showMessage('修改信息成功');
        Tool::recordOperation(auth()->user()->name,'修改个人信息');
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
        $type = $request->get('type');
        if (!empty($type) && !array_key_exists($type, $param)) {
            return abort(404, '对不起，找不到相关页面');
        }
        OauthInfo::whereMap([
            'user_id' => $uid,
            'type'    => $param[$type]
        ])->delete();
        Tool::showMessage('解除'.$type.'登录成功');
        Tool::recordOperation(auth()->user()->name,'解除关联'.$type.'登录');
        return redirect()->back();

    }

}
