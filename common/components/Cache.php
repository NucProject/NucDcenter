<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/9/13
 * Time: 17:58
 */

namespace common\components;

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
}