<?php
/**
 * Created by PhpStorm.
 * User: heale
 * Date: 2016/10/10
 * Time: 11:32
 */

namespace frontend\controllers;


use common\components\Helper;

class TaskImageController extends BaseController
{
    public $enableCsrfValidation = false;

    public function actionSave()
    {
        $lng = $_GET['lng'];
        $lat = $_GET['lat'];
        $zoom = 11;
        if (isset($_GET['zoom'])) {
            $zoom = $_GET['zoom'];
        }

        if ($lng && $lat)
        {
            $fileName = $_GET['file'];
            $width = isset($_GET['width']) ? $_GET['width'] : 400;
            $height = isset($_GET['height']) ? $_GET['height'] : 300;
            if (Helper::saveBaiduMapRectByPoint($fileName, $lng, $lat, $zoom, $width, $height))
            {
                return parent::result("d");
            }
        }
        return parent::error([], 1);
    }
}