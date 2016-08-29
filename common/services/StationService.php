<?php

/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/19
 * Time: 19:33
 */
namespace common\services;

use common\models\NucStation;

class StationService
{
    /**
     * @param $centerId
     * @return array
     * 根据$centerId获得它所管理的自动站列表
     */
    public static function getStationList($centerId)
    {
        $stations = NucStation::findAll(['center_id' => $centerId]);

        return $stations;
    }

    /**
     * @return array
     */
    public static function getStationIdArray($centerId)
    {
        $stationIdArray = [];

        return $stationIdArray;
    }


    public static function getStationByKey($stationKey)
    {
        return NucStation::findOne(['station_key' => $stationKey]);
    }

    /**
     * @param $centerId
     * @return array
     * 根据$centerId获得它所管理的移动设备列表
     */
    public static function getMovableDevicesList($centerId)
    {

    }

}