<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/9/26
 * Time: 11:20
 */

namespace console\controllers;

use yii;
use yii\console\Controller;

/**
 * Class SimController
 * @package console\controllers
 * 数据发送模拟器
 */
class SimController extends Controller
{
    private $remoteUrl = 'http://127.0.0.1:1001/index.php?r=';



    /**
     * @param $deviceType
     * @param int $interval
     * @param int $speed
     */
    public function actionSend($deviceType, $interval, $speed=1)
    {
        $this->loopWithSleep($deviceType, $interval, $speed);
    }

    private function loopWithSleep($deviceType, $interval, $speed)
    {
        $deviceTypeUpper = ucwords($deviceType);
        $sendMethod = "send{$deviceTypeUpper}Data";
        while (true)
        {
            $this->$sendMethod();
            sleep($interval / $speed);
        }
    }

    private function sendNew131Data()
    {
        $r1 = rand(-10, 10);
        $data = [
            'deviceKey' => 'dk96db3d6938e74659da',
            'data_time' => '2016-09-01 08:00:00',
            'data' => [
                'doserate' => round(123.5 + $r1, 2),
                'battery' => '5.0',
                'temperature' => '23.4'
            ]

        ];
        $this->sendData('send/mobile-data', $data);
    }

    private function sendFh40gData()
    {
        while (true)
        {
            $data = [];
            $this->sendData('send/mobile-data', $data);
        }
    }

    private function sendData($action, $data)
    {
        $sendUrl = $this->remoteUrl . $action;
        $this->doCurlPost($sendUrl, json_encode($data));
    }

    /**
     * Curl版本
     * 使用方法：
     * $post_string = "app=request&version=beta";
     * @param $remoteServer
     * @param $postData
     * @return string
     */
    private function doCurlPost($remoteServer, $postData)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remoteServer);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "Huawei P9 Client");
        $data = curl_exec($ch);
        curl_close($ch);

        echo $data . "\n";
        return $data;
    }
}