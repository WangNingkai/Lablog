<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Overtrue\LaravelSocialite\Socialite;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\OauthInfo;
use App\Models\User;


class OAuthController extends Controller
{
    /**
     * @var array 第三方登录类型
     */
    public $type = [
        'qq'     => 1,
        'weibo'  => 2,
        'github' => 3
    ];

    /**
     * OAuthController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $service = $request->route('service');
        if (!empty($service) && !array_key_exists($service, $this->type)) {
            return abort(404, '对不起，找不到相关页面');
        }
    }

    /**
     * 将用户重定向到授权认证页面
     * @param $service
     * @return mixed
     */
    public function redirectToProvider($service)
    {
        return Socialite::driver($service)->redirect();
    }

    /**
     * 回调操作
     * @param Request $request
     * @param OauthInfo $oauthInfo
     * @param $service
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handleProviderCallback(Request $request, OauthInfo $oauthInfo, $service)
    {

        // TODO: 1) 迁移数据库文件 2)后台添加判断绑定跳转 3)登录页面添加关联登录 4)配置页面删除头像链接 5)后台查看第三方登录页面
        // 获取第三方登录用户资料
        $oauth_user = Socialite::driver($service)->user();

        // 判断当前用户是否登录
        if( !Auth::guest() )
        {
            $uid = Auth::id();
//            $user = User::findOrFail($uid);
            $checkBind = $oauthInfo->whereMap([
                'type'   => $service,
                'openid' => $oauth_user->id
            ])->first();
            if( $checkBind )
            {
                show_message('您已经绑定'.$service.'登录，无需再进行绑定',false);
                return redirect()->route('admin');
            }
            $data = [
                'user_id'  => $uid,
                'type' => $this->type[$service],
                'name' => $oauth_user->nickname,
                'avatar' => $oauth_user->avatar,
                'openid' => $oauth_user->id,
                'access_token' => $oauth_user->token,
                'last_login_ip' => $request->getClientIp(),
                'login_times' => 1,
            ];
//            $avatarPath = public_path('uploads/avatar/user_'.$uid.'.jpg');
//            try {
//                // 下载最新的头像到本地
//                $client = new Client(['verify' => false]);
//                $client->request('GET', $user->avatar, [
//                    'sink' => $avatarPath
//                ]);
//            } catch (ClientException $e) {
//                // 如果下载失败；则使用默认图片
//                copy(public_path('uploads/avatar/default.png'), $avatarPath);
//            }
            // 保存到第三方登录表
            $oauthInfo->storeData($data);
            show_message('绑定成功，下次可使用'.$service.'登录');
            return redirect()->route('dashboard_home');
        }

        // 查找数据库中是否已经存在该用户信息
        $user = $oauthInfo->whereMap([
            'type'   => $service,
            'openid' => $oauth_user->id
        ])->first();
        if ( !$user )
        {
            show_message('后台未绑定关联登录，请绑定后再关联登陆',false);
            return redirect()->route('login');
        }

       // 验证成功，登录并且「记住」给定的用户
        Auth::loginUsingId($user->user_id, true);
//        $oauthData=$oauthInfo->where('user_id',$user->id)->first();
        // 更新第三方登录信息
        $user->update([
            'name' => $user->nickname,
            'access_token' => $user->token,
            'last_login_ip' => $request->getClientIp(),
            'login_times' => $user->login_times+1,
        ]);
        return redirect()->route('dashboard_home');
    }

    /**
     * 退出登录
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->back();
    }
}
