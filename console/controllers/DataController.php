<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/9/12
 * Time: 22:17
 */

namespace console\controllers;

use yii;
use common\components\Helper;
use common\services\DeviceDataService;
use yii\console\Controller;

class DataController extends Controller
{
    private $lastRegular1mTime = false;

    private $lastRegular5mTime = false;

    /**
     * For common device calc 5 min avg values.
     */
    public function actionRealTimeAvg()
    {
        $counter = 0;


        while (true)
        {
            $now = date('Y-m-d H:i:s');
            $dataTime = Helper::regular5mTime($now);
            if ($this->lastRegular5mTime == $dataTime) {
                // 如果当前时间的归一化时间未变, 则sleep 10s并且重新Loop
                sleep(10);
                continue;
            }

            // 更新上一次的归一化时间
            $this->lastRegular5mTime = $dataTime;

            $duration = 300;

            foreach ($this->getWorkingDevices() as $deviceKey)
            {
                $avgData = $this->calcDataAvg($deviceKey, $dataTime, $duration);

                $this->flushAvgData($deviceKey, $dataTime, $avgData);
            }

            $dataTime = date('Y-m-d H:i:s', strtotime($dataTime) + $duration);
            $counter++;
            if ($counter > 10)
            {
                break;
            }

        }
    }

    public function prepareAvgData($deviceKey)
    {
        $entry = DeviceDataService::lastEntry($deviceKey);
        if ($entry)
        {
            $dataTime = strtotime($entry->data_time);
            while (true)
            {

            }
        }
    }

    /**
     * 实时数据进行每分钟的均值处理
     */
    public function actionEveryMinutesAvg()
    {
        $counter = 0;
        while (true)
        {
            $now = date('Y-m-d H:i:s');
            $dataTime = Helper::getRegularTime($now, '1min');
            if ($this->lastRegular1mTime == $dataTime) {
                // 如果当前时间的归一化时间未变, 则sleep 2s并且重新尝试是否变化
                sleep(2);
                continue;
            }

            // 更新上一次的归一化时间
            $this->lastRegular1mTime = $dataTime;

            $duration = 60; // 1min

            // 获取每一个在任务中的设备( 如果没有参与任务则不会select它的数据表 )
            $deviceKeys = $this->getDeviceKeysInTask();
            foreach ($deviceKeys as $deviceKey)
            {
                $avgData = $this->calcDataAvg($deviceKey, $dataTime, $duration);

                $this->flushAvgData($deviceKey, $dataTime, $avgData);
            }

            $dataTime = date('Y-m-d H:i:s', strtotime($dataTime) + $duration);
            $counter++;
            if ($counter > 1000)
            {
                break;
            }

        }
    }

    /**
     * @param $deviceKey
     * @param $dataTime
     * @param $duration
     * @return array
     */
    private function calcDataAvg($deviceKey, $dataTime, $duration)
    {
        $beginTime = date('Y-m-d H:i:s', strtotime($dataTime) - $duration);
        $items = DeviceDataService::itemsArray($deviceKey, $beginTime, $dataTime);

        return $items;

    }

    private function flushAvgData($deviceKey, $dataTime, $avgData)
    {
        $avgData['data_time'] = $dataTime;
        $avgData['task_id'] = 6;
        // print_r($avgData);
        DeviceDataService::addAvgEntry($deviceKey, $avgData);
    }

    /**
     * @return array
     */
    private function getWorkingDevices()
    {
        // TODO: Get working device keys from Redis
        return ['dk06ee3d6938e78ba9d3'];
    }

    private function getDeviceKeysInTask()
    {
        return ['dk06ee3d6938e78ba9d3'];
    }
}