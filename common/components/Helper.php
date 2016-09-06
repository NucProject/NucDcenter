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
    public static function getPost($name, $options)
    {
        if (array_key_exists('default', $options)) {
            $value = Yii::$app->request->post($name, $options['default']);
        } else {
            $value = Yii::$app->request->post($name);
        }

        if (array_key_exists('required', $options)) {
            if (!$value) {
                file_put_contents("d:\\t.txt", $name . json_encode($options));
                throw new yii\base\InvalidParamException();
            }
        }

        if (array_key_exists('type', $options)) {
            $checker = $options['type'];
            file_put_contents("d:\\t2.txt", $name . "$checker($value)" .json_encode($options));
            if (!call_user_func_array($checker, [$value])) {
                file_put_contents("d:\\t.txt", $name . json_encode($options));
                throw new yii\base\InvalidParamException();
            }
        }
        return $value;
    }
}