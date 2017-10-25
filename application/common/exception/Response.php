<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/23
 * Time: 14:59
 */
namespace app\common\exception;

use app\index\controller\Inlet;

class Response extends \think\controller\Rest
{
    /**
     * 输出返回数据
     * @access protected
     * @param mixed $data 要返回的数据
     * @param String $type 返回类型 JSON XML
     * @param integer $code HTTP状态码
     * @return Response
     */
    public static function create($data, $code=200){
        $type = (new self)->type;
        $content = Inlet::refactoringData($data, $code);
        return \think\Response::create($content, $type, 200);
    }
}