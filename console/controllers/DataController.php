<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/9/12
 * Time: 22:17
 */

namespace console\controllers;

use common\models\NucDevice;
use common\services\DeviceService;
use common\services\DeviceTypeService;
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
        $duration = 300;

        while (true)
        {
            $now = date('Y-m-d H:i:s');
            $dataTime = Helper::regular5mTime($now);
            if ($this->lastRegular5mTime == $dataTime) {
                // 如果当前时间的归一化时间未变, 则sleep 10s并且重新Loop
                sleep(10);
                continue;
            }

            /*
            foreach ($this->getWorkingDevices() as $deviceKey)
            {
                if ($this->isTimeToPrepareTomorrowAvgData($dataTime))
                {
                    $this->prepareTomorrowAvgData($deviceKey, $dataTime);
                }
            }
            */

            // 更新上一次的归一化时间
            $this->lastRegular5mTime = $dataTime;

            $this->calcDevicesAvg($dataTime, $duration);
        }
    }

    public function actionHistoryAvg($deviceKey, $begin, $end)
    {
        $duration = 300;

        $beginTime = strtotime(Helper::regular5mTime($begin));
        $endTime = strtotime(Helper::regular5mTime($end));
        $cursorTime = $beginTime;

        while ($cursorTime <= $endTime)
        {
            $dataTime = date('Y-m-d', $cursorTime);
            $this->prepareTomorrowAvgData($deviceKey, $dataTime);
            $cursorTime += 3600 * 24;
        }

        $cursorTime = $beginTime;
        $device = DeviceService::getDeviceByKey($deviceKey);

        $deviceType = DeviceTypeService::getDeviceType($device->type_key);
        $avgFields = [];
        foreach ($deviceType->fields as $field) {
            $avgFields[] = $field->field_name;
        }

        $otherFields = [];
        if ($device->is_movable)
        {
            $otherFields = ['lng', 'lat', 'lng_gps', 'lat_gps'];
        }

        echo  date('Y-m-d H:i:s', $cursorTime);
        echo  date('Y-m-d H:i:s', $endTime);
        while ($cursorTime <= $endTime)
        {
            $dataTime = date('Y-m-d H:i:s', $cursorTime);
            $this->calcDeviceAvg($deviceKey, $dataTime, $duration, $avgFields, $otherFields);

            $cursorTime += $duration;
        }
    }

    private function calcDevicesAvg($dataTime, $duration)
    {
        foreach ($this->getWorkingDevices() as $deviceKey)
        {
            list($avgFields, $otherFields) = $this->getFieldsInfo($deviceKey);
            $this->calcDeviceAvg($deviceKey, $dataTime, $duration, $avgFields, $otherFields);
        }
    }

    private function calcDeviceAvg($deviceKey, $dataTime, $duration, $avgFields, $otherFields)
    {
        $avgData = $this->calcDataAvg($deviceKey, $dataTime, $duration, $avgFields, $otherFields);

        //
        $avgData['data_time'] = $dataTime;
        DeviceDataService::updateAvgEntry($deviceKey, $avgData);
    }

    public function isTimeToPrepareTomorrowAvgData($time)
    {
        $dateTime = strtotime($time);
        $time = date('H:i:s', $dateTime);
        return $time >= '22:00:00' && $time < '22:30:00';
    }

    /**
     * 生成次日数据集合, 应该在当日晚8:00-10:00直接生成, 这样出现问题, 我还有可能去解决
     * @param $deviceKey
     * @param $date string 某一天的任意一刻
     * @return bool
     * @throws yii\db\Exception
     */
    public function prepareTomorrowAvgData($deviceKey, $date)
    {
        if (!$deviceKey) {
            return false;
        }

        $tableName = DeviceDataService::getTableName($deviceKey, true);

        $time = strtotime($date);
        $dateBegin = date('Y-m-d', $time);
        $begin = strtotime($dateBegin);
        $end = $begin + 3600 * 24;
        $dateBegin = date('Y-m-d', $begin);
        $dateEnd = date('Y-m-d', $end);

        $counter = "select count(*) count from {$tableName} where data_time> '{$dateBegin}' and data_time<= '{$dateEnd}'";
        $result = Yii::$app->db->createCommand($counter)->queryOne();
        $count = $result['count'];
        if ($count == 288) {
            // 已经存在了
            return false;
        } elseif ($count >= 0 && $count < 288) {
            // 不完整, 重新建立
            $deleteSql = "delete from {$tableName} where data_time> '{$dateBegin}' and data_time<= '{$dateEnd}'";
            Yii::$app->db->createCommand($deleteSql)->execute();
        }


        // 凌晨00:00:00不算, 第一个是00:05:00
        $time = $begin + 300;
        $entries = [];
        while ($time <= $end)
        {
            $dataTime = date('Y-m-d H:i:s', $time);

            $time += 300;   // 每5分钟一个数值
            $entry = "(null, 0, 0, '$dataTime', '$dataTime', '$dataTime')";
            $entries[] = $entry;
        }

        $fields = 'data_id, alarm_status, status, data_time, create_time, update_time';
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
     * @param $avgFields
     * @param $otherFields
     * @return array|\common\models\NucDataCenter|null
     */
    private function calcDataAvg($deviceKey, $dataTime, $duration, $avgFields, $otherFields)
    {
        $beginTime = date('Y-m-d H:i:s', strtotime($dataTime) - $duration);
        $items = DeviceDataService::itemsArray($deviceKey, $beginTime, $dataTime, $avgFields, $otherFields);

        return $items;

    }

    /**
     * @return array
     */
    private function getWorkingDevices()
    {
        // TODO: Get working device keys from Redis
        return ['dk413d9bf25138b40337'];
    }

    private function getDeviceKeysInTask()
    {
        return ['dk06ee3d6938e78ba9d3'];
    }

    static $fieldsInfoMap = [];

    /**
     * @param $deviceKey
     * @return array
     */
    private function getFieldsInfo($deviceKey)
    {
        if (array_key_exists($deviceKey, self::$fieldsInfoMap)) {
            return self::$fieldsInfoMap[$deviceKey];
        }

        $avgFields = [];
        $device = DeviceService::getDeviceByKey($deviceKey);
        if ($device) {
            $deviceType = DeviceTypeService::getDeviceType($device->type_key);
            foreach ($deviceType->fields as $field) {
                $avgFields[] = $field->field_name;
            }
        }

        $fieldsInfo = [$avgFields, ['']];
        self::$fieldsInfoMap[$deviceKey] = $fieldsInfo;
        return $fieldsInfo;
    }

    public function actionTaskReplay($taskId, $deviceKey)
    {
        $deviceDataItems = DeviceDataService::getTaskData($deviceKey, $taskId);
        var_dump(count($deviceDataItems));
        $b = false;
        $ps = [0];
        foreach ($deviceDataItems as $a)
        {
            if (!$b) {
                $b = $a;
                continue;
            }

            $p = pow(($a['lng'] - $b['lng']), 2) + pow(($a['lat'] - $b['lat']), 2) * 10000;
            $ps[] = $p;

        }

        $avg = self::avg($ps);

        $index = 0;
        $dist = 0;
        $points = [];
        $section = [];
        $counter = 0;
        foreach ($deviceDataItems as $i)
        {
            $section[] = $i;


            $dist += $ps[$index];

            if ($dist >= $avg)
            {
                // $counter += count($section);

                $points = array_merge($points, self::leverage($section));

                // $pointCount = count($points);
                // echo "$counter == $pointCount\n";

                $dist = 0;
                $section = [];
            }

            $index++;

        }
        $points = array_merge($points, self::leverage($section));

        var_dump(count($points));


    }

    private static function leverage($section)
    {
        foreach ($section as &$i)
        {
            $i['inner_doserate'] = $i['inner_doserate'] / count($section);
        }
        return $section;
    }

    private static function avg($p)
    {
        $sum = 0;
        foreach ($p as $i)
        {
            $sum += $i;
        }
        return $sum / count($p);
    }
}