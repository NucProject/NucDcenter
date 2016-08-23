<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/19
 * Time: 19:47
 */

namespace common\services;


use common\models\NucDevice;

class DeviceService
{


    /**
     * @param $deviceId
     * @return \common\models\NucDevice
     */
    public static function getDeviceById($deviceId)
    {

    }

    /**
     * @param $stationId int ()
     * @param $typeId int ()
     * @return int $deviceId
     */
    public static function addDevice($stationId, $typeId)
    {
        $deviceId = 0;


        // TODO: create deviceData table for $deviceId
        return $deviceId;
    }

    /**
     * @oaram $stationKey
     * @return array
     */
    public static function getDeviceList($stationKey)
    {
        $deviceList = [];

        $devices = NucDevice::findAll(['station_key' => $stationKey]);

        return $devices;
    }


}