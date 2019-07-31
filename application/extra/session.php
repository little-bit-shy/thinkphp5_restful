<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/31
 * Time: 15:18
 */

if (\think\Config::get('app_debug')) {
    return [
        'id' => '',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => '',
        // SESSION 前缀
        'prefix' => 'think',
        // 驱动方式 支持redis memcache memcached
        'type' => 'redis',
        // 是否自动开启 SESSION
        'auto_start' => true,
        'host' => '127.0.0.1',
        'port' => '6379',
        'password' => '',
        'select' => 8,
        'expire' => 0,
        'timeout' => 0,
        'persistent' => true,
        'session_name' => '',
    ];
} else {
    return [
        'id' => '',
        // SESSION_ID的提交变量,解决flash上传跨域
        'var_session_id' => '',
        // SESSION 前缀
        'prefix' => 'think',
        // 驱动方式 支持redis memcache memcached
        'type' => 'redis',
        // 是否自动开启 SESSION
        'auto_start' => true,
        'host' => '127.0.0.1',
        'port' => '6379',
        'password' => '',
        'select' => 8,
        'expire' => 0,
        'timeout' => 0,
        'persistent' => true,
        'session_name' => '',
    ];
}