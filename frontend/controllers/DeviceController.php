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
use common\models\NucDeviceField;
use common\services\DeviceDataService;
use common\services\DeviceService;
use common\services\DeviceTypeService;

class DeviceController extends BaseController
{
    /**
     * @param $deviceKey
     * @return string
     * @throws AccessForbiddenException
     * 曲线+列表
     */
    public function actionData($deviceKey)
    {
        $device = $this->checkDevice($deviceKey);

        // options handler (including Pager)
        $pageSize = Yii::$app->request->get('__pageSize', Yii::$app->params['pageSizeDefault']);
        $page = Yii::$app->request->get('__page');
        $options = ['pageSize' => $pageSize, 'page' => $page];

        $data = $this->getDeviceData($device, $options);
        $this->handleShowOptions($data);

        if (!$data['hideChart'])
        {
            $points = self::convertItemsToPoints(array_reverse($data['items']), 'inner_doserate');
            $data['itemPoints'] = $points['points'];
            $data['maxVal'] = $points['maxVal'];
            $data['minVal'] = $points['minVal'];
            $data['chartTitle'] = 'XX设备五分钟曲线';
        }

        $deviceName = $data['deviceName'];
        parent::setPageMessage("{$deviceName} 数据曲线图表");
        parent::setBreadcrumbs(['index.html' => '设备', '#' => "{$deviceName}_数据"]);
        return parent::renderPage('data.tpl', $data, ['with' => ['echarts', 'datePicker', 'laydate']]);
    }


    /**
     * @param $deviceKey
     * @return string
     * @throws AccessForbiddenException
     * 曲线+列表
     */
    public function actionInfo($deviceKey)
    {
        $data = [];
        parent::setBreadcrumbs(['index.html' => '设备', '#' => '信息']);
        return parent::renderPage('info.tpl', $data, ['with' => ['echarts', 'datePicker', 'laydate']]);
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

        $items = $result['items'];

        return [
            'deviceKey' => $deviceKey,
            'deviceName' => $deviceType->type_name,
            'columns' => $columns,
            'items' => $items,
            'pager' => $result['pager'],
            'get' => self::filterRequestItems($_GET, [
                'begin_time' => '',
                'end_time' => '',
                '__page' => 1,
                '__pageSize' => $options['pageSize']
            ])
        ];
    }

    private function handleShowOptions(&$data)
    {
        $data['hideChart'] = Yii::$app->request->get('hideChart', 0);
        $data['hideList']  = Yii::$app->request->get('hideList', 0);
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

    /**
     * @param $data
     * @param $field  string  *要显示在charts上面的字段*
     * @return string
     * 曲线要考虑时间连续性，没有值的点，也要给null值
     */
    private static function convertItemsToPoints($data, $field)
    {
        $points = [];
        $first = self::getFirstNotNullValue($data, $field);
        $minVal = $maxVal = $first;
        foreach ($data as $i)
        {
            $dataTime = $i['data_time'];
            $val = $i[$field];
            $points[] = [$dataTime, $val];
            $maxVal = max($val, $maxVal);
            if ($val)
            {
                $minVal = min($val, $minVal);
            }
        }

        return [
            'points' => json_encode($points),
            'maxVal' => $maxVal ?: '0.0',
            'minVal' => $minVal ?: '0.0'
        ];
    }

    private static function getFirstNotNullValue($data, $field)
    {
        foreach ($data as $i) {
            $val = $i[$field];
            if ($val) {
                return $val;
            }
        }
        return null;
    }
}