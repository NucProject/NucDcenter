<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/19
 * Time: 19:48
 */

namespace common\services;

use common\components\Heatmap;
use common\models\NucDeviceField;
use common\models\NucDeviceType;
use yii;
use yii\base;
use yii\data\Pagination;
use yii\db\Migration;
use common\models\UkDeviceData;

class DeviceDataService
{
    /**
     * @param $deviceKey    string
     * @param $data         array
     * @param $checkAlarm   boolean
     * @return bool
     */
    public static function addEntry($deviceKey, $data, $checkAlarm=true)
    {
        $entry = new UkDeviceData();
        // $data里面应该含有data_time字段
        $entry->setAttributes($data);
        if ($checkAlarm)
        {
            // TODO: Get alarm settings, if alarm set alarm_status=1

        }

        return $entry->save();
    }

    public static function updateAvgEntry($deviceKey, $data)
    {
        UkDeviceData::$deviceKey = $deviceKey;
        UkDeviceData::$avg = true;

        $dataTime = $data['data_time'];
        $entry = UkDeviceData::find()->where(['data_time' => $dataTime])->one();

        // $entry->setAttributes($data); // 因为安全问题，需要设置rules才能使用
        foreach ($data as $field => $value)
        {
            if (in_array($field, ['lng', 'lat', 'lng_gps', 'lat_gps']))
            {
                $value = $value ?: '0.0';
            }
            $entry->$field = $value;
        }
        return $entry->save($data);
    }

    /**
     * @param $deviceKey
     * @param $avg boolean
     * @return string
     */
    public static function getTableName($deviceKey, $avg=false)
    {
        if ($avg) {
            return "uk_device_data_{$deviceKey}_avg";
        } else {
            return "uk_device_data_{$deviceKey}";
        }
    }

    /**
     * @param $deviceKey
     * @param $beginTime
     * @param $endTime
     * @return array
     */
    public static function itemsArray($deviceKey, $beginTime, $endTime)
    {
        // ? ???
        $items = UkDeviceData::findByKey($deviceKey)
            ->select('avg(inner_doserate) as inner_doserate, avg(outer_doserate) as outer_doserate, lng, lat, lng_gps, lat_gps')
            ->where(['>', 'data_time', $beginTime])
            ->andWhere(['<', 'data_time', $endTime])
            ->asArray()
            ->one();

        return $items;
    }

    /**
     * @param $deviceKey
     * @return \common\models\UkDeviceData
     */
    public static function lastEntry($deviceKey)
    {
        $entry = UkDeviceData::findByKey($deviceKey, true)->orderBy('data_id desc')->limit(1)->one();
        return $entry;
    }

    /**
     * @param $deviceKey
     * @param array $options [totalCount|pageSize]
     * @return array|\common\models\NucDataCenter[]
     * 支持分页的设备数据获取
     */
    public static function getDataList($deviceKey, $options=[])
    {
        $condition = [];
        // List取均值
        $query = UkDeviceData::findByKey($deviceKey, true)->where($condition);

        // 如果调用者给出totalCount, 那么就省略了select count(*);
        $totalCount = static::getOptionValue($options, 'totalCount', 0);
        if ($totalCount == 0)
        {
            $countQuery = clone $query;
            $totalCount = $countQuery->count();
        }

        $pager = new Pagination(['totalCount' => $totalCount]);
        $pageSize = static::getOptionValue($options, 'pageSize', 50);
        $pager->pageSize = $pageSize;
        $page = static::getOptionValue($options, 'page', 1);
        $pager->setPage($page - 1, true);

        $dataList = $query->offset($pager->offset)
            ->limit($pager->limit)
            ->asArray()
            ->orderBy('data_time desc')
            ->all();

        return [
            'items' => $dataList,
            'pager' => PagerService::getPager($pager->getPageCount(), $pager->getPage() + 1)];
    }

    public static function getOptionValue($options, $key, $defaultValue)
    {
        if (array_key_exists($key, $options)) {
            return $options[$key];
        }
        return $defaultValue;
    }

    /**
     * @param $deviceKey
     * @param $taskId
     * @param bool|false $options
     * @return array|\common\models\NucDataCenter[]
     * @comment 等到应急设备的任务数据(1min均值表取值)
     */
    public static function getTaskData($deviceKey, $taskId, $options=false)
    {
        // 任务数据不取均值的(可能就没有均值的)
        $query = UkDeviceData::findByKey($deviceKey, false)
            ->where(['task_id' => $taskId]);

        $items = $query->asArray()->all();

        $items = Heatmap::refresh($items);
        file_put_contents("d:\\lines", json_encode($items));

        return $items;
    }

