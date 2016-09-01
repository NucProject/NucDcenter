<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/23
 * Time: 23:08
 */

namespace console\controllers;

use yii\console\Controller;
use common\services\EntityIdService;
use yii\helpers\BaseInflector;

class GenKeyController extends Controller
{
    public function actionStation()
    {
        echo EntityIdService::genStationKey(129);
    }


}