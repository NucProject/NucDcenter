<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/19
 * Time: 19:56
 */

namespace frontend\controllers;

use yii;


class DeviceDataController extends BaseController
{

    public function actionList($deviceId)
    {

        return parent::renderPage('list.tpl');
    }

    public function actionCharts($deviceId)
    {

        return parent::renderPage('charts.tpl');
    }
}