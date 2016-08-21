<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/21
 * Time: 20:27
 */

namespace common\services;

use yii;

class DataCenterService
{
    public static function deployedCenterId() {
        if (isset (Yii::$app->params['theDeployedCenterId']))
        {
            return Yii::$app->params['theDeployedCenterId'];
        }
        assert(FALSE);
        return 0;
    }

    public static function defaultPageTitle() {
        if (isset (Yii::$app->params['defaultPageTitle']))
        {
            return Yii::$app->params['defaultPageTitle'];
        }
        return '数据中心 v0.1';
    }
}