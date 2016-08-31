<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/21
 * Time: 22:05
 */

namespace frontend\controllers;

use common\services\DataCenterService;
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
     * @page
     * @comment 数据中心首页
     * @return string
     * 列出数据中心($centerId)的首页
     * 列出简介, 所有的stations和所有的移动设备
     */
    public function actionIndex()
    {
        $centerId = DataCenterService::deployedCenterId();
        $data = [];


        return parent::renderPage('index.tpl', $data);
    }

    /**
     * @page
     * @comment 数据中心自动站列表页
     * @return string
     * 列出数据中心($centerId)所辖的自动站
     */
    public function actionStations()
    {
        $centerId = DataCenterService::deployedCenterId();
        $data = [];

        $data['stations'] = StationService::getStationList($centerId);

        parent::setBreadcrumbs(['index.html' => '自动站']);
        return parent::renderPage('stations.tpl', $data);
    }

    /**
     * @page
     * @comment 数据中心移动便携设备列表
     * @return string
     * 列出数据中心($centerId)所有的移动设备
     */
    public function actionMovableDevices()
    {
        $centerId = DataCenterService::deployedCenterId();

        $data = [];
        $data['movable_devices'] = StationService::getMovableDevicesList($centerId);

        parent::setBreadcrumbs(['index.html' => '移动式便携设备']);
        return parent::renderPage('movable-devices', $data);
    }

    /**
     * @page
     * @comment 数据中心添加自动站
     * @return string
     * 有新的自动站加入, 生成stationKey
     */
    public function actionAddStation()
    {
        $centerId = DataCenterService::deployedCenterId();
        $data['centerId'] = $centerId;

        // 我要在地图上找到它吗？

        parent::setBreadcrumbs(['index.html' => '自动站', '#' => '添加自动站']);
        return parent::renderPage('add-station.tpl', $data, ['with' => ['webUploader']]);
    }

    /**
     *
     */
    public function actionDoAddStation()
    {

        // $this->redirect();
    }


    /**
     * @page
     * @comment 数据中心添加新的便携设备
     * @return string
     * 有新的移动便携设备加入, 注册它, 生成deviceKey
     */
    public function actionAddMovableDevice()
    {
        $centerId = DataCenterService::deployedCenterId();
        $data['centerId'] = $centerId;

        parent::setBreadcrumbs(['index.html' => '自动站', '#' => '添加移动编写设备']);
        return parent::renderPage('add-station.tpl', $data, ['with' => ['webUploader']]);
    }

    /**
     *
     */
    public function actionDoAddMovableDevice()
    {

        // $this->redirect();
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