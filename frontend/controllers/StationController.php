<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/21
 * Time: 23:27
 */

namespace frontend\controllers;

use common\services\DataCenterService;
use common\services\DeviceDataService;
use common\services\DeviceService;
use common\services\EntityIdService;

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

        parent::setBreadcrumbs([
            'index.html' => '自动站',
            'index2.html' => '设备列表',
        ]);
        return parent::renderPage('index.tpl', $data);
    }

    /**
     * @param $stationKey
     * @return string
     * 需要生成deviceKey
     */
    public function actionAddDevice($stationKey)
    {
        $data['stationKey'] = $stationKey;
        return parent::renderPage('add-device.tpl', $data);
    }

    public function actionDoAddDevice($stationKey, $typeId)
    {
        $centerId = DataCenterService::deployedCenterId();
        // TODO: Check the $centerId is not root center

        // TODO: Gen device-key
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
     * @return string
     * 得到该Station所有的设备
     */
    private function getDevices($stationKey)
    {
        return DeviceService::getDeviceList($stationKey);
    }
}