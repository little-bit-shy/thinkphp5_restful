<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/23
 * Time: 9:19
 */

namespace app\v1\init;

use think\Response;


/**
 * Cors跨域验证类
 * @package app\index\init
 */
class Cors extends Base
{
    /**
     * 执行方法
     */
    public function run()
    {
        if (parent::runNext()) {
            header('Access-Control-Allow-Origin: *');
            header("Access-Control-Allow-Credentials: true");
        }
    }
}