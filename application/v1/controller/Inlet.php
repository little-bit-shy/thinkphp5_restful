<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/19
 * Time: 16:07
 */

namespace app\v1\controller;

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
     * @var array 请求数据
     */
    public $requestData = [];

    /**
     * 预执行类栈
     */
    public $classStack = [
        // Cors跨域验证
        'cors' => [
            [
                'class' => '\app\v1\init\Cors',
                'validation' => true
            ]
        ],
        // 请求方法相关验证
        'requestMethod' => [
            [
                'class' => '\app\v1\init\RequestMethod',
                'validation' => false
            ]
        ],
        // 登录状态相关验证
        'login' => [
            [
                'class' => '\app\v1\init\Login',
                'validation' => true
            ]
        ],
        // 请求频率验证类
        'requestFrequencyLimit' => [
            [
                'class' => '\app\v1\init\RequestFrequencyLimit',
                'limit' => 10,
                'second' => 1,
                'validation' => true
            ]
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
        // 请求数据获取
        if (Request::instance()->isGet()) {
            $this->requestData = Request::instance()->get();
        } elseif (Request::instance()->isPost()) {
            $this->requestData = Request::instance()->post();
        }
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
     */
    protected function _classStack()
    {
        //填充$class
        $classStack = $this->classStack;
        foreach ($classStack as $key => $value) {
            if (empty($value)) {
                //参数异常,退出本次循环
                continue;
            }
            foreach ($value as $kk => $vv) {
                //类的实例化
                $class = new $vv['class']();
                //参数赋值
                foreach ($vv as $k => $v) {
                    if ($k == 'class') {
                        continue;
                    }
                    $class->$k = $v;
                }
                //run方法运行
                $class->run();
            }
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

        if (is_string($data)) {
            if ($data === '') {
                $content['item'] = null;
            } else {
                $content['msg'] = $data;
            }
        } else {
            $content['item'] = $data;
        }
        $content['status'] = $code;

        return $content;
    }
}
