<?php
/**
 * Created by PhpStorm.
 * User: healerkx
 * Date: 2016/8/23
 * Time: 20:10
 */

namespace frontend\controllers;

use common\components\Cache;
use common\components\Helper;
use common\components\ModelSaveFailedException;
use common\components\ResourceNotFoundException;
use common\models\NucDeviceAlertSetting;
use common\models\UkDeviceData;
use common\services\TaskService;
use yii;
use common\components\AccessForbiddenException;
use common\models\NucDeviceField;
use common\services\DeviceDataService;
use common\services\DeviceService;
use common\services\DeviceTypeService;

class DeviceController extends BaseController
{
    /**
     * @page
     * @comment 设备数据
     * @param $deviceKey
     * @return string
     * @throws AccessForbiddenException
     * 曲线+列表
     */
    public function actionData($deviceKey)
    {
        // 给个默认的搜索时间
        if (!array_key_exists('begin_time', $_GET)) {
            $url = "index.php?r=device/data&deviceKey=$deviceKey&";
            $beginTime = date('Y-m-d H:i:s', time() - 3600 * 24);
            $endTime = date('Y-m-d H:i:s', time());

            $pageSize = isset($_GET['__pageSize']) ? $_GET['__pageSize'] : 288;
            $url .= "begin_time=$beginTime&end_time=$endTime&__pageSize=$pageSize";
            return Yii::$app->response->redirect($url);
        }

        $device = $this->checkDevice($deviceKey);

        // options handler (including Pager)
        $pageSize = Yii::$app->request->get('__pageSize', Yii::$app->params['pageSizeDefault']);
        $page = Yii::$app->request->get('__page');
        $options = ['pageSize' => $pageSize, 'page' => $page,
                    'beginTime' => $_GET['begin_time'],
                    'endTime' => $_GET['end_time']];

        $data = $this->getDeviceData($device, $options);
        $this->handleShowOptions($data);

        $deviceType = DeviceTypeService::getDeviceType($device->type_key);
        $displayFieldName = '';
        foreach ($deviceType->fields as $field)
        {
            if ($field['display_flag'] == 1)
            {
                $displayFieldName = $field->field_name;
                break;
            }
        }
        $deviceName = $data['deviceName'];

        if (!$data['hideChart'])
        {
            $options['showDayCharts'] = true;
            $points = self::convertItemsToPoints(array_reverse($data['items']), $displayFieldName, $options);
            $data['itemPoints'] = $points['points'];
            $data['maxVal'] = $points['maxVal'];
            $data['minVal'] = $points['minVal'];

            $data['chartTitle'] = $deviceName . ' 五分钟曲线';
            $data['displayFieldName'] = $displayFieldName;
        }

        // alert settings!
        $alertSettings = Cache::getDeviceAlertSettings($deviceKey);
        $data['alertSettings'] = json_encode($alertSettings);

        parent::setPageMessage("{$deviceName} 数据曲线图表");
        parent::setBreadcrumbs(['index.html' => '设备', '#' => "{$deviceName}_数据"]);
        return parent::renderPage('data.tpl', $data, ['with' => ['echarts', 'datePicker', 'laydate']]);
    }

    /**
     * @page
     * @comment 移动设备数据
     * @param $deviceKey
     * @param $taskId
     * @return string
     * @throws AccessForbiddenException
     * 曲线+列表
     */
    public function actionMovableData($deviceKey, $taskId)
    {
        $device = $this->checkDevice($deviceKey);

        // options handler (including Pager)
        $pageSize = Yii::$app->request->get('__pageSize', Yii::$app->params['pageSizeDefault']);
        $page = Yii::$app->request->get('__page');
        $options = ['pageSize' => $pageSize, 'page' => $page];

        $data = $this->getDeviceTaskData($device, $taskId, $options);
        $this->handleShowOptions($data);

        $deviceType = DeviceTypeService::getDeviceType($device->type_key);
        $displayFieldName = '';
        foreach ($deviceType->fields as $field)
        {
            if ($field['display_flag'] == 1)
            {
                $displayFieldName = $field->field_name;
                break;
            }
        }
        $deviceName = $data['deviceName'];

        if (!$data['hideChart'])
        {
            $points = self::convertItemsToPoints(array_reverse($data['items']), $displayFieldName);
            $data['itemPoints'] = $points['points'];
            $data['maxVal'] = $points['maxVal'];
            $data['minVal'] = $points['minVal'];

            $data['chartTitle'] = $deviceName . ' 曲线';
            $data['displayFieldName'] = $displayFieldName;
        }

        $data['attends'] = TaskService::getTasksByDevice($deviceKey);
        $data['currentTaskId'] = $taskId;

        parent::setPageMessage("{$deviceName} 数据曲线图表");
        parent::setBreadcrumbs(['index.html' => '设备', '#' => "{$deviceName}_数据"]);
        return parent::renderPage('movable-data.tpl', $data, ['with' => ['echarts', 'datePicker', 'laydate']]);
    }

