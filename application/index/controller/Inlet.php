<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/19
 * Time: 16:07
 */
namespace app\index\controller;

use think\controller\Rest;
use think\Exception;
use think\Request;
use think\Response;

/**
 * Rest接口开发基类
 * @package app\index\controller
 */
class Inlet extends Rest
{
    /**
     * 预执行类栈
     */
    public $classStack = [
        //Cors跨域验证
        'cors' => [
            'class' => '\app\index\init\Cors',
            'validation' => true
        ],
        //登录状态相关验证
        'login' => [
            'class' => '\app\index\init\Login',
            'validation' => true
        ],
    ];

    /**
     * Inlet constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        parent::__construct();
        // 控制器初始化
        $this->_initialize();
        // 初始化权限认证类栈定义
        $this->classStack = $this->setClassStack();
        // 权限认证类栈依次执行
        $this->_classStack();
    }

    /**
     * 控制器初始化
     */
    protected function _initialize()
    {
    }

    /**
     * 预执行类栈定义
     * @return array
     */
    public function setClassStack()
    {
        return $this->classStack;
    }

    /**
     * 预执行类栈依次执行
     * @return Response
     */
    protected function _classStack()
    {
        //填充$class
        $classStack = $this->classStack;
        $request = Request::instance();
        foreach ($classStack as $key => $value) {
            if (empty($value['scene']) || in_array($request->action(), $value['scene'])) {
                //该场景需要验证，逻辑向下
            } else {
                //不在验证场景范围内,退出本次循环
                continue;
            }

            //类的实例化
            $class = new $value['class']();
            //参数赋值
            foreach ($value as $k => $v) {
                if ($k == 'class') {
                    continue;
                }
                $class->$k = $v;
            }
            //run方法运行
            $return = $class->run();
        }
    }

    /**
     * 输出返回数据
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $type 返回类型 JSON XML
     * @param integer $code HTTP状态码
     * @return Response
     */
    protected function response($data, $code = 200, $type = 'json')
    {
        !empty($this->type) ? $type = $this->type : null;
        $content = self::refactoringData($data, $code);
        return Response::create($content, $type, 200);
    }

    /**
     * 数据格式重构
     * @param $data
     * @param $code
     * @return array
     */
    public static function refactoringData($data, $code)
    {
        $content = [];

        if (is_array($data))
            $content['item'] = $data;
        else
            $content['msg'] = $data;

        $content['status'] = $code;

        return $content;
    }
}
