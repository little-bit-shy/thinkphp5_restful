<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/23
 * Time: 9:50
 */

namespace app\v1\init;

use think\Request;

/**
 * 初始化类栈抽象基类
 * @package app\index\init
 */
abstract class Base
{
    /**
     * 验证场景action
     * @var array
     */
    public $scene = [];

    /**
     * @var bool 是否验证状态
     */
    public $validation = false;

    /**
     * @var bool action
     */
    public $action = null;

    /**
     * 程序是否往下走
     * @return bool
     */
    public function runNext()
    {
        $this->action = Request::instance()->action();
        switch ($this->validation) {
            case true:
                if (empty($this->scene) || in_array($this->action, $this->scene)) {
                    //该场景需要验证，逻辑向下
                    return true;
                } else {
                    //不在验证场景范围内,退出本次循环
                    return false;
                }
                break;
            case false:
                if (in_array($this->action, $this->scene) || empty($this->scene)) {
                    // 不在验证场景范围内,退出本次循环
                    return false;
                } else {
                    // 该场景需要验证，逻辑向下
                    return true;
                }
                break;
        }
    }

    /** 行为执行方法 */
    abstract protected function run();
}