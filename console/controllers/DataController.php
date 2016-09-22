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

                $avgData['data_time'] = $dataTime;
                DeviceDataService::updateAvgEntry($deviceKey, $avgData);
            }

            $dataTime = date('Y-m-d H:i:s', strtotime($dataTime) + $duration);
            $counter++;
            if ($counter > 10)
            {
                break;
            }

        }
    }

    /**
     * 生成次日数据集合, 应该在当日晚8:00-10:00直接生成, 这样出现问题, 我还有可能去解决
     * @param $deviceKey
     * @param $date
     * @throws yii\db\Exception
     */
    public function prepareTomorrowAvgData($deviceKey, $date)
    {
        if (!$deviceKey) {
        }

        $tableName = '';
        $fields = 'data_id, alert_status, status, data_time, create_time, update_time';

        $begin = strtotime($date);
        $end = $begin + 3600 * 24;
        $time = $begin;
        $entries = [];
        while ($time <= $end)
        {
            $dataTime = date('Y-m-d H:i:s', $time);

            $time += 300;   // 每5分钟一个数值
            $entry = "(null, 0, 0, '$dataTime', '$dataTime', '$dataTime')";
            $entries[] = $entry;
        }

        $values = implode(',', $entries);
        $sql = "insert into {$tableName} ($fields) values {$values};";

        Yii::$app->db->createCommand($sql)->execute();

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

                // $this->flushAvgData($deviceKey, $dataTime, $avgData);
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