<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/19
 * Time: 16:43
 */
namespace app\v1\validate;

class Msg extends Validate
{
    protected $rule = [
        'id|编号' => ['require'],
        'msg|消息' => ['require', 'max'=>11],
    ];

    protected $scene = [
        'add'  =>  ['msg'],
        'select'  =>  ['id'],
    ];

    protected $message  =   [
        'msg.require' => ':attribute必填',
        'msg.max'     => ':attribute最多不能超过25个字符',
    ];

    // 自定义验证规则
    protected function checkMsg($value,$rule,$data)
    {
        return !$value ? true : '消息永远错误';
    }
}