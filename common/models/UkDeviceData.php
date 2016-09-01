<?php

namespace common\models;

use common\services\DeviceDataService;
use Yii;

/**
 * This is the model class for table "uk_device_data_{$deviceKey}".
 *
 * @property integer    $data_id
 * @property integer    $status
 * @property string     $create_time
 * @property string     $update_time
 */
class UkDeviceData extends BaseModel
{
    static $deviceKey = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return DeviceDataService::getTableName(self::$deviceKey);
    }

    public function __construct($deviceKey)
    {
        self::$deviceKey = $deviceKey;
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
     * @return NucDataCenterQuery the active query used by this AR class.
     */
    public static function findByKey($deviceKey)
    {
        self::$deviceKey = $deviceKey;
        return static::find();
    }
}
