<?php
/**
 * Created by PhpStorm.
 * User: Xuguozhi
 * Date: 2017/11/10
 * Time: 9:56
 */
namespace app\v1\command;

/**
 * @api {Cli} / cli脚本
 * @apiVersion 1.0.0
 * @apiGroup Cli
 * @apiSampleRequest off
 * @apiDescription
 * 命令运行方式：php think xxxxx
 * @apiSuccessExample all command:
 * MessageTemplateQueue 订单状态修改模板消息的队列处理
 * @package app\v1\command
 */
class Command extends \think\console\Command
{

}
