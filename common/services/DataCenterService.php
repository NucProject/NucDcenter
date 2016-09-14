<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/21
 * Time: 20:27
 */

namespace common\services;

use common\components\AccessForbiddenException;
use common\models\NucDataCenter;
use yii;

class DataCenterService
{
    const CoreDataCenter = 1;

    const DistributedDataCenter = 2;

    const DevDataCenter = 3;

    /**
     * @return mixed
     * @throws AccessForbiddenException
     * 返回当前数据中心的(全局唯一)Id, 没有配置则抛异常.
     */
    public static function deployedCenterId() {
        if (isset (Yii::$app->params['theDeployedCenterId']))
        {
            return Yii::$app->params['theDeployedCenterId'];
        }

        throw new AccessForbiddenException('未正确设置数据中心ID');
    }

    /**
     * @return string
     */
    public static function defaultPageTitle() {
        if (isset (Yii::$app->params['defaultPageTitle']))
        {
            return Yii::$app->params['defaultPageTitle'];
        }
        return '数据中心 v0.1';
    }


    /**
     * TODO: Get data from network
     * @return array[]
     */
    public static function getCoreDataCenterDeviceTypes()
    {
        // TODO: file_get_contents()

        // TODO: json_decode
        return [];
    }

    public static function getDataCenter($dataCenterId=false)
    {
        return NucDataCenter::findOne($dataCenterId);
    }
}