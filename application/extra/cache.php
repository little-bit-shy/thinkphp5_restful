<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/31
 * Time: 15:18
 */

if (\think\Config::get('app_debug')) {
    return [
        // 缓存配置为复合类型
        'type' => 'complex',
        'default' => [
            'type' => 'redis',
            'host' => '127.0.0.1',
            // 全局缓存有效期（0为永久有效）
            'expire' => 0,
            // 缓存前缀
            'prefix' => 'think_',
            'select' => 8,
        ],
        // 添加更多的缓存类型设置
        'b' => [
            'type' => 'redis',
            'host' => '127.0.0.1',
            // 全局缓存有效期（0为永久有效）
            'expire' => 0,
            // 缓存前缀
            'prefix' => 'think_',
            'select' => 7,
        ],
    ];
} else {
    return [
        // 缓存配置为复合类型
        'type' => 'complex',
        'default' => [
            'type' => 'redis',
            'host' => '127.0.0.1',
            // 全局缓存有效期（0为永久有效）
            'expire' => 0,
            // 缓存前缀
            'prefix' => 'think_',
            'select' => 8,
        ],
        // 添加更多的缓存类型设置
        'b' => [
            'type' => 'redis',
            'host' => '127.0.0.1',
            // 全局缓存有效期（0为永久有效）
            'expire' => 0,
            // 缓存前缀
            'prefix' => 'think_',
            'select' => 7,
        ],
    ];
}