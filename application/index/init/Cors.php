<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/23
 * Time: 9:19
 */
namespace app\index\init;
use think\Response;


/**
 * Cors跨域验证类
 * @package app\index\init
 */
class Cors implements Init
{
    /**
     * @var bool 是否开启Cors跨域
     */
    public $validation = true;

    /**
     * 验证场景action
     * @var array
     */
    public $scene = [];

    /**
     * 执行方法
     */
    public function run()
    {
        if ($this->validation === true) {//开启Cors跨域
            header('Access-Control-Allow-Origin:*');
        }
    }
}