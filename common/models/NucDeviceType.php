<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nuc_device_type".
 *
 * @property integer $type_id
 * @property string $type_key
 * @property string $type_name
 * @property string $type_desc
 * @property string $type_pic
 * @property integer $data_interval
 * @property integer $is_movable
 * @property integer $time_normalized
 * @property integer $using_serialport
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class NucDeviceType extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nuc_device_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data_interval', 'is_movable', 'time_normalized', 'using_serialport', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['type_key'], 'string', 'max' => 64],
            [['type_name', 'type_desc', 'type_pic'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'type_id' => '设备类型ID',
            'type_key' => '设备标准名称',
            'type_name' => '设备名称',
            'type_desc' => '设备描述',
            'type_pic' => '设备图片',
            'data_interval' => '数据间隔',
            'is_movable' => '移动设备',
            'time_normalized' => '使用归一化时间',
            'using_serialport' => '使用串口',
            'status' => '状态',
            'create_time' => '更新时间',
            'update_time' => '修改时间',
        ];
    }

    /**
     * @inheritdoc
     * @return NucDeviceTypeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NucDeviceTypeQuery(get_called_class());
    }
}