    /**
     * @page
     * @comment 移动设备数据
     * @param $deviceKey
     * @return string
     * @throws AccessForbiddenException
     * 移动便携设备的实时曲线+列表
     */
    public function actionActiveData($deviceKey)
    {
        $device = $this->checkDevice($deviceKey);

        // options handler (including Pager)
        $pageSize = Yii::$app->request->get('__pageSize', Yii::$app->params['pageSizeDefault']);
        $page = Yii::$app->request->get('__page');
        $options = ['pageSize' => $pageSize, 'page' => $page];

        $data = $this->getDeviceRecentData($device, $options);
        $this->handleShowOptions($data);

        $deviceType = DeviceTypeService::getDeviceType($device->type_key);
        $displayFieldName = '';
        foreach ($deviceType->fields as $field)
        {
            if ($field['display_flag'] == 1)
            {
                $displayFieldName = $field->field_name;
                break;
            }
        }
        $deviceName = $data['deviceName'];

        if (!$data['hideChart'])
        {
            $points = self::convertItemsToPoints(array_reverse($data['items']), $displayFieldName);
            $data['itemPoints'] = $points['points'];
            $data['maxVal'] = $points['maxVal'];
            $data['minVal'] = $points['minVal'];

            $data['displayFieldName'] = $displayFieldName;
            $data['chartTitle'] = $deviceName . ' 曲线';
        }

        // alert settings!
        $alertSettings = Cache::getDeviceAlertSettings($deviceKey);
        $data['alertSettings'] = json_encode($alertSettings);

        $data['attends'] = TaskService::getTasksByDevice($deviceKey);

        parent::setPageMessage("{$deviceName} 实时数据曲线图表");
        parent::setBreadcrumbs(['index.html' => '设备', '#' => "{$deviceName}_实时数据"]);
        return parent::renderPage('movable-data.tpl', $data, ['with' => ['echarts', 'datePicker', 'laydate']]);
    }

    /**
     * @page
     * @comment 设备详情
     * @param $deviceKey
     * @return string
     * @throws AccessForbiddenException
     * 曲线+列表
     */
    public function actionInfo($deviceKey)
    {
        $device = $this->checkDevice($deviceKey);

        $data = [];
        $data['device'] = $device;
        $data['tasks'] = TaskService::getTasksByDevice($device['device_key']);

        parent::setPageMessage($device['type_name'] . ' 设备信息');
        parent::setBreadcrumbs(['index.html' => '设备', '#' => '信息']);
        return parent::renderPage('info.tpl', $data, ['with' => ['echarts', 'datePicker', 'laydate']]);
    }

    /**
     * @param $deviceKey
     * @return string
     */
    public function actionModify($deviceKey)
    {
        $device = $this->checkDevice($deviceKey);

        $data = [
            'doModifyUrl'           => 'index.php?r=device/do-modify&deviceKey=' . $deviceKey,
            'deviceKey'             => $deviceKey,
            'device'                => $device->toArray(),

            'deviceSn'              => $device->device_sn,
            'deviceTypeKey'         => $device->type_key,
            'deviceTypeName'        => $device->type_name,
        ];

        parent::setPageMessage($device['type_name'] . ' 修改设备信息');
        parent::setBreadcrumbs(['index.html' => '设备', '#' => '修改设备信息']);
        return parent::renderPage('modify.tpl', $data, ['with' => ['dialog', 'echarts', 'datePicker', 'laydate']]);
    }

