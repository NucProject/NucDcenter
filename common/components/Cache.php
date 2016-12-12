<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/9/13
 * Time: 17:58
 */

namespace common\components;

use common\models\NucDeviceAlertSetting;
use yii;

class Cache
{

    /**
     * @param $instance
     * @return \Redis
     */
    public static function getRedis($instance=false)
    {
        return Yii::$app->redis;
    }

    /**
     * @param $key
     * @param bool|false $instance
     * @return bool|string
     */
    public static function getRedisValue($key, $instance=false)
    {
        return self::getRedis($instance)->get($key);
    }

    /**
     * @param $key
     * @param $value
     * @param int $timeout
     * @param bool|false $instance
     * @return bool
     */
    public static function setRedisValue($key, $value, $timeout=0, $instance=false)
    {
        return self::getRedis($instance)->set($key, $value, $timeout);
    }


    public static function pushDeviceData($deviceKey, $data)
    {
        $redis = self::getRedis();
        if ($redis)
        {
            $dataListKey = "List:$deviceKey";
            $redis->executeCommand('rpush', [$dataListKey, json_encode($data)]);
            $dataListCount = $redis->executeCommand('llen', [$dataListKey]);
            if ($dataListCount > 100)
            {
                $redis->executeCommand('lpop', [$dataListKey]);
            }
        }
    }

    public static function getLastDeviceData($deviceKey)
    {
        $redis = self::getRedis();
        if ($redis)
        {
            $dataListKey = "List:$deviceKey";
            $items =  $redis->executeCommand('lrange', [$dataListKey, -1, -1]);

            if (count($items) > 0)
            {
                return $items[0];
            }
        }
        return null;
    }

    public static function getDeviceAlertSettings($deviceKey)
    {
        $redis = self::getRedis();
        if ($redis)
        {
            $deviceAlertKey = "Alert:$deviceKey";
            $settingJson = $redis->executeCommand('get', [$deviceAlertKey]);
            if (!$settingJson)
            {
                $settings = NucDeviceAlertSetting::find()
                    ->where(['device_key' => $deviceKey])
                    ->asArray()
                    ->all();

                if ($settings)
                {
                    $redis->executeCommand('set', [$deviceAlertKey, json_encode($settings)]);
                }
                return $settings;
            }
            return json_decode($settingJson, true);
        }

        return false;
    }

    public static function delDeviceAlertSettings($deviceKey)
    {
        $redis = self::getRedis();
        if ($redis) {
            $deviceAlertKey = "Alert:$deviceKey";
            $redis->executeCommand('del', [$deviceAlertKey]);
            return true;
        }
        return false;
    }


}