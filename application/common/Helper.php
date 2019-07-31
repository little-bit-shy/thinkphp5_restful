<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/23
 * Time: 14:59
 */
namespace app\common;

use think\Cache;
use think\Config;

class Helper
{
    /**
     * 生成唯一订单号
     * @return string
     */
    public static function makeOrderId($uid, $id = 0)
    {
        if ($id == 0) {
            return time() . $uid . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9);
        } else {
            return time() . $id . rand(1, 9) . rand(1, 9) . rand(1, 9) . rand(1, 9);
        }
    }

    /**
     * 获取客户端IP地址
     * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @return mixed
     */
    public static function get_client_ip($type = 0)
    {
        $type = $type ? 1 : 0;
        static $ip = NULL;
        if ($ip !== NULL) return $ip[$type];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) unset($arr[$pos]);
            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        // IP地址合法验证
        $long = sprintf("%u", ip2long($ip));
        $ip = $long ? array($ip, $long) : array('0.0.0.0', 0);
        return $ip[$type];
    }

    /**
     * 系统加密方法
     * @param string $data 要加密的字符串
     * @param string $key 加密密钥
     * @param int $expire 过期时间 单位 秒
     * @return string
     */
    public static function think_encrypt($data, $key = 'P^"0eKbVwN:S(z#<_$R9WL{Dlys)oj-f=!grX?EH', $expire = 0)
    {
        $key = md5($key);
        $data = base64_encode($data);
        $x = 0;
        $len = strlen($data);
        $l = strlen($key);
        $char = '';

        for ($i = 0; $i < $len; $i++) {
            if ($x == $l) $x = 0;
            $char .= substr($key, $x, 1);
            $x++;
        }

        $str = sprintf('%010d', $expire ? $expire + time() : 0);
        for ($i = 0; $i < $len; $i++) {
            $str .= chr(ord(substr($data, $i, 1)) + (ord(substr($char, $i, 1))) % 256);
        }

        return str_replace(array('+', '/', '='), array('-', '_', ''), base64_encode($str));
    }

    /**
     * 生成随机字符串
     * @param int $length 生成随机字符串的长度
     * @param string $char 组成随机字符串的字符串
     * @return string $string 生成的随机字符串
     */
    public static function str_rand($length = 32, $char = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
    {
        if (!is_int($length) || $length < 0) {
            return false;
        }

        $string = '';
        for ($i = $length; $i > 0; $i--) {
            $string .= $char[mt_rand(0, strlen($char) - 1)];
        }

        return $string;
    }

    /**
     * 身份证中提取生日
     * @param $identity_card
     * @return string
     */
    public static function getBirthWithIdentityCard($identity_card)
    {
        return strlen($identity_card) == 15 ? ('19' . substr($identity_card, 6, 6)) : substr($identity_card, 6, 8);
    }

    /**
     * 身份证中提取性别
     * @param $identity_card
     * @return string
     */
    public static function getSexWithIdentityCard($identity_card)
    {
        return substr($identity_card, (strlen($identity_card) == 15 ? -2 : -1), 1) % 2 ? '1' : '0'; //1为男 2为女
    }
}