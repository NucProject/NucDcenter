<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/21
 * Time: 22:05
 */

namespace frontend\controllers;

/**
 * Class DataCenterController
 * @package frontend\controllers
 * 数据中心相关
 */
class DataCenterController extends BaseController
{

    /**
     * @param $centerId
     * @return string
     * 列出数据中心($centerId)的首页
     */
    public function actionIndex($centerId)
    {
        $data = [];
        return parent::renderPage('index.tpl', $data);
    }

    /**
     * @param $centerId
     * @return string
     * 列出数据中心($centerId)所辖的自动站
     */
    public function actionStations($centerId)
    {
        $data = [];

        return parent::renderPage('stations.tpl', $data);
    }

    /**
     * @param $centerId
     * @return string
     * 列出数据中心($centerId)所有的移动设备
     */
    public function actionMovableDevices($centerId)
    {
        $data = [];
        return parent::renderPage('movable-devices', $data);
    }


    private function getStationList($centerId)
    {
        $stationList = [];

        return $stationList;
    }

    private function getMovableDeviceList($centerId)
    {
        $movableDeviceList = [];

        return $movableDeviceList;
    }
}