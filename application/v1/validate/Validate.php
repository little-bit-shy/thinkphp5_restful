<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/19
 * Time: 16:43
 */
namespace app\v1\validate;

class Validate extends \think\Validate
{
    private $data;

    /**
     * 数据自动验证
     * @access public
     * @param array $data 数据
     * @param mixed $rules 验证规则
     * @param string $scene 验证场景
     * @return bool
     */
    public function check($data, $rules = [], $scene = '')
    {
        // 数据验证
        $check = parent::check($data, $rules = [], $scene = '');
        $this->data = $data;
        return $check;
    }

    /**
     * 返回验证数据
     * @return array
     */
    public function getData()
    {
        $scene = $this->getScene();
        $data = [];
        foreach ($scene as $key => $value) {
            if (is_array($value)) {
                $k = $key;
            } else {
                $k = $value;
            }
            if (isset($this->data[$k])) {
                $data[$k] = $this->data[$k];
            } else {
                $data[$k] = null;
            }
        }
        return $data;
    }

    /**
     * @param $value
     * @param $rules
     * @param $data
     * @return bool|string
     */
    public function isString($value, $rules, $data)
    {
        if (is_string($value)) {
            return true;
        }
        return ":attribute必须是字符串";
    }

    /**
     * @param $value
     * @param $rules
     * @param $data
     * @return bool|string
     */
    public function keyNotEmpty($value, $rules, $data)
    {
        if (!is_array($value)) {
            return false;
        }

        foreach ($rules as $key) {
            if (!key_exists($key, $value) || empty($value[$key])) {
                return false;
            }
        }
        return true;
    }

    /**
     * 参数存在必须满足相关条件（某个参数值为什么的时候）
     * @param $value
     * @param $rules
     * @param $data
     * @return bool|string
     */
    public function requireWithIf($value, $rules, $data)
    {
        $rules = explode(':', $rules);
        list($attribute, $in) = $rules;
        $ins = explode(',', $in);
        if (in_array($data[$attribute], $ins) && empty($value)) {
            return ":attribute不能为空";
        }
        return true;
    }
}