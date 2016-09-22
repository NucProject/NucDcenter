<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/22
 * Time: 16:36
 */

namespace common\services;

/**
 * Class SendSmsService
 * @package common\services
 *
 * CREATE TABLE `sys_send_sms` (
    * `send_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '发送ID',
    * `send_type` int(11) NOT NULL DEFAULT '0' COMMENT '发送类型',
    * `send_mobile` varchar(12) NOT NULL DEFAULT '' COMMENT '手机号码',
    * `send_text` varchar(255) NOT NULL DEFAULT '' COMMENT '发送内容',
    * `mark` varchar(32) NOT NULL DEFAULT '' COMMENT '备注',
    * `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '发送状态>0|未发送,1|发送',
    * `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '创建时间',
    * `last_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '修改时间',
    * PRIMARY KEY (`send_id`)
    * ) ENGINE=InnoDB AUTO_INCREMENT=571 DEFAULT CHARSET=utf8;
 */
class SendSmsService
{

}