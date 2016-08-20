<?php

/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/19
 * Time: 19:33
 */
namespace common\services;

class StationService
{
    /**
     * @return array
     */
    public static function getStationIdArray()
    {
        $stationIdArray = [];

        return $stationIdArray;
    }

    /**
     * @oaram $stationId
     * @return array
     */
    public static function getDeviceList($stationId)
    {
        $deviceList = [];

        return $deviceList;
    }

    /**
     * @param $stationId
     * @param $deviceId
     * @return \common\models\NucDevice
     */
    public static function getDevice($stationId, $deviceId)
    {

    }
}