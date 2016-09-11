<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/23
 * Time: 20:10
 */

namespace frontend\controllers;

use yii;
use common\components\AccessForbiddenException;
use common\models\NucDevice;
use common\models\NucDeviceField;
use common\models\NucDeviceType;
use common\services\DeviceDataService;
use common\services\DeviceService;
use common\models\UkDeviceData;
use common\services\DeviceTypeService;
use common\services\PagerService;

class DeviceController extends BaseController
{
    /**
     * @page
     * @comment 设备数据列表
     * @param $deviceKey
     * @return string
     * @throws AccessForbiddenException
     */
    public function actionDataList($deviceKey)
    {
        $device = $this->checkDevice($deviceKey);
        // Pager about
        $pageSize = Yii::$app->request->get('__pageSize', Yii::$app->params['pageSizeDefault']);
        $page = Yii::$app->request->get('__page');
        $options = ['pageSize' => $pageSize, 'page' => $page];
        // Get data list items
        $data = $this->getDeviceData($device, $options);


        parent::setBreadcrumbs(['index.html' => '设备', '#' => '数据']);
        return parent::renderPage('list.tpl', $data, [
            'with' => ['datePicker', 'laydate']]);
    }

    /**
     * @page
     * @comment 设备数据曲线
     * @param $deviceKey
     * @return string
     * @throws AccessForbiddenException
     */
    public function actionDataChart($deviceKey)
    {
        $device = $this->checkDevice($deviceKey);
        $options = [];

        $data['data'] = $this->getDeviceData($device, $options);

        parent::setBreadcrumbs(['index.html' => '设备', '#' => '曲线']);
        return parent::renderPage('chart.tpl', $data);
    }


    public function actionData($deviceKey)
    {
        $device = $this->checkDevice($deviceKey);


        // Pager about
        $pageSize = Yii::$app->request->get('__pageSize', Yii::$app->params['pageSizeDefault']);
        $page = Yii::$app->request->get('__page');
        $options = ['pageSize' => $pageSize, 'page' => $page];

        $data = $this->getDeviceData($device, $options);

        parent::setBreadcrumbs(['index.html' => '设备', '#' => '曲线']);
        return parent::renderPage('data.tpl', $data, ['with' => ['echarts', 'datePicker', 'laydate']]);
    }

    /**
     * @param $device \common\models\NucDevice
     * @param $options
     * @return array
     * @throws AccessForbiddenException
     */
    private function getDeviceData($device, $options)
    {
        if (!$device) {
            return [];
        }
        $typeKey = $device->type_key;

        $deviceType = DeviceTypeService::getDeviceType($typeKey);
        if (!$deviceType) {
            throw new AccessForbiddenException("设备类型不存在");
        }

        // 得到有效的设备字段信息
        $fields = NucDeviceField::findAll([
            'type_key' => $typeKey,
            'status' => 1
        ]);

        $columns = [['field_name' => 'data_time', 'field_display' => '时间']];
        foreach ($fields as $field)
        {
            $columns[] = $field->toArray();
        }

        $deviceKey = $device->device_key;

        $result = DeviceDataService::getDataList($deviceKey, $options);

        return [
            'deviceKey' => $deviceKey,
            'deviceName' => $deviceType->type_name,
            'columns' => $columns,
            'items' => $result['items'],
            'pager' => $result['pager'],
            'get' => self::filterRequestItems($_GET, [
                'begin_time' => '',
                'end_time' => '',
                '__page' => 1,
                '__pageSize' => $options['pageSize']
            ])
        ];
    }

    /**
     * @param $deviceKey
     * @return \common\models\NucDevice
     * @throws \common\components\AccessForbiddenException
     */
    private function checkDevice($deviceKey)
    {
        $device = DeviceService::getDeviceByKey($deviceKey);
        if (!$device) {
            throw new AccessForbiddenException("设备不存在");
        }
        return $device;
    }

    public static function filterRequestItems($get, $defaults)
    {
        $results = [];
        foreach ($defaults as $key => $value)
        {
            if (array_key_exists($key, $get)) {
                $results[$key] = $get[$key];
            } else {
                $results[$key] = $defaults[$key];
            }

        }
        return $results;
    }
}