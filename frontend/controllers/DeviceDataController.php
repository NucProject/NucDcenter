<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/19
 * Time: 19:56
 */

namespace frontend\controllers;

use yii;
use common\models\NucDataCenter;

class DeviceDataController extends BaseController
{

    public function actionIndex()
    {

        $data = NucDataCenter::find()->all();

        foreach ($data as $item) {
            var_dump($item->toArray());
        }
        return parent::renderPage('index.tpl');
    }
}