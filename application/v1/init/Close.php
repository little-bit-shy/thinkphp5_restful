<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/23
 * Time: 9:19
 */
namespace app\v1\init;

use think\exception\HttpException;
use think\Response;


/**
 * 关闭接口验证类
 * @package app\index\init
 */
class Close extends Base
{
    /**
     * 执行方法
     */
    public function run()
    {
        if(parent::runNext()) {
            throw new HttpException(500, "该接口暂不提供使用");
        }
    }
}