<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kx_admin_role".
 *
 * @property integer $role_id
 * @property string $role_name
 * @property string $role_desc
 * @property integer $enabled
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class KxAdminRole extends \common\models\BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kx_admin_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enabled', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['role_name'], 'string', 'max' => 32],
            [['role_desc'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role_id' => '角色id',
            'role_name' => '角色名',
            'role_desc' => '角色描述',
            'enabled' => '是否使用',
            'status' => '状态',
            'create_time' => '创建时间',
            'update_time' => '最后更新时间',
        ];
    }

    /**
     * @inheritdoc
     * @return KxAdminRoleQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new KxAdminRoleQuery(get_called_class());
    }
}
