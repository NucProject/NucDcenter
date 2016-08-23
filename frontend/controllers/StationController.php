<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/21
 * Time: 23:27
 */

namespace frontend\controllers;


use common\services\DeviceService;

class StationController extends BaseController
{

    /**
     * @param $stationKey
     * @return string
     * 列出来该Station的概况
     */
    public function actionIndex($stationKey)
    {
        $data['devices'] = $this->getDevices($stationKey);
        return parent::renderPage('index.tpl', $data);
    }

    /**
     * @param $stationKey
     * @return string
     * 得到该Station所有的设备
     */
    private function getDevices($stationKey)
    {
        return DeviceService::getDeviceList($stationKey);
    }
}