    /**
     * @param $deviceKey
     * @param $typeKey
     * @param $createAvgTable
     * @return bool
     */
    public static function createDeviceDataTables($deviceKey, $typeKey, $createAvgTable=true)
    {
        // data table
        $tableName = DeviceDataService::getTableName($deviceKey);
        if (DeviceDataService::isTableExists($tableName))
        {
            echo "The device-data table exists!\n";
            return false;
        }

        $r1 = DeviceDataService::createDeviceDataTable($tableName, $typeKey);
        if (!$createAvgTable) {
            return true;
        }

        // Avg table!
        $tableName = DeviceDataService::getTableName($deviceKey, true);
        if (DeviceDataService::isTableExists($tableName))
        {
            echo "The device-data avg table exists!\n";
            return false;
        }

        $r2 = DeviceDataService::createDeviceDataTable($tableName, $typeKey);

        return $r1 && $r2;
    }



    /**
     * @param $tableName
     * @param $typeKey
     * @return bool
     */
    public static function createDeviceDataTable($tableName, $typeKey)
    {
        $migration = new Migration();

        // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $fields = ['data_id' => $migration->primaryKey()];

        $deviceType = NucDeviceType::find()->where(['type_key' => $typeKey])->one();
        if (!$deviceType) {
            // Device not exists
            return false;
        }

        $fields = self::addDeviceDataFields($fields, $migration, $typeKey, $deviceType->is_movable);

        $fixedFields = [
            'alarm_status'  => $migration->tinyInteger()->notNull()->defaultValue(0)->comment('状态|0:正常,1:触发警报,2:警报已处理'),
            'status'        => $migration->tinyInteger()->notNull()->defaultValue(0)->comment('状态|0:无效,1:有效'),
            'data_time'     => $migration->dateTime()->notNull()->defaultValue(0)->comment('数据设备时间'),
            'create_time'   => $migration->dateTime()->notNull()->defaultValue(0)->comment('创建时间'),
            'update_time'   => $migration->dateTime()->notNull()->defaultValue(0)->comment('修改时间'),
        ];

        $fields = $fields + $fixedFields;

        // Hacking!
        // Otherwise $fieldBuilder->double([10, 5]) would lost $precision info
        // See QueryBuilder::getColumnType Line 668
        Yii::$app->db->getQueryBuilder()->typeMap[yii\db\mysql\Schema::TYPE_DOUBLE] = 'double(10, 4)';

        $migration->createTable($tableName, $fields, $tableOptions);
        return true;
    }

    /**
     * @param $tableName
     * @return bool
     */
    public static function isTableExists($tableName)
    {
        $checkTableExistsSql = "show tables like '{$tableName}';";
        try {
            $command = \Yii::$app->db->createCommand($checkTableExistsSql);
            $r = $command->execute();
            return $r;
        } catch (Exception $exception) {
            var_dump($exception);
            return false;
        }
    }

    /**
     * @param $fields
     * @param $migration Migration
     * @param $typeKey
     * @param $movable
     * @return mixed
     */
    public static function addDeviceDataFields($fields, $migration, $typeKey, $movable=false)
    {
        $dataFields = NucDeviceField::find()->where(['type_key' => $typeKey])->asArray()->all();
        foreach ($dataFields as $dataField)
        {
            $fieldBuilder = $migration;
            // 0 is double
            if ($dataField['field_value_type'] == 0) {
                $fieldBuilder = $fieldBuilder->double([10, 5]);
            }

            $fieldName = $dataField['field_name'];
            $fields[$fieldName] = $fieldBuilder
                ->defaultValue($dataField['field_value_default'])
                ->comment($dataField['field_desc']);
        }

        if ($movable) {
            // For lng and lat, decimal(10, 6) is Good
            $fields['lng'] = $migration->decimal("10, 6")->notNull()->defaultValue('0.0')->comment('MAP经度');
            $fields['lat'] = $migration->decimal("10, 6")->notNull()->defaultValue('0.0')->comment('MAP纬度');
            $fields['gps_lng'] = $migration->decimal("10, 6")->notNull()->defaultValue('0.0')->comment('GPS经度');
            $fields['gps_lat'] = $migration->decimal("10, 6")->notNull()->defaultValue('0.0')->comment('GPS纬度');
        }

        return $fields;
    }

}