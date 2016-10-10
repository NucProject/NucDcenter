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

    public static function makeUrl($node)
    {
        $controller = $node['controller'];
        $action = $node['action'];
        $params = '';
        if ($node['param0']) {
            $params = "&{$node['param0']}={$node['value0']}";
        }
        if ($node['param1']) {
            $params = "&{$node['param1']}={$node['value1']}";
        }
        return "$controller/$action" . $params;
    }

    /**
     * @param $time
     * @return bool|string
     * 得到30秒归一化时间
     */
    public static function regular30sTime($time)
    {
        $p = date_parse($time);
        $second = intval($p['second'] / 30) * 30;
        $t = mktime($p['hour'], $p['minute'], $second, $p['month'], $p['day'], $p['year']);
        return date("Y-m-d H:i:s", $t);
    }


    /**
     * @param $time
     * @return bool|string
     * 得到1分钟归一化时间
     */
    public static function regular1mTime($time)
    {
        $p = date_parse($time);
        $t = mktime($p['hour'], $p['minute'], 0, $p['month'], $p['day'], $p['year']);
        return date("Y-m-d H:i:00", $t);
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
     * @param $time
     * @param $type string (30s, 1min, 5min)
     * @return bool|string
     */
    public static function getRegularTime($time, $type) {
        if ($type == '1min') {
            return self::regular1mTime($time);
        } elseif ($type == '5min') {
            return self::regular5mTime($time);
        } elseif ($type == '30s') {
            return self::regular30sTime($time);
        }
        return $time;
    }

    /**
     * @param $fileName
     * @param $lng
     * @param $lat
     * @param $zoom
     * @param int $width
     * @param int $height
     * @return boolean|int
     */
    public static function saveBaiduMapRectByPoint($fileName, $lng, $lat, $zoom=11, $width=400, $height=400)
    {
        $ak = \Yii::$app->params['baiduMapAk'];
        $center = "{$lng},{$lat}";
        $api = "http://api.map.baidu.com/staticimage/v2?ak={$ak}&mcode=666666&center={$center}&width={$width}&height={$height}&zoom={$zoom}";

        $img = file_get_contents($api);
        if ($img)
        {
            $filePath = self::getFilePath($fileName);
            if (file_put_contents($filePath, $img))
            {
                return true;
            }
        }
        return false;
    }

    public static function getFilePath($fileName)
    {
        $filePath = Yii::getAlias('@frontend') . '/web/taskimg/' . $fileName;
        return $filePath;
    }
}