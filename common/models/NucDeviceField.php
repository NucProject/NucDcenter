<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nuc_device_field".
 *
 * @property integer $field_id
 * @property string $type_key
 * @property integer $field_value_type
 * @property string $field_value_default
 * @property string $field_value_property
 * @property string $field_name
 * @property string $field_display
 * @property string $field_desc
 * @property string $field_unit
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class NucDeviceField extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nuc_device_field';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['field_value_type', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['type_key', 'field_value_property', 'field_name'], 'string', 'max' => 64],
            [['field_value_default', 'field_display'], 'string', 'max' => 32],
            [['field_desc'], 'string', 'max' => 255],
            [['field_unit'], 'string', 'max' => 8],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'field_id' => 'Field ID',
            'type_key' => '设备类型KEY',
            'field_value_type' => '类型',
            'field_value_default' => '默认值',
            'field_value_property' => '字段值属性',
            'field_name' => '字段名',
            'field_display' => '字段显示名称',
            'field_desc' => '字段描述',
            'field_unit' => '单位',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return NucDeviceFieldQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NucDeviceFieldQuery(get_called_class());
    }
}
