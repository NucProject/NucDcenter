<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/21
 * Time: 22:05
 */

namespace frontend\controllers;

use common\components\Helper;
use common\services\DataCenterService;
use common\services\DeviceDataService;
use common\services\DeviceService;
use common\services\DeviceTypeService;
use common\services\EntityIdService;
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
     * @comment 数据中心首页2
     * @return string
     * 列出数据中心($centerId)的首页
     * 列出简介, 所有的stations和所有的移动设备
     */
    public function actionIndex()
    {
        // TODO: 以后可能不跳转首页了
        $this->redirect(array('site/index'));
    }

    /**
     * @page
     * @comment 数据中心自动站列表
     * @return string
     * 列出数据中心($centerId)所辖的自动站
     */
    public function actionStations()
    {
        $centerId = DataCenterService::deployedCenterId();
        $data = [];

        $data['stations'] = StationService::getStationList($centerId);

        parent::setPageMessage("自动站列表");
        parent::setBreadcrumbs(['#' => '自动站']);
        return parent::renderPage('index.tpl', $data);
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
        $data['devices'] = DataCenterService::getMovableDevicesList($centerId);
        // stationKey is Empty for movable-devices
        $data['stationKey'] = '';

        $flashes = Yii::$app->session->getAllFlashes(true);
        $data['flashes'] = $flashes;

        parent::setPageMessage("移动设备列表");
        parent::setBreadcrumbs(['index.html' => '移动式便携设备']);
        return parent::renderPage('movable-devices.tpl', $data);
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


        parent::setBreadcrumbs(['/index.php?r=data-center/stations' => '自动站', '#' => '添加自动站']);
        return parent::renderPage('add-station.tpl', $data, ['with' => ['webUploader', 'dialog', 'baiduMap']]);
    }

    /**
     * @ajax
     */
    public function actionDoAddStation()
    {
        $centerId = DataCenterService::deployedCenterId();

        $params = [
            'station_name'    => Helper::getPost('stationName', ['required' => true]),
            'station_desc'    => Helper::getPost('stationDesc', ['default' => '']),
            'station_pic'     => Helper::getPost('stationPic', ['default' => '']),
            'station_type'    => Helper::getPost('stationType', ['default' => 0, 'type' => 'is_numeric']),
            'station_addr'    => Helper::getPost('stationAddress', ['default' => '']),
            'owner_lead'      => Helper::getPost('ownerLead', ['default' => '']),
            'owner_org'       => Helper::getPost('ownerOrg', ['default' => '']),
            'builder_org'     => Helper::getPost('builderOrg', ['default' => '']),
            'ops_org'         => Helper::getPost('opsOrg', ['default' => '']),
            'completion_date' => Helper::getPost('completionDate', ['default' => '0000-00-00 00:00:00']),
            'lng'             => Helper::getPost('lng', ['default' => '0.0', 'type' => 'is_numeric']),
            'lat'             => Helper::getPost('lat', ['default' => '0.0', 'type' => 'is_numeric']),
        ];

        if (StationService::addStation($centerId, $params)) {
            Yii::$app->session->setFlash('add-station', 'success');
            Yii::$app->response->redirect('index.php?r=data-center/stations');
        }
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
        $data['stationKey'] = '';
        $data['stationName'] = '';
        $data['deviceKey'] = EntityIdService::genDeviceKey($centerId);
        $data['deviceTypes'] = DeviceTypeService::getDeviceTypeList(['is_movable' => 1]);
        $data['doAddDevice'] = 'index.php?r=data-center/do-add-device';

        parent::setPageMessage('添加移动便携设备');
        parent::setBreadcrumbs(['#' => '添加移动便携设备']);
        return parent::renderPage('add-device.tpl', $data,
            ['with' => ['dialog', 'laydate']]);
    }

    /**
     * POST -> redirect
     * @return bool
     *
     */
    public function actionDoAddDevice()
    {
        $centerId = DataCenterService::deployedCenterId();
        // TODO: Check the $centerId is not root center

        $typeKey = Helper::getPost('typeKey', ['required' => true]);

        $deviceType = DeviceTypeService::getDeviceType($typeKey);

        $params = [
            'device_sn'         => Helper::getPost('device_sn', []),
            'type_name'         => $deviceType->type_name,
            'is_movable'        => $deviceType->is_movable,
            'launch_date'       => Helper::getPost('launch_date', []),
            'rescale_date'      => Helper::getPost('rescale_date', []),
        ];

        // 1. Device表里面插入一条数据
        $device = DeviceService::addDevice($centerId, $typeKey, $params);
        if (!$device)
        {
            return parent::error([], -1);
        }

        $result = DeviceDataService::createDeviceDataTables($device->device_key, $typeKey);
        if ($result)
        {
            Yii::$app->session->setFlash("add-device-success", "添加设备成功");
            $this->redirect(array('data-center/movable-devices'));
        }
        else
        {

        }
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