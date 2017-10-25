<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/23
 * Time: 9:50
 */
namespace app\index\init;

/**
 * 初始化类栈接口
 * @package app\index\init
 */
interface Init
{
    /**
     * 执行方法
     */
    public function run();
}