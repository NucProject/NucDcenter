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
                    $field = DeviceTypeService::getDisplayField($typeKey);

                    $fieldName = $field->field_name;
                    $valueUnit = $field->field_unit;

                    $latest[$deviceKey] = $data[$fieldName] . $valueUnit;
                }
            }
            return parent::result($latest);
        }
        return parent::error([], 1);
    }
}