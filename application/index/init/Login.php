<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/23
 * Time: 9:19
 */
namespace app\index\init;


use think\Exception;
use think\exception\ValidateException;
use think\Session;

/**
 * 登录状态验证类
 * @package app\index\init
 */
class Login implements Init
{
    /**
     * @var bool 是否验证登录状态
     */
    public $validation = false;

    /**
     * @var string 登录session容器
     */
    public $sessionName = 'login';

    /**
     * @var string 账号未登陆返回描述
     */
    public $noLoginMsg = '当前用户未登录';

    /**
     * 验证场景action
     * @var array
     */
    public $scene = [];

    /**
     * 执行方法
     */
    public function run()
    {
        if ($this->validation === true) {//需验证
            $login = Session::get($this->sessionName);
            if (empty($login)) {
                // 抛出未登陆
                throw new ValidateException($this->noLoginMsg);
            }
        }
    }
}