<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kx_admin_role_access".
 *
 * @property integer $access_id
 * @property integer $role_id
 * @property integer $node_id
 * @property integer $menu_id
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class KxAdminRoleAccess extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kx_admin_role_access';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'node_id', 'menu_id', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'access_id' => 'Access ID',
            'role_id' => 'Role ID',
            'node_id' => 'Node ID',
            'menu_id' => 'Menu ID',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @inheritdoc
     * @return KxAdminRoleAccessQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KxAdminRoleAccessQuery(get_called_class());
    }


    public function getNode()
    {
        return $this->hasOne(KxAdminNode::className(), ['node_id' => 'node_id']);
    }
}
