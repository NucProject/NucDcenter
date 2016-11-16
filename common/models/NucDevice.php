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
 * @property string $device_desc
 * @property integer $is_movable
 * @property string $launch_date
 * @property string $rescale_date
 * @property integer $device_status
 * @property string $device_lng
 * @property string $device_lat
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

    public function getDeviceType()
    {
        return $this->hasOne(NucDeviceType::className(), ['type_key' => 'type_key']);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['center_id', 'is_movable', 'device_status', 'status'], 'integer'],
            [['launch_date', 'rescale_date', 'create_time', 'update_time'], 'safe'],
            [['device_lng', 'device_lat'], 'number'],
            [['station_key', 'type_key', 'device_key'], 'string', 'max' => 32],
            [['device_sn'], 'string', 'max' => 64],
            [['type_name', 'device_desc'], 'string', 'max' => 255],
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
            'device_desc' => 'Device Desc',
            'is_movable' => 'Is Movable',
            'launch_date' => 'Launch Date',
            'rescale_date' => 'Rescale Date',
            'device_status' => 'Device Status',
            'device_lng' => 'Device Lng',
            'device_lat' => 'Device Lat',
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
