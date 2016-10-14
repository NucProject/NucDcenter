<?php

namespace common\models;

use common\services\DeviceDataService;
use Yii;

/**
 * This is the model class for table "uk_device_data_{$deviceKey}".
 *
 * @property integer    $data_id
 * @property integer    $task_id
 * @property integer    $status
 * @property string     $data_time
 * @property string     $create_time
 * @property string     $update_time
 */
class UkDeviceData extends BaseModel
{
    static $deviceKey = false;

    static $avg = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return DeviceDataService::getTableName(self::$deviceKey, self::$avg);
    }

    /**
     * @inheritdoc
     * @return NucDataCenterQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NucDataCenterQuery(get_called_class());
    }

    /**
     * @param $deviceKey
     * @param $avg = false
     * @return NucDataCenterQuery the active query used by this AR class.
     */
    public static function findByKey($deviceKey, $avg=false)
    {
        self::$deviceKey = $deviceKey;
        self::$avg = $avg;
        return static::find();
    }
}
