<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/23
 * Time: 9:19
 */
namespace app\v1\init;


use think\Exception;
use think\exception\HttpException;
use think\Request;

/**
 * 请求方法验证类
 * @package app\index\init
 */
class RequestMethod extends Base
{
    /**
     * @var array 请求允许是用的方法,空则所有方法都通过
     */
    public $method = ['GET', 'POST'];

    /**
     * @var string 请求方法错误返回描述
     */
    public $requestMethodErrorMsg = '当前请求方法不被允许';

    /**
     * 执行方法
     */
    public function run()
    {
        if (parent::runNext()) {
            if (!empty($this->method)) {
                if (!in_array(Request::instance()->method(), $this->method)) {
                    // 抛出请求失败
                    throw new HttpException(405, $this->requestMethodErrorMsg);
                }
            }
        }
    }
}