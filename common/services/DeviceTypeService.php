<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/19
 * Time: 19:47
 */

namespace common\services;


use common\models\NucDeviceType;

class DeviceTypeService
{

    public static function createDeviceType($name, $displayName, $params)
    {

    }

    public static function getDeviceTypeList()
    {
        return NucDeviceType::findAll(['status' => 1]);
    }

    public static function syncDeviceTypes()
    {

    }

    private static function loadDeviceTypesFromRootDataCenter()
    {
        $deviceTypes = [];

        return $deviceTypes;
    }

    private static function flushDeviceTypesToLocalDataCenter($deviceTypes)
    {

    }
}