    public function actionDoModify($deviceKey) {

        $device = $this->checkDevice($deviceKey);

        if ($device) {
            $launchDate = Helper::getPost('launch_date', []);
            if ($launchDate) {
                $device->launch_date = $launchDate;
            }

            $rescaleDate = Helper::getPost('rescale_date', []);
            if ($rescaleDate) {
                $device->rescale_date = $rescaleDate;
            }

            $device->device_desc = Helper::getPost('device_desc', []);

            if ($device->save()) {
                if ($device->is_movable) {
                    // 移动设备去数据中心的移动设备列表
                    return $this->redirect(array('data-center/movable-devices'));
                } else {
                    // 去该设备自己所在的自动站的设备列表
                    return $this->redirect(array('station/index', 'stationKey' => $device->station_key));
                }
            } else {
                throw new ModelSaveFailedException($device->getErrors());
            }
        }

        throw new ResourceNotFoundException('Invalid deviceKey');
    }

    public function actionDelete($deviceKey)
    {
        $device = $this->checkDevice($deviceKey);

        if ($device) {
            $stationKey = $device->station_key;
            $device->status = 0; // Soft delete

            if ($device->save()) {
                if ($device->is_movable) {
                    // 移动设备去数据中心的移动设备列表
                    return $this->redirect(array('data-center/movable-devices'));
                } else {
                    // 去该设备自己所在的自动站的设备列表
                    return $this->redirect(array('station/index', 'stationKey' => $stationKey));
                }
            } else {
                throw new ModelSaveFailedException($device->getErrors());
            }
        }

        throw new ResourceNotFoundException('Invalid deviceKey');
    }

    public function actionThreshold($deviceKey)
    {
        $device = $this->checkDevice($deviceKey);

        if ($device) {
            $data = ['deviceKey' => $deviceKey];
            $data['device'] = $device;

            // 第一次设置阈值的时候在nuc_device_alert_setting表中insert, 以后update
            $settings = NucDeviceAlertSetting::find()
                ->where(['device_key' => $deviceKey])
                ->with('field')
                ->asArray()
                ->all();

            if (!$settings) {
                $typeKey = $device->type_key;
                $fields = NucDeviceField::find()->where(['type_key' => $typeKey])->asArray()->all();

                foreach ($fields as $field) {
                    if ($field['alert_flag'] == 0) {
                        continue;
                    }

                    $setting = new NucDeviceAlertSetting();
                    $setting->device_key = $deviceKey;
                    $setting->field_name = $field['field_name'];
                    $setting->alert_flag = $field['alert_flag'];
                    $setting->save();
                }

                $settings = NucDeviceAlertSetting::find()
                    ->where(['device_key' => $deviceKey])
                    ->with('field')
                    ->asArray()
                    ->all();
            }

            foreach ($settings as &$s)
            {
                $field = $s['field'];
                $s['fieldDisplayName'] = $field['field_display'] . "({$field['field_name']})";
            }

            $data['settings'] = $settings;

            parent::setPageMessage($device['type_name'] . ' 修改设备阈值');
            parent::setBreadcrumbs(['index.html' => '设备', '#' => '修改设备阈值']);
            return parent::renderPage('threshold.tpl', $data, ['with' => ['dialog', 'echarts']]);
        }

        throw new ResourceNotFoundException('Invalid deviceKey');
    }

    public static function hasThresholdSet($post, $key) {
        return array_key_exists($key, $post) && $post[$key] == 'on';
    }

    /**
     * @param $deviceKey
     * @param $fieldName
     * @return NucDeviceAlertSetting
     * 单纯是为了IDE可以识别字段
     */
    private static function getAlertSetting($deviceKey, $fieldName)
    {
        return NucDeviceAlertSetting::findOne(['device_key' => $deviceKey, 'field_name' => $fieldName]);
    }

