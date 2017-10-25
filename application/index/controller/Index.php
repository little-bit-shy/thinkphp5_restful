<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/19
 * Time: 16:07
 */
namespace app\index\controller;

use app\index\model\Msg;
use think\Db;
use think\exception\ValidateException;
use think\Loader;
use think\Response;

class Index extends Inlet
{
    /**
     * 预执行类栈定义
     * @return array
     */
    public function setClassStack()
    {
        $classStack = parent::setClassStack();
        //登录状态相关验证
        $classStack['login'] = [
            'class' => '\app\index\init\Login',
            'validation' => true,
            'scene' => ['test']
        ];

        return $classStack;
    }

    public function index($page = 1)
    {
        /** @var \app\index\validate\Msg $validate */
        $validate = Loader::validate('Msg');
        $data = [
            'id' => 37,
            'msg' => time()
        ];
        if (!$validate->scene('select')->check($data)) {
            throw new ValidateException($validate->getError());
        }

        $content = Msg::with(['aaa' => function ($query) {
            $query->field('id,msg');
            $query->with(['bbb']);
        }, 'bbb'])
            ->page($page)
            ->order('id desc')
            ->failException(true)
            ->select();
        /*// 启动事务
        Db::startTrans();
        try {
            Msg::update(['msg' => time()], ['id' => 37]);
            Db::commit();
        } catch (\Exception $e) {
            Db::rollback();
        }*/
        return $this->response($content);
    }

    public function test()
    {
        return $this->response(['test' => 'this is test!!']);
    }
}
