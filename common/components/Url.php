<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/29
 * Time: 20:54
 */

namespace common\components;

use yii;

class Url
{
    public static function create($action, $args=[])
    {
        $params = [$action];
        $params = array_push($params, $args);
        return Yii::$app->urlManager->createUrl($params);
    }
}