    public function actionSetThreshold($deviceKey)
    {
        $device = $this->checkDevice($deviceKey);

        if ($device) {
            foreach ($_POST as $fieldName => $values) {
                $fieldSetting = self::getAlertSetting($deviceKey, $fieldName);
                if ($fieldSetting) {
                    $fieldSetting->threshold1_set = 0;
                    $fieldSetting->threshold2_set = 0;

                    if (self::hasThresholdSet($values, 'threshold1_set'))
                    {
                        $fieldSetting->threshold1_set = 1;
                        $fieldSetting->threshold1 = $values['threshold1'];
                    }

                    // 某些报警类型不需要threshold2
                    if (self::hasThresholdSet($values, 'threshold2_set'))
                    {
                        $fieldSetting->threshold2_set = 1;
                        $fieldSetting->threshold2 = $values['threshold2'];
                    }
                    $fieldSetting->save();

                    // 清理缓存, 否则页面从Redis里面拿阈值
                    Cache::delDeviceAlertSettings($deviceKey);
                }
            }

            if ($device->is_movable) {
                // 移动设备去数据中心的移动设备列表
                return $this->redirect(array('data-center/movable-devices'));
            } else {
                // 去该设备自己所在的自动站的设备列表
                $stationKey = $device->station_key;
                return $this->redirect(array('station/index', 'stationKey' => $stationKey));
            }
        }

        throw new ResourceNotFoundException('Invalid deviceKey');
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

        $options['condition'] = [];
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

    /**
     * @param $device \common\models\NucDevice
     * @param $options
     * @param $taskId
     * @return array
     * @throws AccessForbiddenException
     */
    private function getDeviceTaskData($device, $taskId, $options)
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

        $options['non-avg'] = true;
        $options['condition'] = ['task_id' => $taskId];
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

    /**
     * @param $device \common\models\NucDevice
     * @param $options
     * @return array
     * @throws AccessForbiddenException
     * 得到设备最新的数据
     */
    private function getDeviceRecentData($device, $options)
    {
        if (!$device) {
            return [];
        }
        $typeKey = $device->type_key;

        $deviceType = DeviceTypeService::getDeviceType($typeKey);

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

        // $result = DeviceDataService::getDataList($deviceKey, $options);
        $items = UkDeviceData::findByKey($deviceKey, false)
            ->where(['task_id' => 0])
            ->asArray()
            ->orderBy('data_time desc')
            ->limit(100)
            ->all();

        return [
            'deviceKey' => $deviceKey,
            'deviceName' => $deviceType->type_name,
            'columns' => $columns,
            'items' => $items,
            'pager' => 1,
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
     * @param $options
     * @return string
     * 曲线要考虑时间连续性，没有值的点，也要给null值
     */
    private static function convertItemsToPoints($data, $field, $options=[])
    {
        //var_dump($options);exit;
        $points = [];
        if (array_key_exists('showDayCharts', $options)) {
            self::makePointsPadding($points, $options);
        }

        $first = self::getFirstNotNullValue($data, $field);
        $minVal = $maxVal = $first;
        foreach ($data as $i)
        {
            $dataTime = $i['data_time'];
            $val = $i[$field];
            $points[$dataTime] = [$dataTime, $val];
            $maxVal = max($val, $maxVal);
            if ($val)
            {
                $minVal = min($val, $minVal);
            }
        }

        usort($points, function($a, $b) {
            if ($a[0] == $b[0]) return 0;
            elseif ($a[0] < $b[0]) return -1;
            return 1;
        });

        $points = array_values($points);
        //var_dump($points);exit;

        return [
            'points' => json_encode($points),
            'maxVal' => $maxVal ?: '0.0',
            'minVal' => $minVal ?: '0.0'
        ];
    }

    private static function makePointsPadding(&$points, $options)
    {
        $beginTime = strtotime(Helper::regular5mTime($options['beginTime']));
        $endTime = strtotime(Helper::regular5mTime($options['endTime']));
        for ($time = $beginTime; $time < $endTime; $time += 300)
        {
            $timeStr = date('Y-m-d H:i:s', $time);
            $points[$timeStr] = [$timeStr, null];
        }
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