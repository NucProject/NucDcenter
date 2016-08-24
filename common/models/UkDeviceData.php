<?php

namespace common\models;

use common\services\DeviceDataService;
use Yii;

/**
 * This is the model class for table "nuc_data_center".
 *
 * @property integer $center_id
 */
class UkDeviceData extends BaseModel
{
    static $deviceKey = false;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return DeviceDataService::tableName(self::$deviceKey);
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
