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
                $data = DeviceDataService::lastEntry($deviceKey, false);
                if ($data) {
                    $typeKey = $deviceInfo['typeKey'];
                    $field = DeviceTypeService::getDisplayField($typeKey);

                    // file_put_contents("d:\\$deviceKey.txt", json_encode($data), FILE_APPEND);

                    $fieldName = $field->field_name;
                    $valueUnit = $field->field_unit;

                    $value = $data[$fieldName];

                    $latest[$deviceKey] = [
                        'time' => $data['data_time'],
                        'data' => $value . $valueUnit];
                }
            }
            return parent::result($latest);
        }
        return parent::error([], 1);
    }
}