<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/23
 * Time: 9:19
 */
namespace app\v1\init;


use think\Config;
use think\Exception;
use think\exception\HttpException;
use think\Session;

/**
 * 登录状态验证类（微信授权登录）
 * @package app\index\init
 */
class Login extends Base
{
    /**
     * @var string 登录session容器
     */
    public static $sessionName = 'login';

    // 当前用户信息
    public static $user;

    // 当前用户信息（登录微信账号）
    public static $wechatUser;

    public function __construct()
    {
        self::$user = json_decode(Session::get(self::$sessionName), true);
    }

    /**
     * 执行方法
     */
    public function run()
    {
        if (parent::runNext()) {
            if (empty(self::$user)) {
                // 抛出未登陆(小程序未登陆)
                throw new HttpException(401, '当前用户未登录');
            }
        }
    }
}