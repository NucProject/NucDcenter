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
}