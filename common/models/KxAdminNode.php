<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kx_admin_node".
 *
 * @property integer $node_id
 * @property string $controller
 * @property string $action
 * @property string $param0
 * @property string $value0
 * @property string $param1
 * @property string $value1
 * @property string $name
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class KxAdminNode extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kx_admin_node';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['controller', 'action'], 'string', 'max' => 100],
            [['param0', 'value0', 'param1', 'value1'], 'string', 'max' => 32],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'node_id' => 'Node ID',
            'controller' => 'Controller',
            'action' => 'Action',
            'param0' => 'Param0',
            'value0' => 'Value0',
            'param1' => 'Param1',
            'value1' => 'Value1',
            'name' => 'Name',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return KxAdminNodeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KxAdminNodeQuery(get_called_class());
    }
}
