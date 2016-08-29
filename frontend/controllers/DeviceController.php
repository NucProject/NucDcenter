<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/23
 * Time: 20:10
 */

namespace frontend\controllers;


use common\models\NucDevice;
use common\models\NucDeviceField;
use common\services\DeviceService;
use common\models\UkDeviceData;

class DeviceController extends BaseController
{

    public function actionDataList($deviceKey)
    {
        $data['data'] = $this->getDeviceData($deviceKey);
        parent::setBreadcrumbs(['index.html' => '设备', '#' => '数据']);
        return parent::renderPage('list.tpl', $data, ['withDatePicker']);
    }

    public function actionDataChart($deviceKey)
    {
        $data['data'] = $this->getDeviceData($deviceKey);
        parent::setBreadcrumbs(['index.html' => '设备', '#' => '曲线']);
        return parent::renderPage('chart.tpl', $data);
    }

    /**
     * @param $deviceKey
     * @return array
     */
    private function getDeviceData($deviceKey)
    {
        $device = DeviceService::getDeviceByKey($deviceKey);
        if ($device)
        {
            $typeKey = $device->type_key;
            $fields = NucDeviceField::findAll([
                'type_key' => $typeKey,
                'status' => 1
            ]);

            $columns = [['field_name' => 'data_time', 'field_display' => '时间']];
            foreach ($fields as $field)
            {
                $columns[] = $field->toArray();
            }

            $dataArray = UkDeviceData::findByKey($deviceKey)->where([])->all();
        }
        return [
            'columns' => $columns,
            'items' => $dataArray
        ];
    }
}