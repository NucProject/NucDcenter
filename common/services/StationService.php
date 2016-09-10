<?php

/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/19
 * Time: 19:33
 */
namespace common\services;

use common\components\ModelSaveFailedException;
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
        $stations = NucStation::find()
            ->where(['center_id' => $centerId])
            ->asArray()
            ->all();

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

    /**
     * @param $stationKey
     * @return NucStation
     */
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

    public static function addStation($centerId, $params)
    {
        $station = new NucStation();
        $station->center_id = $centerId;

        $centerId = DataCenterService::deployedCenterId();
        $station->station_key = EntityIdService::genStationKey($centerId);
        $station->setAttributes($params);
        if ($station->save())
        {
            return $station;
        }
        else
        {
            throw new ModelSaveFailedException($station->getErrors());
        }
    }

}