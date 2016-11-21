<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nuc_device_alert_setting".
 *
 * @property integer $setting_id
 * @property string $device_key
 * @property string $field_name
 * @property integer $alert_flag
 * @property integer $threshold1_set
 * @property integer $threshold2_set
 * @property double $threshold1
 * @property double $threshold2
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class NucDeviceAlertSetting extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nuc_device_alert_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alert_flag', 'threshold1_set', 'threshold2_set', 'status'], 'integer'],
            [['threshold1', 'threshold2'], 'number'],
            [['create_time', 'update_time'], 'safe'],
            [['device_key'], 'string', 'max' => 32],
            [['field_name'], 'string', 'max' => 64],
        ];
    }

    public function getField()
    {
        return $this->hasOne(NucDeviceField::className(), ['field_name' => 'field_name']);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'setting_id' => 'Setting ID',
            'device_key' => 'Device Key',
            'field_name' => 'Field Name',
            'alert_flag' => 'Alert Flag',
            'threshold1_set' => 'Threshold1 Set',
            'threshold2_set' => 'Threshold2 Set',
            'threshold1' => 'Threshold1',
            'threshold2' => 'Threshold2',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return NucDeviceAlertSettingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NucDeviceAlertSettingQuery(get_called_class());
    }
}
