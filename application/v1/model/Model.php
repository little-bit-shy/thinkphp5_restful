<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/19
 * Time: 16:07
 */
namespace app\v1\model;

use app\v1\init\Login;
use think\Cache;

class Model extends \think\Model
{
    // 缓存时间
    public $expire = 300;
    // get_called_class()
    public $className;

    protected function initialize()
    {
        parent::initialize();
        $this->className = get_called_class();
        self::event('before_insert', function (self $self) {
            $this->clearTag();
        });
        self::event('before_update', function (self $self) {
            $this->clearTag();
        });
        self::event('before_delete', function (self $self) {
            $this->clearTag();
        });
    }

    /**
     * 清除tag依赖数据
     */
    public function clearTag()
    {
        $tags = $this->getTag();
        foreach ($tags as $tag) {
            Cache::clear($tag);
        }
    }

    /**
     * 定义需要清除的tag依赖数据
     * @return array
     */
    public function getTag()
    {
        $tags = [];
        $tags[] = $this->className;
        // 判断用户是否登录
        $user = Login::$user;
        if (!empty($user['uid'])) {
            $tags[] = $this->className . $user['uid'];
        }
        return $tags;
    }

    /**
     * 保存当前数据对象
     * @access public
     * @param array $data 数据
     * @param array $where 更新条件
     * @param string $sequence 自增序列名
     * @return integer|false
     */
    public function save($data = [], $where = [], $sequence = null)
    {
        // 释放空数据
        foreach ($data as $key => $value) {
            if ($value !== 0 && empty($value)) {
                unset($data[$key]);
            }
        }
        parent::save($data, $where, $sequence);
    }
}
