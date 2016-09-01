<?php
/**
 * Created by PhpStorm.
 * User: healer_kx
 * Date: 2016/8/19
 * Time: 19:48
 */

namespace common\services;

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
        $entry = new UkDeviceData($deviceKey);
        // $data里面应该含有data_time字段
        $entry->setAttributes($data);
        if ($checkAlarm)
        {
            // TODO: Get alarm settings, if alarm set alarm_status=1

        }

        return $entry->save();
    }

    /**
     * @param $deviceKey
     * @return string
     */
    public static function getTableName($deviceKey)
    {
        return "uk_device_data_{$deviceKey}";
    }

    /**
     * @param $tableName
     * @param $typeId
     * @return bool
     */
    public static function createDeviceDataTable($tableName, $typeId)
    {
        $migration = new Migration();

        // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $fields = ['data_id' => $migration->primaryKey()];

        $fields = self::addDeviceDataFields($fields, $migration, $typeId);

        $fields = array_merge($fields, [
            'alarm_status' => $migration->tinyInteger()->notNull()->defaultValue(0)->comment('状态|0:正常,1:触发警报,2:警报已处理'),
            'status' => $migration->tinyInteger()->notNull()->defaultValue(0)->comment('状态|0:无效,1:有效'),
            'create_time' => $migration->dateTime()->notNull()->defaultValue(0)->comment('创建时间'),
            'update_time' => $migration->dateTime()->notNull()->defaultValue(0)->comment('修改时间'),
        ]);

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
     * @param $migration
     * @param $typeId
     * @return mixed
     */
    public static function addDeviceDataFields($fields, $migration, $typeId)
    {

        return $fields;
    }

    /**
     * @param $fileName
     * @param $columns
     * @param $params
     */
    public static function exportToFile($fileName, $columns, $params)
    {

    }
}