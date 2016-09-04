<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kx_admin_node".
 *
 * @property integer $node_id
 * @property string $controller
 * @property string $action
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
            'name' => 'Name',
            'status' => 'Status',
            'create_time' => '创建时间',
            'update_time' => '最后更新时间',
        ];
    }
}
