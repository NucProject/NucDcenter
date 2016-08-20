<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/19
 * Time: 19:48
 */

namespace common\services;


class DeviceDataService
{
    /**
     *
     */
    public static function addEntry()
    {

    }


    public static function createTable($deviceId)
    {
        // TODO: Check $deviceType's device-data-table exists?
        if (self::isTableExists($deviceId)) {

            return false;
        }
        // TODO:
    }

    /**
     * @param $deviceId
     * @return bool
     */
    public static function isTableExists($deviceId)
    {

        return true;
    }
}