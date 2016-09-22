<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/21
 * Time: 23:27
 */

namespace frontend\controllers;

use yii;
use common\components\Helper;
use common\components\AccessForbiddenException;
use common\services\DataCenterService;
use common\services\DeviceDataService;
use common\services\DeviceService;
use common\services\DeviceTypeService;
use common\services\EntityIdService;
use common\services\StationService;

class StationController extends BaseController
{

    /**
     * @page [stationKey:string]
     * @comment 自动站设备列表
     * @param $stationKey
     * @return string
     * 列出来该Station的概况
     */
    public function actionIndex($stationKey)
    {
        $station = $this->checkStationKey($stationKey);

        $data['stationKey'] = $stationKey;
        $data['devices'] = $this->getDevices($stationKey);

        parent::setPageMessage("{$station->station_name} 详情和设备概况");
        parent::setBreadcrumbs([
            'index.html' => '自动站',
            '#' => '设备列表',
        ]);
        return parent::renderPage('index.tpl', $data);
    }

    /**
     * @page
     * @comment 自动站添加新设备
     * @param $stationKey
     * @return string
     * 需要生成deviceKey
     */
    public function actionAddDevice($stationKey)
    {
        $station = $this->checkStationKey($stationKey);

        $centerId = DataCenterService::deployedCenterId();
        $data['centerId'] = $centerId;
        $data['stationKey'] = $stationKey;
        $data['stationName'] = $station->station_name;
        $data['deviceKey'] = EntityIdService::genDeviceKey($centerId);
        // 全部设备, 也允许出现移动设备
        $data['deviceTypes'] = DeviceTypeService::getDeviceTypeList();
        $data['doAddDevice'] = '/index.php?r=station/do-add-device';

        parent::setPageMessage("为 {$station->station_name} 添加设备");
        parent::setBreadcrumbs([
            'index.html' => '自动站',
            '#' => '添加新设备']);
        return parent::renderPage('add-device.tpl', $data,
            ['with' => ['dialog', 'laydate']]);
    }

    /**
     * @ajax
     * @comment
     * @return bool
     *
     */
    public function actionDoAddDevice()
    {
        $stationKey = $_POST['stationKey'];
        $this->checkStationKey($stationKey);

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
        $device = DeviceService::addDevice($centerId, $typeKey, $params, $stationKey);
        if (!$device)
        {
            return parent::error([], -1);
        }

        $result = DeviceDataService::createDeviceDataTables($device->device_key, $typeKey);
        if ($result)
        {
            Yii::$app->session->setFlash("add-device-success", "添加设备成功");
            $this->redirect(array('station/index', 'stationKey' => $stationKey));
        }
        else
        {
            Yii::$app->session->setFlash("add-device-success", "添加设备失败");
            $this->redirect(array('station/add-device', 'stationKey' => $stationKey));
        }
    }

    /**
     * @param $stationKey
     * @return \common\models\NucStation
     * @throws AccessForbiddenException
     */
    private function checkStationKey($stationKey)
    {
        if (!$stationKey) {
            throw new AccessForbiddenException('请提供自动站的StationKey');
        }

        $station = StationService::getStationByKey($stationKey);
        if (!$station) {
            throw new AccessForbiddenException('未知的自动站StationKey=' . $stationKey);
        }
        return $station;
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