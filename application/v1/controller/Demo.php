<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/19
 * Time: 16:07
 */

namespace app\v1\controller;

use think\App;
use think\Request;
use think\Response;

/**
 * Class Demo
 * @package app\v1\controller
 */
class Demo extends Inlet
{
    /**
     * 预执行类栈定义
     * @return array
     */
    public function setClassStack()
    {
        return [];
    }

    public function _empty($method)
    {
    }

    public function _initialize()
    {
        parent::_initialize();
        $module = Request::instance()->module();
        $controller = Request::instance()->controller();
        $action = Request::instance()->action();
        list($Mcontroller, $Maction) = explode('-', $action);
        $controller = "\\app\\{$module}\\controller\\{$controller}\\" . $Mcontroller;
        /** @var Response $response */
        $response = App::invokeMethod([(new $controller()), $Maction]);
        $response->send();
    }
}
