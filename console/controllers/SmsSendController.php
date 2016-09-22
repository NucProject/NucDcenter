<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\NucDataCenter;
use common\models\NucDevice;

/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/19
 * Time: 21:44
 */
class SmsSendController extends Controller
{
    // 从last_send_id开始找没发送的
    const SQL_FETCH_UNSENT_SMS = "select * from sys_send_sms where send_id >= %(last_send_id)s and status != 1 order by send_id desc limit 1000";

    // 从最新的1000个里面找没有发送的(用于补救的)
    const SQL_FETCH_RECOVER_SMS = "select * from sys_send_sms where status != 1 order by send_id desc limit 1000";


    public function actionExec() {
        $lastSendId = 0;
        $lastSendId2 = -1;   // 更新$lastSendId的时候才echo用
        $seconds = 0;
        while (true) {
            if ($lastSendId2 != $lastSendId)
            {
                echo "Send sms from send_id=$lastSendId\n";
                $lastSendId2 = $lastSendId;
            }

            $lastSendId = $this->batchSend($lastSendId);
            sleep(1);
            $seconds += 1;

            if ($seconds % 10 == 0) {
                // 每10秒补救一次(如果存在漏法的)
                $this->recoverSend();
            }
        }
    }

    public function batchSend($lastSendId) {
        $lastSendId = $lastSendId ?: 0;

        $sql = self::sprintfWithArray(self::SQL_FETCH_UNSENT_SMS, array('last_send_id' => $lastSendId));
        $array = Yii::app()->db->createCommand($sql)->query();

        $sendTotalArray = array();
        $sendFailedArray = array();
        foreach ($array as $item) {
            $sendId = $item['send_id'];
            array_push($sendTotalArray, $sendId);

            $result = self::sendSms($item);

            if ($result) {
                // 设置为发送
                SysSendSms::model()->updateByPk($sendId, array('status' => 1, 'last_modified' => date('Y-m-d H:i:s')));
            } else {
                // 设置为发送失败
                SysSendSms::model()->updateByPk($sendId, array('status' => 2, 'last_modified' => date('Y-m-d H:i:s')));
                array_push($sendFailedArray, $sendId);
            }
        }

        if (!empty($sendFailedArray)) {
            return min($sendFailedArray);
        } else if (!empty($sendTotalArray)) {
            return max($sendTotalArray);
        } else {
            return $lastSendId;
        }
    }

    public function recoverSend() {

        $array = Yii::app()->db->createCommand(self::SQL_FETCH_RECOVER_SMS)->query();

        foreach ($array as $item) {
            $sendId = $item['send_id'];
            $result = self::sendSms($item);

            if ($result) {
                // 设置为发送
                SysSendSms::model()->updateByPk($sendId, array('status' => 1, 'last_modified' => date('Y-m-d H:i:s')));
            } else {
                // 设置为发送失败
                SysSendSms::model()->updateByPk($sendId, array('status' => 2, 'last_modified' => date('Y-m-d H:i:s')));
                array_push($sendFailedArray, $sendId);
            }
        }
    }

    private static function sprintfWithArray($string, $array) {
        $keys    = array_keys($array);
        $keysMap = array_flip($keys);
        $values  = array_values($array);

        while (preg_match('/%\(([a-zA-Z0-9_ -]+)\)/', $string, $m)) {
            if (!isset($keysMap[$m[1]])) {
                return false;
            }
            $string = str_replace($m[0], '%' . ($keysMap[$m[1]] + 1) . '$', $string);
        }

        array_unshift($values, $string);
        return call_user_func_array('sprintf', $values);
    }

    private static function sendSms($item)
    {
        return SendSmsService::sendSMSFromScript($item['send_mobile'], $item['send_text']);
    }

    private static function log($c, $h = '') {
        echo "<<<----------------------------------------\n";
        echo "$h\n";
        foreach ($c as $k => $v) {
            echo "$k= $v\n";
        }
        echo "\n>>>----------------------------------------\n";
    }

}