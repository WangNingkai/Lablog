<?php
namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Overtrue\LaravelSocialite\Socialite;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\OauthInfo;
use App\Helpers\Extensions\Tool;


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
     * @param Request $request
     * @param OauthInfo $oauthInfo
     * @param $service
     * @return \Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handleProviderCallback(Request $request, OauthInfo $oauthInfo, $service)
    {

        // TODO: 确认密码后再操作
        // 获取第三方登录用户资料
        $oauth_user = Socialite::driver($service)->user();

        // 判断当前用户是否登录
        if( !Auth::guest() )
        {
            $uid = Auth::id();
            // 判断是否绑定
            $checkBind = $oauthInfo->whereMap([
                'type'   => $this->type[$service],
                'openid' => $oauth_user->id
            ])->first();
            if( $checkBind )
            {
                Tool::showMessage('您已经绑定'.$service.'登录，无需再进行绑定',false);
                return redirect()->route('dashboard_home');
            }
            // 如果是第一次绑定，替换默认管理员图片
            $avatarName = md5('user_'.$uid.'_'.$service);
            $avatarSavePath = public_path('uploads/avatar/'.$avatarName.'.jpg');
            $avatarPath = '/uploads/avatar/'.$avatarName.'.jpg';
            try {
                // 下载最新的头像到本地
                $client = new Client(['verify' => false]);
                $client->request('GET', $oauth_user->avatar, [
                    'sink' => $avatarSavePath
                ]);
            } catch (ClientException $e) {
                // 如果下载失败；则使用默认图片
//                copy(public_path('uploads/avatar/default.png'), $avatarSavePath);
                $avatarPath = '/uploads/avatar/default.jpg';
            }
            $user = Auth::user();
            // 如果用户默认头像为空或者为default，则关联登录头像
            if( empty($user->avatar) || strpos( $user->avatar,'default') )
            {
                $user->avatar = $avatarPath;
                $user->save();
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
            // 保存绑定信息
            $oauthInfo->storeData($data);
            Tool::recordOperation(auth()->user()->name,'关联'.$service.'登录');
            Tool::showMessage('绑定成功，下次可使用'.$service.'登录');
            return redirect()->route('dashboard_home');
        }
        // 查找用户是否存在绑定信息
        $user = $oauthInfo->whereMap([
            'type'   => $this->type[$service],
            'openid' => $oauth_user->id
        ])->first();
        if ( !$user )
        {
            Tool::showMessage('后台未绑定关联登录，请绑定后再关联登陆',false);
            return redirect()->route('login');
        }
       // 登录并且「记住」给定的用户
        Auth::loginUsingId($user->user_id, true);
        // 更新第三方登录信息
        $user->update([
            'name'          => $oauth_user->nickname,
            'access_token'  => $oauth_user->token,
            'last_login_ip' => $request->getClientIp(),
            'login_times'   => $user->login_times + 1,
        ]);
        Tool::showMessage('登陆成功，欢迎使用'.$service.'登录');
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
