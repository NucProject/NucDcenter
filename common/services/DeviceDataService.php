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

    /**
     * @param $deviceKey
     * @return string
     */
    public static function tableName($deviceKey)
    {
        return "nuc_device_data_{$deviceKey}";
    }

    public static function createTable($centerId, $deviceId)
    {
        // TODO: Check $deviceType's device-table exists?
        if (self::isTableExists($centerId, $deviceId)) {

            return false;
        }
        // TODO:
    }

    /**
     * @param $deviceId
     * @return bool
     */
    public static function isTableExists($centerId, $deviceId)
    {

        return true;
    }

    /**
     * @param $fileName
     * @param $columns
     * @param $params
     */
    public static function exportToFile($fileName, $columns, $params)
    {

    }
}