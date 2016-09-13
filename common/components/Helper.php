<?php
/**
 * NucDcenter
 * User: healer_kx@163.com
 * DateTime: 2016/9/6 18:34
 *
 */

namespace common\components;

use yii;

class Helper
{
    private static function getRequestValue($name, $defaultValue)
    {
        $value = Yii::$app->request->post($name);
        return $value ?: $defaultValue;
    }

    public static function getPost($name, $options)
    {
        if (array_key_exists('default', $options)) {
            $value = self::getRequestValue($name, $options['default']);
        } else {
            $value = Yii::$app->request->post($name);
        }

        if (array_key_exists('required', $options)) {
            if (!$value) {
                $reason = "Param $name is required";
                throw new BadArgumentException($reason);
            }
        }

        if (array_key_exists('type', $options)) {
            $checker = $options['type'];
            if (!call_user_func_array($checker, [$value])) {
                $reason = "$checker($name=$value) returns false";
                throw new BadArgumentException($reason);
            }
        }
        return $value;
    }

    /**
     * @param $time
     * @return bool|string
     * 得到5分钟归一化时间
     */
    public static function regular5mTime($time)
    {
        $p = date_parse($time);
        $m = intval($p['minute'] / 5) * 5;
        $t = mktime($p['hour'], $m, 0, $p['month'], $p['day'], $p['year']);

        return date("Y-m-d H:i:00", $t);
    }

    /**
     * @param $fileName
     * @param $lng
     * @param $lat
     * @param int $width
     * @param int $height
     * @return boolean|int
     */
    public static function saveBaiduMapRectByPoint($fileName, $lng, $lat, $width=400, $height=400)
    {
        $ak = \Yii::$app->params['baidu_map_ak'];
        $center = "{$lng},{$lat}";
        $api = "http://api.map.baidu.com/staticimage/v2?ak={$ak}&mcode=666666&center={$center}&width={$width}&height={$height}&zoom=11";

        $img = file_get_contents($api);
        if ($img)
        {
            return file_put_contents($fileName, $img);
        }
        return false;
    }
}