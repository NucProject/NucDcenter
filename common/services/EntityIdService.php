<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/23
 * Time: 21:17
 */

namespace common\services;


class EntityIdService
{
    /**
     * @param $centerId int It's unique
     * @param
     *
     * @return string
     * 生成设备唯一键值
     */
    public static function genDeviceKey($centerId, $deviceSn)
    {
        $deviceSn = strtolower($deviceSn);
        $line = "{$centerId}-{$deviceSn}";
        $key = strtolower(md5($line));
        return 'dk' . substr($key, 0, 18);
    }

    /**
     * @param $centerId int It's unique
     * @param
     * @return string
     * 生成自动站唯一键值
     * MD5(CenterId + Unix_time + Random1 + Random2)
     */
    public static function genStationKey($centerId)
    {
        $key = static::getRandomStr($centerId);
        return 'SK' . substr($key, 0, 18);
    }

    private static function getRandomStr($value)
    {
        $time = time();
        $rand1 = rand(100, 999);
        $rand2 = rand(100, 999);
        $line = "{$value}-{$time}-{$rand1}-{$rand2}";
        $result = strtolower(md5($line));
        return $result;
    }
}