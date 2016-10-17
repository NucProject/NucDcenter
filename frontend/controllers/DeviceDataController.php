<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/10/12
 * Time: 22:16
 */

namespace frontend\controllers;

use common\services\DeviceDataService;
use common\services\DeviceTypeService;
use yii;

class DeviceDataController extends BaseController
{
    public $enableCsrfValidation = false;

    /**
     *
     */
    public function actionLatest()
    {
        $deviceKeyList = Yii::$app->request->post('deviceKeyList');
        if (is_array($deviceKeyList))
        {
            $latest = [];
            foreach ($deviceKeyList as $deviceInfo)
            {
                $deviceKey = $deviceInfo['deviceKey'];
                $entry = DeviceDataService::lastEntry($deviceKey, false);
                if ($entry) {
                    $data = $entry->toArray();

                    $typeKey = $deviceInfo['typeKey'];
                    $fieldName = DeviceTypeService::getDisplayField($typeKey);


                    $latest[$deviceKey] = $data[$fieldName];
                }
            }
            return parent::result($latest);
        }
        return parent::error([], 1);
    }
}