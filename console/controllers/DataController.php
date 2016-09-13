<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/9/12
 * Time: 22:17
 */

namespace console\controllers;

use common\components\Helper;
use common\services\DeviceDataService;
use yii\console\Controller;

class DataController extends Controller
{
    public function actionAvg()
    {
        $counter = 0;
        $dataTime = Helper::regular5mTime('2016-05-03 13:09:52');

        while (true)
        {
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
         print_r($avgData);
        DeviceDataService::addAvgEntry($deviceKey, $avgData);
    }

    private function getWorkingDevices()
    {
        return ['dk06ee3d6938e78ba9d3'];
    }
}