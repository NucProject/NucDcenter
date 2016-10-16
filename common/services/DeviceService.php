<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/19
 * Time: 19:47
 */

namespace common\services;


use common\components\ModelSaveFailedException;
use common\models\NucDevice;

class DeviceService
{


    /**
     * @param $deviceKey
     * @return \common\models\NucDevice
     */
    public static function getDeviceByKey($deviceKey)
    {
        $device = NucDevice::findOne(['device_key' => $deviceKey]);
        return $device;
    }


    /**
     * @param $centerId
     * @param $typeKey
     * @param $params
     * @param $stationKey
     * @return \common\models\NucDevice
     * @throws
     */
    public static function addDevice($centerId, $typeKey, $params, $stationKey='')
    {
        $deviceSn = $params['device_sn'];
        $deviceKey = EntityIdService::genDeviceKey($centerId, $deviceSn);

        $device = new NucDevice();
        $device->setAttributes($params);
        $device->center_id = $centerId;
        $device->station_key = $stationKey;
        $device->type_key = $typeKey;
        $device->device_key = $deviceKey;

        if ($device->save())
        {
            return $device;
        }
        else
        {
            // file_put_contents("d:\\a.y", json_encode($device->getErrors()));
            throw new ModelSaveFailedException($device->getErrors());
        }
    }

    /**
     * @param $stationKey
     * @return array
     */
    public static function getDeviceList($stationKey)
    {
        $devices = NucDevice::find()
            ->with('deviceType')
            ->asArray()
            ->where(['station_key' => $stationKey])
            ->all();

        foreach ($devices as &$device)
        {
            $device['last_data_time'] = '';
            if ($device['device_status'] == 1)
            {
                $entry = DeviceDataService::lastEntry($device['device_key'], false);
                $device['last_data_time'] = $entry['data_time'];
            }
        }
        return $devices;
    }


}