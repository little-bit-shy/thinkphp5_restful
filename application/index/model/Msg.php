<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/19
 * Time: 16:07
 */
namespace app\index\model;

class Msg extends Model
{
    protected $pk = 'id';

    public function getMsgAttr($value)
    {
        return $value;
    }

    public function aaa()
    {
        return $this->hasOne('\app\index\model\Msg', 'id');
    }

    public function bbb()
    {
        return $this->hasOne('\app\index\model\Msg', 'id');
    }

}
