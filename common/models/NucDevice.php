<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nuc_device".
 *
 * @property integer $device_id
 * @property integer $center_id
 * @property string $station_key
 * @property string $type_key
 * @property string $device_key
 * @property string $device_sn
 * @property string $type_name
 * @property integer $is_movable
 * @property string $launch_date
 * @property string $rescale_date
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class NucDevice extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nuc_device';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['center_id', 'is_movable', 'status'], 'integer'],
            [['launch_date', 'rescale_date', 'create_time', 'update_time'], 'safe'],
            [['station_key', 'type_key', 'device_key'], 'string', 'max' => 32],
            [['device_sn'], 'string', 'max' => 64],
            [['type_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'device_id' => 'Device ID',
            'center_id' => 'Center ID',
            'station_key' => 'Station Key',
            'type_key' => 'Type Key',
            'device_key' => 'Device Key',
            'device_sn' => 'Device Sn',
            'type_name' => 'Type Name',
            'is_movable' => 'Is Movable',
            'launch_date' => 'Launch Date',
            'rescale_date' => 'Rescale Date',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return NucDeviceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NucDeviceQuery(get_called_class());
    }
}
