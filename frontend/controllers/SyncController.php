<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/8
 * Time: 15:49
 */

namespace frontend\controllers;

use common\components\AccessForbiddenException;
use yii;
use common\services\DataCenterService;
use common\services\DeviceTypeService;

class SyncController extends BaseController
{
    /**
     * @ajax
     * @comment
     */
    public function actionDeviceTypes()
    {
        if (!$this->checkDataCenterType(DataCenterService::CoreDataCenter)) {
            return parent::error([], -1);
        }
        $deviceTypes = DeviceTypeService::getDeviceTypeList();
        // TODO:
        return parent::result($deviceTypes);
    }

    /**
     * @ajax
     * @comment
     */
    public function actionFetchDeviceTypes()
    {
        if (!$this->checkDataCenterType()) {
            $reason = '�������������ĵ����� params[DataCenterType]';
            throw new AccessForbiddenException($reason);
        }

        $deviceTypes = DataCenterService::getCoreDataCenterDeviceTypes();
        if ($deviceTypes && is_array($deviceTypes))
        {
            DeviceTypeService::flushDeviceTypesToLocalDataCenter($deviceTypes);
        }

    }

    /**
     * @param $type
     * @return bool
     */
    private function checkDataCenterType($type)
    {
        return Yii::$app->params['DataCenterType'] == $type;
    }


}