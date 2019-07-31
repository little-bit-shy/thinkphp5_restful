<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/19
 * Time: 16:07
 */

namespace app\v1\controller;

use think\exception\ValidateException;
use think\Loader;

/**
 * 示例控制器
 * Class Site
 * @package app\v1\controller
 */
class Site extends Inlet
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

    public function index()
    {
        /** @var \app\v1\validate\Msg $validate */
        $validate = Loader::validate('Msg');
        $data = [
            'id' => 37,
            'msg' => time()
        ];
        if (!$validate->scene('add')->check($data)) {
            throw new ValidateException($validate->getError());
        }
        return $this->response($validate->getData());
    }
}
