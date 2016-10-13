<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/10/12
 * Time: 22:16
 */

namespace frontend\controllers;

use common\services\DeviceDataService;
use yii;

class DeviceDataController extends BaseController
{
    public $enableCsrfValidation = false;

    /**
     *
     */
    public function actionLatest()
    {
        $idList = Yii::$app->request->post('idList');
        if (is_array($idList))
        {
            $latest = [];
            foreach ($idList as $deviceKey)
            {
                $entry = DeviceDataService::lastEntry($deviceKey, false);
                if ($entry) {
                    $data = $entry->toArray();
                    $latest[$deviceKey] = $data['inner_doserate'];
                }
            }
            return parent::result($latest);
        }
        return parent::error([], 1);
    }
}