<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nuc_device".
 *
 * @property integer $device_id
 * @property integer $type_id
 * @property integer $center_id
 * @property string $station_key
 * @property string $type_key
 * @property string $device_key
 * @property string $type_name
 * @property integer $is_movable
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
            [['type_id', 'center_id', 'is_movable', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['station_key', 'type_key', 'device_key'], 'string', 'max' => 32],
            [['type_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'device_id' => '设备ID',
            'type_id' => '设备类型ID',
            'center_id' => '所属数据中心ID',
            'station_key' => '所属自动站唯一KEY',
            'type_key' => 'Type Key',
            'device_key' => '设备唯一key',
            'type_name' => '设备类型',
            'is_movable' => '是否是移动设备',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
