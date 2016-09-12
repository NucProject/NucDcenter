<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/9/12
 * Time: 22:17
 */

namespace console\controllers;

use common\services\DeviceDataService;
use yii\console\Controller;

class DataController extends Controller
{
    public function actionAvg()
    {
        while (true)
        {
            $duration = 300;
            $dataTime = '2016-05-01';

            foreach ($this->getWorkingDevices() as $deviceKey)
            {
                $this->calcDataAvg($deviceKey, $dataTime, $duration);
            }
        }
    }

    public function actionTest()
    {
        $duration = 300;
        $dataTime = '2016-05-03 15:00:10';
        foreach ($this->getWorkingDevices() as $deviceKey)
        {
            $this->calcDataAvg($deviceKey, $dataTime, $duration);
        }
    }

    private function calcDataAvg($deviceKey, $dataTime, $duration)
    {
        $beginTime = date('Y-m-d H:i:s', strtotime($dataTime) - $duration);
        $items = DeviceDataService::itemsArray($deviceKey, $beginTime, $dataTime);

        var_dump($items);
    }

    private function getWorkingDevices()
    {
        return ['dk06ee3d6938e78ba9d3'];
    }
}