<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nuc_task_attend".
 *
 * @property integer $attend_id
 * @property integer $task_id
 * @property string $device_key
 * @property string $attend_name
 * @property integer $data_id_begin
 * @property integer $data_id_end
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class NucTaskAttend extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nuc_task_attend';
    }

    public function getDevice()
    {
        return $this->hasOne(NucDevice::className(), ['device_key' => 'device_key']);

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_id', 'attend_name'], 'required'],
            [['task_id', 'data_id_begin', 'data_id_end', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['device_key'], 'string', 'max' => 32],
            [['attend_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'attend_id' => 'Attend ID',
            'task_id' => 'Task ID',
            'device_key' => 'Device Key',
            'attend_name' => 'Attend Name',
            'data_id_begin' => 'Data Id Begin',
            'data_id_end' => 'Data Id End',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return NucTaskAttendQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NucTaskAttendQuery(get_called_class());
    }
}
