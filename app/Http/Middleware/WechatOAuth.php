<?php

namespace App\Http\Middleware;


use App\Api\WechatHelpers;
use App\Models\Members;
use Closure;
use EasyWeChat\Support\Log;
use Illuminate\Contracts\Session\Session;

class WechatOAuth
{


    /**
     * Use Service Container would be much artisan.
     */
    private $wechat;

    /**
     * Inject the wechat service.
     * @param WechatHelpers $wechat
     */
    public function __construct(WechatHelpers $wechat)
    {
        $this->wechat = $wechat->getWechat();
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $scopes
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $scopes = 'snsapi_userinfo')
    {
        if (!$this->isWeChatBrowser($request)) {
            return $next($request);
        }


        if (is_string($scopes)) {
            $scopes = array_map('trim', explode(',', $scopes));
        }

        if (!session('wechat.oauth_user') || $this->needReauth($scopes)) {
            if ($request->has('code')) {
                $user = $this->wechat->oauth->user();
                Log::info('oauth_user is ---' . json_encode($user));
                session(['wechat.oauth_user' => $user]);
                Session::save();
                Log::info('session---' . json_encode(session(['wechat.oauth_user'])));
                $this->checkMember($user);

                return redirect()->to($this->getTargetUrl($request));
            }

            session()->forget('wechat.oauth_user');

            return $this->wechat->oauth->setRequest($request)->scopes($scopes)->redirect($request->fullUrl());
        }

        return $next($request);
    }

    /**
     * Build the target business url.
     *
     * @param Request $request
     *
     * @return string
     */
    protected function getTargetUrl($request)
    {
        $queries = array_except($request->query(), [
            'code',
            'state',
        ]);

        return $request->url() . (empty($queries) ? '' : '?' . http_build_query($queries));
    }

    /**
     * Is different scopes.
     *
     * @param  array $scopes
     *
     * @return bool
     */
    protected function needReauth($scopes)
    {
        return session('wechat.oauth_user.original.scope') == 'snsapi_base' && in_array("snsapi_userinfo", $scopes);
    }

    /**
     * Detect current user agent type.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    protected function isWeChatBrowser($request)
    {
        return strpos($request->header('user_agent'), 'MicroMessenger') !== false;
    }

    protected function checkMember($user)
    {
        $openid = $user->getId();
        $member = new Members();
        if ($record = $member->where('openid', $openid)->first()) {
            $record->nickname = $user->getNickname();
            $record->avatar   = $user->getAvatar();
            $record->save();
        } else {
            $member->openid    = $openid;
            $member->nickname  = $user->getNickname();
            $member->avatar    = $user->getAvatar();
            $member->status    = 1;
            $member->gender    = 1;
            $member->group_id  = 1;
            $member->level_id  = 1;
            $member->is_follow = 1;
            $member->save();
        }
    }
}
