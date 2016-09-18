<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/21
 * Time: 23:27
 */

namespace frontend\controllers;

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
     * @page [stationKey:string] [roleName:int]
     * @comment 自动站设备列表
     * @param $stationKey
     * @return string
     * 列出来该Station的概况
     */
    public function actionIndex($stationKey)
    {
        $this->checkStationKey($stationKey);

        $data['stationKey'] = $stationKey;
        $data['devices'] = $this->getDevices($stationKey);

        parent::setPageMessage("自动站和设备概况");
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
        $data['deviceTypes'] = DeviceTypeService::getDeviceTypeList();
        $data['doAddDevice'] = '/index.php?r=station/do-add-device';
        parent::setBreadcrumbs([
            'index.html' => '自动站',
            '#' => '添加新设备']);
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
        $stationKey = $_POST['stationKey'];
        $this->checkStationKey($stationKey);

        return $this->redirect("index.php?r=station&stationKey=$stationKey");
        $centerId = DataCenterService::deployedCenterId();
        // TODO: Check the $centerId is not root center

        // Generate device-key
        $deviceKey = EntityIdService::genDeviceKey($centerId);

        // 1. Device表里面插入一条数据
        $deviceId = DeviceService::addDevice($centerId, $stationKey, $deviceKey);
        if (!$deviceId)
        {
            return parent::error([], -1);
        }

        // 2. 新建device-data表
        $tableName = "uk_device_data_{$deviceKey}";

        if (DeviceDataService::isTableExists($tableName))
        {
            return parent::error([], -2);
        }

        DeviceDataService::createDeviceDataTable($tableName, $typeId);
        return parent::result([]);
    }

    /**
     * @param $stationKey
     * @return NucStation
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