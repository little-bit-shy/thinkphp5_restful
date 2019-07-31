<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/10/23
 * Time: 9:19
 */
namespace app\v1\init;

use think\Cache;
use think\exception\HttpException;
use think\Request;
use think\Response;


/**
 * 请求频率验证类
 * @package app\index\init
 */
class RequestFrequencyLimit extends Base
{
    /**
     * {$second}秒可请求{$limit}次
     * @var int
     */
    public $limit = 1;

    /**
     * {$second}秒可请求{$limit}次
     * @var int
     */
    public $second = 1;

    /**
     * 执行方法
     */
    public function run()
    {
        if (parent::runNext()) {
            $session_id = session_id();
            if (!empty($session_id)) {
                $request = Request::instance();
                // 将请求信息加上会话信息作为key缓存标识
                $key = md5(implode('_', $request->request()) . $session_id);
                $data = Cache::get($key);
                // 当前时间
                $time = time();
                if (empty($data)) {
                    // 初始化频率缓存数据
                    Cache::set($key, json_encode([
                        'time' => $time,
                        'limit' => $this->limit - 1,
                    ]), $this->second);
                } else {
                    if ($time - $data['time'] <= $this->second) {
                        if ($data['limit'] <= 0) {
                            throw new HttpException(429, "当前接口请求频率过高, 频率限制信息 {$this->limit}次/{$this->second}秒");
                        } else {
                            // 更新频率缓存数据
                            Cache::set($key, json_encode([
                                'time' => $data['time'],
                                'limit' => $data['limit'] - 1,
                            ]), $this->second);
                        }
                    } else {
                        // 初始化频率缓存数据
                        Cache::set($key, json_encode([
                            'time' => $time,
                            'limit' => $this->limit - 1,
                        ]), $this->second);
                    }
                }
            }
        }
    }
}