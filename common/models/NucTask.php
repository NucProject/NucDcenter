<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "nuc_task".
 *
 * @property integer $task_id
 * @property integer $task_type
 * @property string $task_name
 * @property string $task_desc
 * @property string $task_image
 * @property string $lng
 * @property string $lat
 * @property integer $map_zoom
 * @property integer $begin_type
 * @property string $begin_set_time
 * @property string $begin_time
 * @property string $end_set_time
 * @property string $end_time
 * @property integer $task_status
 * @property integer $task_end_reason
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class NucTask extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nuc_task';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['task_type', 'map_zoom', 'begin_type', 'task_status', 'task_end_reason', 'status'], 'integer'],
            [['lng', 'lat'], 'number'],
            [['begin_set_time', 'begin_time', 'end_set_time', 'end_time', 'create_time', 'update_time'], 'safe'],
            [['task_name', 'task_image'], 'string', 'max' => 255],
            [['task_desc'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'task_id' => 'Task ID',
            'task_type' => 'Task Type',
            'task_name' => 'Task Name',
            'task_desc' => 'Task Desc',
            'task_image' => 'Task Image',
            'lng' => 'Lng',
            'lat' => 'Lat',
            'map_zoom' => 'Map Zoom',
            'begin_type' => 'Begin Type',
            'begin_set_time' => 'Begin Set Time',
            'begin_time' => 'Begin Time',
            'end_set_time' => 'End Set Time',
            'end_time' => 'End Time',
            'task_status' => 'Task Status',
            'task_end_reason' => 'Task End Reason',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return NucTaskQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NucTaskQuery(get_called_class());
    }
}
