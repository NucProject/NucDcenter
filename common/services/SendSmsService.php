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
    * `send_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '����ID',
    * `send_type` int(11) NOT NULL DEFAULT '0' COMMENT '��������',
    * `send_mobile` varchar(12) NOT NULL DEFAULT '' COMMENT '�ֻ�����',
    * `send_text` varchar(255) NOT NULL DEFAULT '' COMMENT '��������',
    * `mark` varchar(32) NOT NULL DEFAULT '' COMMENT '��ע',
    * `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '����״̬>0|δ����,1|����',
    * `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '����ʱ��',
    * `last_modified` datetime NOT NULL DEFAULT '0000-00-00 00:00:00' COMMENT '�޸�ʱ��',
    * PRIMARY KEY (`send_id`)
    * ) ENGINE=InnoDB AUTO_INCREMENT=571 DEFAULT CHARSET=utf8;
 */
class SendSmsService
{

}