<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/19
 * Time: 16:07
 */

namespace app\v1\controller\demo;

use app\v1\controller\Inlet;

/**
 * dmeo相关数据
 * Class Demo
 * @package app\v1\controller\auction
 */
class Demo extends Inlet
{
    /**
     * 预执行类栈定义
     * @return array
     */
    public function setClassStack()
    {
        $classStack = parent::setClassStack();
        $classStack['login'] = [
            [
                'class' => '\app\v1\init\Login',
                'validation' => false
            ]
        ];
        return $classStack;
    }

    public function test()
    {
        return $this->response(['test' => 'this is test!!']);
    }
}
