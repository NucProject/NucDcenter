<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/21
 * Time: 22:05
 */

namespace frontend\controllers;

use common\services\StationService;
use yii;
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

        $data['stations'] = StationService::getStationList($centerId);

        parent::setBreadcrumbs(['index.html' => '自动站']);
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
        $data['movable_devices'] = StationService::getMovableDevicesList($centerId);

        parent::setBreadcrumbs(['index.html' => '移动式便携设备']);
        return parent::renderPage('movable-devices', $data);
    }

    /**
     * @param $centerId
     * @return string
     * 有新的自动站加入, 生成stationKey
     */
    public function actionAddStation($centerId)
    {
        $data['centerId'] = $centerId;

        // 我要在地图上找到它吗？

        return parent::renderPage('add-station', $data);
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